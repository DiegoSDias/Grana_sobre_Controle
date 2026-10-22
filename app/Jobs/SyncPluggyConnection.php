<?php

namespace App\Jobs;

use App\Models\PluggyItem;
use App\Services\Pluggy\PluggySyncService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\MonthlyBalanceService;

class SyncPluggyConnection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [60, 300, 900];

    public function __construct(public int $connectionId, public bool $requestRemoteSync = false)
    {
    }

    public function handle(PluggySyncService $syncService): void
    {
        $connection = PluggyItem::query()->where('is_active', true)->find($this->connectionId);

        if ($connection) {
            try {
                $syncService->sync($connection, $this->requestRemoteSync);
            } catch (RequestException $exception) {
                if ($exception->response?->status() !== 404) {
                    throw $exception;
                }

                $connection->update([
                    'is_active' => false,
                    'last_sync_status' => 'not_found',
                    'last_error' => 'Esta conexão não existe mais na Pluggy. Conecte a instituição novamente.',
                ]);
                $connection->accounts()->update(['is_active' => false]);
                $connection->transactions()->update(['affects_totals' => false, 'removed_at' => now()]);
                app(MonthlyBalanceService::class)->recalculateClosedFrom($connection->user_id, 0, 1);
            }
        }
    }
}
