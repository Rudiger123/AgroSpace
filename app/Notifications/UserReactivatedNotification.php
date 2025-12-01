<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserReactivatedNotification extends Notification implements ShouldQueue
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
            ->subject('Réactivation de votre compte AgroSpace')
            ->view('emails.notification', [
                'title'      => 'Compte réactivé !',
                'content'    => view('emails.partials.account-reactivated', [
                    'notifiable' => $notifiable,
                ])->render(),
                'actionText' => 'Me connecter',
                'actionUrl'  => route('login'),
            ]);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'user_reactivated',
            'title' => 'Compte Réactivé',
            'message' => 'Votre compte a été réactivé. Vous pouvez maintenant vous reconnecter.',
            'action_url' => route('login'),
            'icon' => 'success',
            'color' => 'green',
        ];
    }
}
