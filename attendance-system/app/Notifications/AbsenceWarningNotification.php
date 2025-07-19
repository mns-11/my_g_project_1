<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbsenceWarningNotification extends Notification implements ShouldQueue
{
    use Queueable;
    use Queueable;

    public function __construct(
        public  $courseName,
        public  $absencePercentage,
        public  $allowedPercentage
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

  /*  public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Absence Warning - ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have reached ' . number_format($this->absencePercentage, 1) .
                '% absence in ' . $this->courseName)
            ->line('Maximum allowed absence: ' . $this->allowedPercentage . '%')
            ->line('Please attend future lectures to avoid academic penalties.')
            ->line('Thank you for your attention!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'course' => $this->courseName,
            'absence_percentage' => $this->absencePercentage,
            'allowed_percentage' => $this->allowedPercentage,
            'message' => 'You have ' . number_format($this->absencePercentage, 1) .
                '% absence in ' . $this->courseName .
                ' (Max allowed: ' . $this->allowedPercentage . '%)',
        ];
    }*/


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('تحذير من الغياب - ' . config('app.name'))
            ->greeting('مرحبًا ' . $notifiable->name . ',')
            ->line('لقد وصلت نسبة غيابك إلى ' . number_format($this->absencePercentage, 1) .
                '% في مادة ' . $this->courseName)
            ->line('النسبة القصوى المسموح بها للغياب: ' . $this->allowedPercentage . '%')
            ->line('يرجى حضور المحاضرات المستقبلية لتجنب العقوبات الأكاديمية.')
            ->line('شكرًا لاهتمامك!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'course' => $this->courseName,
            'absence_percentage' => $this->absencePercentage,
            'allowed_percentage' => $this->allowedPercentage,
            'message' => 'لديك ' . number_format($this->absencePercentage, 1) .
                '% غياب في مادة ' . $this->courseName .
                ' (الحد الأقصى المسموح به: ' . $this->allowedPercentage . '%)',
        ];
    }
}
