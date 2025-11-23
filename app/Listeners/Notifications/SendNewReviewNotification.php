<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\NewReviewCreated;
use App\Notifications\ReviewReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewReviewNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(NewReviewCreated $event): void
    {
        // Le destinataire est le producteur lié à l'avis
        $recipient = $event->avis->producer; // Assumant la relation 'producer'

        if ($recipient) {
            $recipient->notify(new ReviewReceived($event->avis));
        }
    }

    public function failed(NewReviewCreated $event, $exception): void
    {
        logger()->error('Failed to send review notification', [
            'avis_id' => $event->avis->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
