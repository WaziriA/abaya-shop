<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyCustomer extends Notification
{
    use Queueable;

    private $order;
    private $shipping;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $shipping)
    {
        $this->order = $order;
        $this->shipping = $shipping;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // Make sure the products relationship is loaded
       // $products = $this->order->products->pluck('name')->toArray();
        $deliveryAddress = $this->shipping->street . ', ' . $this->shipping->district . ', ' . $this->shipping->town . ', ' . $this->shipping->country->name;

        return (new MailMessage)
            ->subject('Thank You for Your Order')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('Thank you for shopping with us! Your order will be delivered soon.')
            //->line('Order ID: ' . $this->order->id)
            //->line('Products Ordered: ' . implode(", ", $products))
            ->line('Amount: $' . $this->order->amount)
            ->line('Delivery Address: ' . $deliveryAddress)
            ->line('We hope to see you again soon!');
    }
}