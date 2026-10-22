<?php

namespace App\Services\Pluggy;

use App\Models\PluggyAccount;
use App\Models\PluggyItem;
use App\Models\PluggyTransaction;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;
use Throwable;

class PluggySyncService
{
    public function __construct(
        private readonly PluggyService $pluggy,
        private readonly PluggyTransactionImporter $importer,
        private readonly InternalTransferMatcher $transferMatcher,
    ) {
    }

    /** @return array{accounts: int, created: int, updated: int, transfers: int, status: string} */
    public function sync(PluggyItem $connection, bool $requestRemoteSync = false): array
    {
        $connection->update(['last_sync_started_at' => now(), 'last_sync_status' => 'running', 'last_error' => null]);
        Log::info('Sincronização Pluggy iniciada.', ['connection_id' => $connection->id]);

        try {
            $item = $this->pluggy->getItem($connection->pluggy_item_id);

            // O conector MeuPluggy expõe os dados já prontos, mas rejeita PATCH /items.
            // Para ele, uma sincronização manual significa apenas importar o estado atual.
            if ($requestRemoteSync && ! $this->isMeuPluggy($item)) {
                $item = $this->pluggy->syncItem($connection->pluggy_item_id);
            }

            $this->updateConnectionFromItem($connection, $item);

            if (($item['executionStatus'] ?? null) && ($item['executionStatus'] ?? null) !== 'SUCCESS') {
                $connection->update(['last_sync_status' => 'awaiting_provider']);

                return ['accounts' => 0, 'created' => 0, 'updated' => 0, 'transfers' => 0, 'status' => 'awaiting_provider'];
            }

            $remoteAccounts = $this->pluggy->getAccountsForItem($connection->pluggy_item_id);
            $remoteAccountIds = [];
            $created = 0;
            $updated = 0;

            foreach ($remoteAccounts as $remoteAccount) {
                $account = $this->upsertAccount($connection, $remoteAccount);
                $remoteAccountIds[] = $account->pluggy_account_id;
                $result = $this->importer->import($connection, $account, $this->pluggy->getTransactions($account->pluggy_account_id));
                $created += $result['created'];
                $updated += $result['updated'];
            }

            $connection->accounts()
                ->where('user_id', $connection->user_id)
                ->when($remoteAccountIds !== [], fn ($query) => $query->whereNotIn('pluggy_account_id', $remoteAccountIds))
                ->update(['is_active' => false]);

            $transfers = $this->transferMatcher->matchForUser($connection->user_id);
            $connection->update(['last_synced_at' => now(), 'last_sync_status' => 'success', 'last_error' => null]);

            Log::info('Sincronização Pluggy concluída.', [
                'connection_id' => $connection->id,
                'accounts' => count($remoteAccounts),
                'created' => $created,
                'updated' => $updated,
                'internal_transfers' => $transfers,
            ]);

            return ['accounts' => count($remoteAccounts), 'created' => $created, 'updated' => $updated, 'transfers' => $transfers, 'status' => 'success'];
        } catch (RequestException $exception) {
            $this->markFailed($connection, 'A Pluggy não respondeu à sincronização.', $exception->response?->status());
            throw $exception;
        } catch (Throwable $exception) {
            $this->markFailed($connection, 'Não foi possível concluir a sincronização.', null);
            throw $exception;
        }
    }

    public function markTransactionsDeleted(string $pluggyItemId, array $transactionIds): int
    {
        return PluggyTransaction::query()
            ->whereHas('connection', fn ($query) => $query->where('pluggy_item_id', $pluggyItemId)->whereColumn('pluggy_items.user_id', 'pluggy_transactions.user_id'))
            ->whereIn('pluggy_transaction_id', $transactionIds)
            ->update(['removed_at' => now(), 'affects_totals' => false]);
    }

    /** @param array<string, mixed> $item */
    private function updateConnectionFromItem(PluggyItem $connection, array $item): void
    {
        $connector = $item['connector'] ?? [];
        $connection->update([
            'connector_id' => $connector['id'] ?? $connection->connector_id,
            'connector_name' => $connector['name'] ?? $connection->connector_name,
            'connector_image_url' => $connector['imageUrl'] ?? $connection->connector_image_url,
            'status' => $item['status'] ?? $connection->status,
            'execution_status' => $item['executionStatus'] ?? $connection->execution_status,
            'last_event' => (($item['status'] ?? null) === 'UPDATED') ? 'item/updated' : $connection->last_event,
            'last_error' => data_get($item, 'error.message') ?? data_get($item, 'error.description'),
            'is_active' => true,
        ]);
    }

    /** @param array<string, mixed> $remoteAccount */
    private function upsertAccount(PluggyItem $connection, array $remoteAccount): PluggyAccount
    {
        $existing = $connection->accounts()->where('pluggy_account_id', $remoteAccount['id'])->first();
        if ($existing && (int) $existing->user_id !== (int) $connection->user_id) {
            throw new \LogicException('A conta existente não pertence ao proprietário da conexão.');
        }

        return PluggyAccount::query()->updateOrCreate(
            ['pluggy_connection_id' => $connection->id, 'pluggy_account_id' => $remoteAccount['id']],
            [
                'user_id' => $connection->user_id,
                'name' => $remoteAccount['name'] ?? 'Conta conectada',
                'type' => $remoteAccount['type'] ?? 'BANK',
                'subtype' => $remoteAccount['subtype'] ?? null,
                'number_last_four' => $this->lastFour($remoteAccount['number'] ?? null),
                'currency_code' => $remoteAccount['currencyCode'] ?? 'BRL',
                'balance' => $remoteAccount['balance'] ?? 0,
                'owner_document_hash' => $this->fingerprint($remoteAccount['taxNumber'] ?? null),
                'account_number_hash' => $this->fingerprint($remoteAccount['number'] ?? null),
                'routing_number_hash' => $this->fingerprint(data_get($remoteAccount, 'bankData.transferNumber')),
                'is_active' => true,
                'last_synced_at' => now(),
            ],
        );
    }

    private function lastFour(?string $number): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $number);

        return $digits ? substr($digits, -4) : null;
    }

    private function fingerprint(?string $value): ?string
    {
        $normalized = preg_replace('/\D/', '', (string) $value);

        return $normalized ? hash_hmac('sha256', $normalized, (string) config('app.key')) : null;
    }

    private function markFailed(PluggyItem $connection, string $message, ?int $status): void
    {
        $connection->update(['last_sync_status' => 'failed', 'last_error' => $message]);
        Log::warning('Sincronização Pluggy falhou.', ['connection_id' => $connection->id, 'status' => $status]);
    }

    /** @param array<string, mixed> $item */
    private function isMeuPluggy(array $item): bool
    {
        return str_contains(strtolower((string) data_get($item, 'connector.name')), 'meupluggy');
    }
}
