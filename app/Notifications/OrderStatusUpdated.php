<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected Order $order;

    /**
    * Create a new notification instance.
    *
    * @param Order $order
    * @return void
    */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
    * Get the notification's delivery channels.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    /**
    * Get the mail representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line('Buyurtmangizning holati yangilandi.')
        ->action('Buyurtmalarni ko\'rish', url('/user/orders'))
        ->line('Rahmat!');
    }

    /**
    * Get the array representation of the notification.
    *
    * @param  mixed  $notifiable
    * @return array
    */
    public function toArray(mixed $notifiable): array
    {
        return [
        'order_id' => $this->order->id,
        'status' => $this->order->status,
        ];
    }
}
