<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class TwoFactorCodeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your Terminal Verification Code')
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line('A login attempt was detected. Your one-time terminal verification code is:')
                    ->line(new HtmlString('<div style="font-size:32px; font-weight:800; letter-spacing:8px; color:#c9a800; text-align:center; padding:20px; background:#fafafa; border-radius:12px; border:2px dashed #F7DF79;">' . $notifiable->two_factor_code . '</div>'))
                    ->line('This code will expire in 10 minutes.')
                    ->line('If you did not attempt this login, please secure your account immediately.');
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
