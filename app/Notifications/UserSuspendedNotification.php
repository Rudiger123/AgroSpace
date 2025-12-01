<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSuspendedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Suspension de votre compte AgroSpace')
            ->view('emails.notification', [
                'title'      => 'Votre compte a été suspendu',
                'content'    => view('emails.partials.account-suspended', [
                    'notifiable' => $notifiable,
                ])->render(),
                'actionText' => 'Contacter le support',
                'actionUrl'  => url('/contact'),
            ]);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'user_suspended',
            'title' => 'Compte Suspendu',
            'message' => 'Votre compte a été temporairement suspendu. Veuillez contacter le support pour plus d\'informations.',
            'icon' => 'warning',
            'color' => 'orange',
        ];
    }
}
