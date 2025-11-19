<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\NewOfferCreated;
use App\Models\User;
use App\Notifications\NewOfferNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewOfferNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param NewOfferCreated $event
     * @return void
     */
    public function handle(NewOfferCreated $event): void
    {
        // Get recipients based on business logic
        $recipients = $this->getRecipients($event);
        @dump($recipients);
        // Send notification to each recipient
        foreach ($recipients as $recipient) {
            $recipient->notify(new NewOfferNotification($event->offer, $event->creator));
        }
    }

    /**
     * Get notification recipients based on business rules.
     *
     * @param NewOfferCreated $event
     * @return \Illuminate\Support\Collection
     */
    protected function getRecipients(NewOfferCreated $event)
    {
        // Example: Notify all admins
        $admins = User::where('role_id', 1)->get();

        return $admins;
    }

    /**
     * Handle a job failure.
     *
     * @param NewOfferCreated $event
     * @param \Throwable $exception
     * @return void
     */
    public function failed(NewOfferCreated $event, $exception): void
    {
        // Log the error
        logger()->error('Failed to send new offer notification', [
            'offer_id' => $event->offer->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
