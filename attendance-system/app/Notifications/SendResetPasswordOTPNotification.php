<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendResetPasswordOTPNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otp;
    protected $expireIn;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp, $expireIn)
    {
        $this->otp = $otp;
        $this->expireIn = $expireIn;
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
            ->subject('Password Reset OTP')
            ->line('Your OTP for password reset is:')
            ->line($this->otp);
//            ->line('This OTP will expire in minutes')
//            ->line($this->expireIn);
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
