<?php

namespace App\Notifications;

use App\Models\DemandResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandResponseAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $demandResponse;

    /**
     * Create a new notification instance.
     */
    public function __construct(DemandResponse $demandResponse)
    {
        $this->demandResponse = $demandResponse;
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
        $demand = $this->demandResponse->demand;
        $consumer = $demand->user;
        $producer = $this->demandResponse->user;

        return (new MailMessage())
            ->subject("🎉 Félicitations ! Votre réponse à la demande #{$demand->id} a été acceptée !")
            ->greeting("Bonjour {$producer->name},")
            ->line("Excellente nouvelle ! Le consommateur **{$consumer->name}** a accepté votre offre en réponse à sa demande : **\"{$demand->titre}\"**.")
            ->line("Un espace de chat instantané a été créé automatiquement pour vous permettre de finaliser les détails de l'échange (prix, quantité, lieu de rencontre, etc.).")
            ->action('Accéder à la Conversation', route('chats', $this->demandResponse->conversation_id ?? '#')) // Assurez-vous que conversation_id est disponible
            ->line("Détails de votre réponse :")
            ->line("- **Prix Proposé :** {$this->demandResponse->proposed_price} F CFA")
            ->line("- **Message :** " . str($this->demandResponse->message)->limit(100))
            ->line("Veuillez consulter le chat pour toutes les informations de contact nécessaires.")
            ->salutation("Cordialement,\nL'équipe AgroSpace.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'demand_response_id' => $this->demandResponse->id,
            'demand_id' => $this->demandResponse->demand_id,
            'status' => 'accepted',
        ];
    }
}
