<?php

namespace Tests\Feature;

use App\Models\PluggyItem;
use App\Models\User;
use App\Jobs\ProcessPluggyWebhook;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PluggyWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('services.pluggy.webhook_secret', 'webhook-secret');
    }

    public function test_it_records_an_item_created_by_pluggy_for_its_user(): void
    {
        Queue::fake();
        $user = User::factory()->create();

        $response = $this->postJson(route('pluggy.webhook', ['token' => 'webhook-secret']), [
            'event' => 'item/created',
            'eventId' => 'a34715d1-a440-4360-bc75-916fe6d9ee00',
            'itemId' => 'b34715d1-a440-4360-bc75-916fe6d9ee00',
            'clientUserId' => (string) $user->id,
        ]);

        $response->assertNoContent();

        $this->assertDatabaseHas('pluggy_items', [
            'user_id' => $user->id,
            'pluggy_item_id' => 'b34715d1-a440-4360-bc75-916fe6d9ee00',
            'last_event' => 'item/created',
        ]);
        Queue::assertPushed(ProcessPluggyWebhook::class);
    }

    public function test_it_requires_the_configured_webhook_secret(): void
    {
        config()->set('services.pluggy.webhook_secret', 'webhook-secret');

        $this->postJson(route('pluggy.webhook'), [
            'event' => 'item/created',
        ])->assertUnauthorized();
    }

    public function test_it_marks_a_deleted_item_as_deleted(): void
    {
        Queue::fake();
        $item = PluggyItem::factory()->create();

        $this->postJson(route('pluggy.webhook', ['token' => 'webhook-secret']), [
            'event' => 'item/deleted',
            'eventId' => 'c34715d1-a440-4360-bc75-916fe6d9ee00',
            'itemId' => $item->pluggy_item_id,
            'clientUserId' => (string) $item->user_id,
        ])->assertNoContent();

        $this->assertSoftDeleted('pluggy_items', ['id' => $item->id]);
    }

    public function test_it_ignores_a_duplicate_webhook_event(): void
    {
        Queue::fake();
        $user = User::factory()->create();
        $payload = [
            'event' => 'item/created',
            'eventId' => 'd34715d1-a440-4360-bc75-916fe6d9ee00',
            'itemId' => 'e34715d1-a440-4360-bc75-916fe6d9ee00',
            'clientUserId' => (string) $user->id,
        ];

        $this->postJson(route('pluggy.webhook', ['token' => 'webhook-secret']), $payload)->assertNoContent();
        $this->postJson(route('pluggy.webhook', ['token' => 'webhook-secret']), $payload)->assertNoContent();

        $this->assertDatabaseCount('pluggy_webhook_events', 1);
        Queue::assertPushed(ProcessPluggyWebhook::class, 1);
    }
}
