<?php

namespace App\Notifications;

use App\Models\Avis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $avis;

    public function __construct(Avis $avis)
    {
        $this->avis = $avis;
    }

    public function via($notifiable): array
    {
        $channels = ['database'];
        if ($notifiable->email_notifications_enabled ?? true) {
            $channels[] = 'mail';
        }
        if ($notifiable->push_notifications_enabled ?? true) {
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        $consumerName = $this->avis->consumer->name ?? 'Un consommateur';

        return (new MailMessage())
            ->subject('⭐ Nouvel avis reçu sur AgroSpace')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line($consumerName . ' a laissé un avis de ' . $this->avis->note . '/5.')
            ->line('Commentaire : "' . str($this->avis->commentaire)->limit(100) . '"')
            ->action('Voir l\'avis', url('/profile/reviews')) // Ajuster la route
            ->line('Merci de contribuer à la qualité de notre plateforme !');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'review_received',
            'title' => 'Nouvel avis reçu (' . $this->avis->note . '/5)',
            'message' => ($this->avis->consumer->name ?? 'Un utilisateur') . ' a évalué vos services.',
            'model_id' => $this->avis->id,
            'model_type' => Avis::class,
            'action_url' => route('reviews.show', $this->avis->id), // Ajuster la route
            'icon' => 'star',
            'color' => 'yellow',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'review_received',
            'title' => 'Nouvel avis ⭐',
            'message' => 'Vous avez reçu une note de ' . $this->avis->note . '/5',
            'action_url' => route('reviews.show', $this->avis->id),
            'icon' => 'star',
            'color' => 'yellow',
            'created_at' => now()->toIso8601String(),
        ]);
    }
}
