<?php

namespace App\Http\Controllers\Pluggy;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessPluggyWebhook;
use App\Models\PluggyItem;
use App\Models\User;
use App\Models\PluggyWebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PluggyWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
        if (! $request->isJson()) {
            return response()->noContent(Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        if ($secret = config('services.pluggy.webhook_secret')) {
            if (! hash_equals($secret, (string) $request->query('token'))) {
                return response()->noContent(Response::HTTP_UNAUTHORIZED);
            }
        }

        $event = $request->json()->all();
        $eventName = $event['event'] ?? null;
        $eventId = $event['eventId'] ?? null;
        $itemId = $event['itemId'] ?? null;

        if (! is_string($eventName) || ! is_string($eventId) || ! Str::isUuid($eventId)
            || ($itemId !== null && (! is_string($itemId) || ! Str::isUuid($itemId)))) {
            return response()->noContent(Response::HTTP_BAD_REQUEST);
        }

        Log::info('Webhook Pluggy recebido.', [
            'event' => $eventName,
            'event_id' => $event['eventId'] ?? null,
            'item_id' => $itemId,
        ]);

        if (is_string($itemId) && str_starts_with($eventName, 'item/')) {
            $this->storeItemEvent($event, $itemId);
        }

        $webhookEvent = PluggyWebhookEvent::query()->firstOrCreate(
            ['event_id' => $eventId],
            ['event' => $eventName, 'pluggy_item_id' => $itemId, 'payload' => $event, 'received_at' => now()],
        );

        if ($webhookEvent->wasRecentlyCreated) {
            ProcessPluggyWebhook::dispatch($webhookEvent->id);
        }

        return response()->noContent(200);
    }

    /** @param array<string, mixed> $event */
    private function storeItemEvent(array $event, string $itemId): void
    {
        $clientUserId = filter_var($event['clientUserId'] ?? null, FILTER_VALIDATE_INT);

        if (! $clientUserId || ! User::query()->whereKey($clientUserId)->exists()) {
            Log::warning('Webhook Pluggy de item sem usuário local válido.', [
                'event' => $event['event'],
                'item_id' => $itemId,
            ]);

            return;
        }

        PluggyItem::withTrashed()->updateOrCreate(
            ['pluggy_item_id' => $itemId],
            [
                'user_id' => $clientUserId,
                'last_event' => $event['event'],
                'last_error' => $event['error']['message'] ?? $event['error']['description'] ?? null,
                'deleted_at' => $event['event'] === 'item/deleted' ? now() : null,
                'is_active' => $event['event'] !== 'item/deleted',
            ],
        );
    }
}
