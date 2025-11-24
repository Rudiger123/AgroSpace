<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\DemandCreated;
use App\Models\User;
use App\Notifications\DemandCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendDemandCreatedNotification implements ShouldQueue
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
     */
    public function handle(DemandCreated $event): void
    {
        // Récupérer tous les administrateurs
        $admins = $this->getRecipients($event);

        // Envoyer la notification à chaque administrateur
        foreach ($admins as $admin) {
            $admin->notify(new DemandCreatedNotification(
                $event->demand,
                $event->user
            ));
        }
    }

    /**
     * Get notification recipients (tous les administrateurs).
     */
    protected function getRecipients(DemandCreated $event)
    {
        return User::where('role_id', 1) // ID 1 = Administrateur
                   ->where('is_active', true)
                   ->get();
    }

    /**
     * Handle a job failure.
     */
    public function failed(DemandCreated $event, $exception): void
    {
        logger()->error('Failed to send demand created notification', [
            'event' => get_class($event),
            'demand_id' => $event->demand->id,
            'error' => $exception->getMessage(),
        ]);
    }
}