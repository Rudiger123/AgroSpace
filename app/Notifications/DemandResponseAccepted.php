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
        $demand     = $this->demandResponse->demand;
        $consumer   = $demand->user;
        $producer   = $this->demandResponse->user;
        $response   = $this->demandResponse;

        return (new MailMessage())
            ->subject("Félicitations ! Votre réponse à la demande #{$demand->id} a été acceptée !")
            ->view('emails.notification', [
                'title'      => 'Votre offre a été ACCEPTÉE !',
                'content'    => view('emails.partials.demand-response-accepted', [
                    'producer' => $producer,
                    'consumer' => $consumer,
                    'demand'   => $demand,
                    'response' => $response,
                ])->render(),
                'actionText' => 'Aller au chat',
                'actionUrl'  => route('chats', $response->conversation_id ?? '#'),
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
            'status' => 'accepted',
        ];
    }
}
