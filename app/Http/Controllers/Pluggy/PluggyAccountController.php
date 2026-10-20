<?php

namespace App\Http\Controllers\Pluggy;

use App\Http\Controllers\Controller;
use App\Jobs\SyncPluggyConnection;
use App\Models\PluggyItem;
use App\Models\PluggyTransactionRule;
use App\Models\PluggyTransaction;
use App\Services\Pluggy\PluggyService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Throwable;

class PluggyAccountController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json(['data' => $request->user()
            ->pluggyAccounts()
            ->where('is_active', true)
            ->get(['id', 'pluggy_connection_id', 'name', 'type', 'subtype', 'number_last_four', 'currency_code', 'balance', 'last_synced_at'])]);
    }

    public function connections(Request $request): View
    {
        return view('pluggy.connections', [
            'connections' => $request->user()->pluggyItems()
                ->where('is_active', true)
                ->with(['accounts' => fn ($query) => $query->where('is_active', true)])
                ->latest()
                ->get(),
            'inactiveConnections' => PluggyItem::withTrashed()
                ->where('user_id', $request->user()->id)
                ->where('is_active', false)
                ->latest()
                ->get(),
            'transactionRules' => $request->user()->pluggyTransactionRules()
                ->latest()
                ->get(),
            'error' => null,
        ]);
    }

    public function store(Request $request, PluggyService $pluggyService): JsonResponse
    {
        $validated = $request->validate([
            'itemId' => ['required', 'uuid'],
        ]);

        try {
            $existingConnection = PluggyItem::withTrashed()
                ->where('pluggy_item_id', $validated['itemId'])
                ->first();

            if ($existingConnection !== null && $existingConnection->user_id !== $request->user()->id) {
                return response()->json(['message' => 'Esta conexão já está vinculada a outro usuário.'], 403);
            }

            if ($existingConnection !== null) {
                $existingConnection->restore();
                $existingConnection->update([
                    'is_active' => true,
                    'last_error' => null,
                    'last_sync_status' => 'queued',
                    'deleted_at' => null,
                ]);
                $existingConnection->accounts()->update(['is_active' => true]);
                SyncPluggyConnection::dispatch($existingConnection->id);

                return response()->json(['message' => 'Conexão existente reativada e sincronização agendada.']);
            }

            $item = $pluggyService->getItem($validated['itemId']);
            $clientUserId = (string) ($item['clientUserId'] ?? '');

            if ($clientUserId !== '' && $clientUserId !== (string) $request->user()->id) {
                return response()->json(['message' => 'Esta conexão não pertence ao usuário atual.'], 403);
            }

            // Itens legados do MeuPluggy podem não ter clientUserId. Não fazemos PATCH
            // neles: a atualização pode disparar o bloqueio de credenciais duplicadas.

            PluggyItem::withTrashed()->updateOrCreate(
                ['pluggy_item_id' => $validated['itemId']],
                [
                    'user_id' => $request->user()->id,
                    'last_event' => 'item/created',
                    'last_error' => null,
                    'deleted_at' => null,
                    'is_active' => true,
                ],
            );
        } catch (RequestException $exception) {
            $pluggyCode = (string) ($exception->response?->json('codeDescription') ?? '');
            Log::warning('Não foi possível validar o Item Pluggy conectado.', [
                'user_id' => $request->user()->id,
                'status' => $exception->response?->status(),
                'pluggy_code' => $pluggyCode ?: null,
            ]);

            $message = match ($pluggyCode) {
                'ITEM_NOT_FOUND' => 'Este Item não existe mais na Pluggy. Crie uma nova conexão.',
                'ITEM_USER_ALREADY_EXISTS' => 'Este Item já está associado na Pluggy. Tente vinculá-lo novamente ou crie uma nova conexão.',
                default => 'A Pluggy recusou a validação desta conexão. Confira se o Item ID pertence a esta mesma aplicação.',
            };

            return response()->json(['message' => $message], 502);
        } catch (Throwable $exception) {
            Log::error('Falha ao registrar Item Pluggy conectado.', [
                'user_id' => $request->user()->id,
                'exception' => $exception::class,
            ]);

            return response()->json(['message' => 'Não foi possível registrar a conexão bancária.'], 500);
        }

        $connection = PluggyItem::query()->where('pluggy_item_id', $validated['itemId'])->firstOrFail();
        SyncPluggyConnection::dispatch($connection->id);

        return response()->json(['message' => 'Conexão bancária registrada e sincronização agendada.'], 201);
    }

    public function sync(Request $request, int $connection): \Illuminate\Http\RedirectResponse
    {
        $item = $request->user()->pluggyItems()->where('is_active', true)->findOrFail($connection);
        SyncPluggyConnection::dispatch($item->id, true);

        return back()->with('success', 'Sincronização solicitada. Os dados serão atualizados em breve.');
    }

    public function destroy(Request $request, int $connection): \Illuminate\Http\RedirectResponse
    {
        $item = $request->user()->pluggyItems()->where('is_active', true)->findOrFail($connection);
        $item->update(['is_active' => false, 'last_sync_status' => 'DISCONNECTED']);
        $item->accounts()->update(['is_active' => false]);
        PluggyTransaction::query()
            ->where('pluggy_connection_id', $item->id)
            ->update(['affects_totals' => false, 'removed_at' => now()]);

        return back()->with('success', 'Conexão removida do sistema. Seus lançamentos manuais foram preservados.');
    }

    public function reactivate(Request $request, int $connection): \Illuminate\Http\RedirectResponse
    {
        $item = PluggyItem::withTrashed()
            ->where('user_id', $request->user()->id)
            ->where('is_active', false)
            ->findOrFail($connection);

        $item->restore();
        $item->update(['is_active' => true, 'last_error' => null, 'last_sync_status' => 'queued', 'deleted_at' => null]);
        $item->accounts()->update(['is_active' => true]);
        SyncPluggyConnection::dispatch($item->id);

        return back()->with('success', 'Reconexão solicitada. A Pluggy validará a conexão em instantes.');
    }
}
