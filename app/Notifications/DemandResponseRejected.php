<?php

namespace App\Notifications;

use App\Models\DemandResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandResponseRejected extends Notification implements ShouldQueue
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
        $producer = $this->demandResponse->user;

        return (new MailMessage())
            ->subject("ℹ️ Mise à jour de votre réponse à la demande #{$demand->id} : Rejetée")
            ->greeting("Bonjour {$producer->name},")
            ->line("Nous vous informons que le consommateur a choisi de ne pas retenir votre réponse concernant sa demande : **\"{$demand->titre}\"**.")
            ->line("Détails de votre réponse :")
            ->line("- **Prix Proposé :** {$this->demandResponse->proposed_price} F CFA")
            ->line("- **Message :** " . str($this->demandResponse->message)->limit(100))
            ->line("Le consommateur a peut-être reçu d'autres offres qui correspondaient mieux à ses besoins immédiats.")
            ->line("Ne vous découragez pas ! De nombreuses autres demandes sont publiées chaque jour. Continuez à soumettre vos offres !")
            ->action('Voir la Demande Originale', route('demands-list', $demand->id))
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
            'status' => 'rejected',
        ];
    }
}
