<?php

namespace App\Services\Pluggy;

use App\Models\PluggyAccount;
use App\Models\PluggyItem;
use App\Models\PluggyTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PluggyTransactionImporter
{
    public function __construct(
        private readonly PluggyTransactionClassifier $classifier,
        private readonly PluggyCategoryMapper $categoryMapper,
        private readonly PluggyTransactionRuleService $ruleService,
    ) {
    }

    /** @param list<array<string, mixed>> $transactions
     *  @return array{created: int, updated: int}
     */
    public function import(PluggyItem $connection, PluggyAccount $account, array $transactions): array
    {
        $created = 0;
        $updated = 0;

        DB::transaction(function () use ($connection, $account, $transactions, &$created, &$updated): void {
            foreach ($transactions as $transaction) {
                if (! isset($transaction['id'])) {
                    continue;
                }

                $description = mb_substr((string) ($transaction['description'] ?? 'Movimentação bancária'), 0, 500);
                $classification = $this->ruleService->apply(
                    $connection->user_id,
                    $description,
                    $transaction['descriptionRaw'] ?? null,
                    $this->classifier->classify($transaction, $account->type),
                );
                $existing = $this->findExisting($connection->user_id, $transaction);
                // Uma exclusão feita pelo usuário é local e deve sobreviver às próximas sincronizações.
                if ($existing?->deleted_by_user_at) {
                    $updated++;
                    continue;
                }

                $categoryId = $existing?->category_source === 'user'
                    ? $existing->category_id
                    : $this->categoryMapper->resolve(
                        $connection->user_id,
                        $this->categoryType($classification['classification']),
                        $transaction['category'] ?? null,
                    );

                $metadata = $transaction['creditCardMetadata'] ?? [];
                $status = strtoupper((string) ($transaction['status'] ?? 'POSTED'));
                $affectsTotals = $this->shouldAffectTotals($classification, $status, $account->type);
                $values = [
                    'user_id' => $connection->user_id,
                    'pluggy_connection_id' => $connection->id,
                    'pluggy_account_id' => $account->id,
                    'pluggy_transaction_id' => $transaction['id'],
                    'provider_id' => $transaction['providerId'] ?? null,
                    'provider_code' => $transaction['providerCode'] ?? null,
                    'description' => $existing?->user_modified_description ? $existing->description : $description,
                    'description_raw' => $transaction['descriptionRaw'] ?? null,
                    'transaction_date' => $existing?->user_modified_date
                        ? $existing->transaction_date->toDateString()
                        : $this->date($transaction['date'] ?? null)->toDateString(),
                    'transaction_at' => $this->date($transaction['date'] ?? null),
                    'amount' => abs((float) ($transaction['amount'] ?? 0)),
                    'currency_code' => $transaction['currencyCode'] ?? $account->currency_code,
                    'direction' => $transaction['type'] ?? null,
                    'status' => $status,
                    'operation_type' => $transaction['operationType'] ?? null,
                    'classification' => $classification['classification'],
                    'affects_totals' => $affectsTotals,
                    'exclusion_reason' => $affectsTotals ? null : ($status === 'POSTED' ? $classification['exclusion_reason'] : 'pending'),
                    'payment_method' => $classification['payment_method'],
                    'pluggy_category_id' => $transaction['categoryId'] ?? null,
                    'pluggy_category_name' => $transaction['category'] ?? null,
                    'category_id' => $existing?->user_modified_category ? $existing->category_id : $categoryId,
                    'category_source' => $existing?->category_source ?? 'pluggy',
                    'is_installment' => (int) ($metadata['totalInstallments'] ?? 0) > 1,
                    'current_installment' => $metadata['installmentNumber'] ?? null,
                    'total_installments' => $metadata['totalInstallments'] ?? null,
                    'purchase_date' => isset($metadata['purchaseDate']) ? $this->date($metadata['purchaseDate'])->toDateString() : null,
                    'payment_data' => $transaction['paymentData'] ?? null,
                    'credit_card_metadata' => $metadata ?: null,
                    'raw_payload' => $transaction,
                    'is_internal_transfer' => $classification['is_internal_transfer'],
                    'paired_transaction_id' => null,
                    'removed_at' => null,
                ];

                if ($existing) {
                    $existing->update($values);
                    $updated++;
                } else {
                    PluggyTransaction::create($values);
                    $created++;
                }
            }
        });

        return compact('created', 'updated');
    }

    /** @param array<string, mixed> $transaction */
    private function findExisting(int $userId, array $transaction): ?PluggyTransaction
    {
        $byPluggyId = PluggyTransaction::query()->where('pluggy_transaction_id', $transaction['id'])->first();
        if ($byPluggyId) {
            return $byPluggyId;
        }

        if (! empty($transaction['providerId'])) {
            return PluggyTransaction::query()
                ->where('user_id', $userId)
                ->where('provider_id', $transaction['providerId'])
                ->first();
        }

        return null;
    }

    private function categoryType(string $classification): string
    {
        return $classification === PluggyTransaction::CLASSIFICATION_INCOME ? 'income' : 'expense';
    }

    /** @param array{classification: string, affects_totals: bool} $classification */
    private function shouldAffectTotals(array $classification, string $status, string $accountType): bool
    {
        if (! $classification['affects_totals']) {
            return false;
        }

        if ($status === 'POSTED') {
            return true;
        }

        // Estornos e cashback reduzem uma despesa já registrada e, por isso, entram
        // imediatamente como valor negativo. Compras no cartão também entram no mês
        // da compra mesmo antes da administradora trocar o status para POSTED.
        return in_array($classification['classification'], [
            PluggyTransaction::CLASSIFICATION_REFUND,
            PluggyTransaction::CLASSIFICATION_CASHBACK,
        ], true) || ($accountType === 'CREDIT'
            && $classification['classification'] === PluggyTransaction::CLASSIFICATION_EXPENSE);
    }

    private function date(mixed $date): Carbon
    {
        return $date ? Carbon::parse($date)->setTimezone(config('app.timezone')) : now();
    }
}
