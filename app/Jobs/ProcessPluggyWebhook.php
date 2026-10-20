<?php

namespace App\Jobs;

use App\Models\PluggyItem;
use App\Models\PluggyWebhookEvent;
use App\Services\Pluggy\PluggySyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessPluggyWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [60, 300, 900];

    public function __construct(public int $eventId)
    {
    }

    public function handle(PluggySyncService $syncService): void
    {
        $event = PluggyWebhookEvent::query()->find($this->eventId);
        if (! $event || $event->processed_at) {
            return;
        }

        try {
            $payload = $event->payload;
            $itemId = $payload['itemId'] ?? null;

            if ($event->event === 'transactions/deleted' && $itemId) {
                $syncService->markTransactionsDeleted($itemId, $payload['transactionIds'] ?? []);
            } elseif ($itemId && in_array($event->event, ['item/created', 'item/updated', 'transactions/created', 'transactions/updated'], true)) {
                $connection = PluggyItem::query()->where('pluggy_item_id', $itemId)->where('is_active', true)->first();
                if ($connection) {
                    $syncService->sync($connection);
                }
            } elseif ($itemId && $event->event === 'item/deleted') {
                PluggyItem::query()->where('pluggy_item_id', $itemId)->update(['is_active' => false, 'deleted_at' => now()]);
            }

            $event->update(['processed_at' => now(), 'processing_error' => null]);
        } catch (Throwable $exception) {
            $event->update(['processing_error' => 'Falha ao processar o evento. Consulte os logs técnicos.']);
            throw $exception;
        }
    }
}
