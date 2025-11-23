<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\DemandResponseCreated;
use App\Notifications\NewDemandResponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDemandResponseNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(DemandResponseCreated $event): void
    {
        // Le destinataire est le créateur de la demande originale
        // On assume la relation $response->demand->user (le owner de la demande)
        $recipient = $event->response->demand->user;

        // On ne notifie pas si l'utilisateur répond à sa propre demande (cas rare mais possible)
        if ($recipient && $recipient->id !== $event->response->user_id) {
            $recipient->notify(new NewDemandResponse($event->response));
        }
    }

    public function failed(DemandResponseCreated $event, $exception): void
    {
        logger()->error('Failed to send demand response notification', [
            'response_id' => $event->response->id,
            'error' => $exception->getMessage(),
        ]);
    }
}