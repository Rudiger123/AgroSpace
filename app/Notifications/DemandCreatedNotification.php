<?php

namespace App\Notifications;

use App\Models\Demand;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $demand;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Demand $demand, User $user)
    {
        $this->demand = $demand;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
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

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📋 Nouvelle demande à modérer - AgroSpace')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle demande a été créée et nécessite votre modération.')
            ->line('**Détails de la demande:**')
            ->line('- **Titre:** ' . $this->demand->title)
            ->line('- **Utilisateur:** ' . $this->user->name)
            ->line('- **Catégorie:** ' . $this->demand->category->name)
            ->line('- **Région:** ' . $this->demand->region)
            ->line('- **Urgence:** ' . $this->getUrgencyText($this->demand->urgency))
            ->action('🔍 Voir la demande', route('demands.index', $this->demand->id))
            ->line('Merci de modérer cette demande dans les plus brefs délais.')
            ->salutation('Cordialement,<br>L\'équipe AgroSpace');
    }

    /**
     * Get the array representation for database.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'demand_created',
            'title' => 'Nouvelle demande à modérer',
            'message' => $this->user->name . ' a créé une nouvelle demande: "' . $this->demand->title . '"',
            'model_id' => $this->demand->id,
            'model_title' => $this->demand->title,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'category_name' => $this->demand->category->name,
            'region' => $this->demand->region,
            'urgency' => $this->demand->urgency,
            'action_url' => route('demands.index', $this->demand->id),
            'icon' => 'newspaper',
            'color' => 'orange',
        ];
    }

    /**
     * Get the broadcastable representation.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'demand_created',
            'title' => 'Nouvelle demande à modérer',
            'message' => $this->user->name . ' a créé une nouvelle demande: "' . $this->demand->title . '"',
            'action_url' => route('demands.index', $this->demand->id),
            'icon' => 'newspaper',
            'color' => 'orange',
            'created_at' => now()->toIso8601String(),
        ]);
    }

    /**
     * Get urgency text in French.
     */
    protected function getUrgencyText($urgency): string
    {
        return match ($urgency) {
            'high' => 'Élevée',
            'medium' => 'Moyenne',
            'low' => 'Faible',
            default => 'Non spécifiée'
        };
    }
}