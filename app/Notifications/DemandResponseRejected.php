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
    $demand   = $this->demandResponse->demand;
    $producer = $this->demandResponse->user;
    $response = $this->demandResponse;

    return (new MailMessage)
        ->subject("Mise à jour : votre réponse à la demande #{$demand->id} a été refusée")
        ->view('emails.notification', [
            'title'      => 'Votre proposition n’a pas été retenue',
            'content'    => view('emails.partials.demand-response-rejected', [
                'producer' => $producer,
                'demand'   => $demand,
                'response' => $response,
            ])->render(),
            'actionText' => 'Voir d’autres demandes',
            'actionUrl'  => route('demands.list'), // ou la route publique des demandes
        ]);
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
