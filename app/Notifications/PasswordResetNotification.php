<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Models\PasswordResetToken;

class PasswordResetNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $newPassword;

    // Constructor accepts both the user and new password
    public function __construct($user, $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    // Define the notification channels
    public function via($notifiable)
    {
        return ['mail'];
    }

    // Generate and send the reset link email
    public function toMail($notifiable)
    {
        // Generate a reset token
        $token = Str::random(60); // Generate a random token
        PasswordResetToken::updateOrCreate(
            ['email' => $this->user->email],  // Use user email
            ['token' => $token, 'created_at' => now()]
        );

        // Generate the reset link (route should exist)
        $url = URL::route('password.reset', ['token' => $token]);

        return (new MailMessage)
            ->subject('Your Password Reset Link')
            ->line('You requested a password reset.')
            
            ->line('Please click the link below to reset your password:')
            ->action('Reset Password', $url)
            ->line('If you did not request this change, please ignore this email.')
            ->line('Thank you');
    }

    // Optional: Data representation for other channels (e.g., database)
    public function toArray($notifiable)
    {
        return [
            'email' => $this->user->email,
            'new_password' => $this->newPassword
        ];
    }
}