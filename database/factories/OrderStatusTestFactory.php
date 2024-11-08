<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * @extends Factory<\App\Models\Model>
 */
class OrderStatusTestFactory extends TestCase
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    use RefreshDatabase;

    public function test_user_can_receive_notification_when_order_status_is_updated()
    {
        Notification::fake(); // Notificationni feyk qilish

        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id, 'status' => 'pending']);

        $this->actingAs($user)->post(route('user.orders.update-status', $order->id));

        Notification::assertSentTo($user, \App\Notifications\OrderStatusUpdated::class); // Notification yuborilganligini tekshirish
    }
    public function definition(): array
    {
        return [
            //
        ];
    }
}
