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
            ->greeting('Bonne nouvelle, ' . $notifiable->name . ' !')
            ->line('Votre compte AgroSpace a été réactivé avec succès.')
            ->line('Vous pouvez maintenant vous reconnecter et utiliser à nouveau toutes les fonctionnalités de la plateforme.')
            ->line('Nous vous rappelons de respecter les conditions d\'utilisation pour éviter toute suspension future.')
            ->action('Se Connecter', route('login'))
            ->line('Merci de continuer à faire partie de la communauté AgroSpace !')
            ->salutation('Cordialement, L\'équipe AgroSpace');
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
