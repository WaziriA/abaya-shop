<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CouponAssigned extends Notification 
{
    use Queueable;

    protected $coupon;

    public function __construct($coupon)
    {
        $this->coupon = $coupon;
    }

    public function via($notifiable)
    {
        return ['mail']; // You can also use 'database', 'broadcast', etc.
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Coupon Assigned!')
            ->greeting('Hello!')
            ->line('A new coupon has been assigned to you:')
            ->line('Name: ' . $this->coupon->name)
            ->line('Code: ' . $this->coupon->code)
            ->line('Discount: ' . $this->coupon->discount_value . ' ' . ucfirst($this->coupon->type))
            ->line('Expires At: ' . $this->coupon->expires_at)
            ->line('Visit to our online store url, to buy a product and use that coupon before expire date to get discount')
            ->action('Visit Store', url('/'))
            ->line('Thank you for using our services!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
