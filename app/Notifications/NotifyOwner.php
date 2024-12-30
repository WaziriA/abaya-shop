<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyOwner extends Notification
{
    use Queueable;

    private $order;
    private $shipping;
    private $customer;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $shipping, $customer)
    {
        $this->order = $order;
        $this->shipping = $shipping;
        $this->customer = $customer;
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
        $deliveryAddress = $this->shipping->street . ', ' . $this->shipping->district . ', ' . $this->shipping->town . ', ' . $this->shipping->country->name;

        return (new MailMessage)
            ->subject('New Order Placed')
            ->greeting('Hello, ' . $notifiable->name)
            ->line('A new order has been placed by ' . $this->customer->name . '.')
            ->line('Order ID: ' . $this->order->id)
            ->line('Amount: $' . $this->order->amount)
            ->line('Payment Method: ' . $this->order->payment_method)
            ->line('Delivery Address: ' . $deliveryAddress)
            ->line('Thank you for managing our orders!');
    }
}