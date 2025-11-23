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
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Nous vous informons que votre compte AgroSpace a été temporairement suspendu.')
            ->line('**Raison :** Non-respect des conditions d\'utilisation de la plateforme.')
            ->line('Vous avez été automatiquement déconnecté et vous ne pouvez plus accéder à votre compte pour le moment.')
            ->line('Si vous pensez qu\'il s\'agit d\'une erreur ou si vous souhaitez plus d\'informations, veuillez contacter notre équipe de support.')
            ->action('Contacter le Support', url('/contact'))
            ->line('Merci de votre compréhension.')
            ->salutation('Cordialement, L\'équipe AgroSpace');
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
