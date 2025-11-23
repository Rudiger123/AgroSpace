<?php

namespace App\Events\Notifications;

use App\Models\Avis;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewReviewCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $avis;

    /**
     * Create a new event instance.
     */
    public function __construct(Avis $avis)
    {
        $this->avis = $avis;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        // Canal privé du producteur qui reçoit l'avis
        return [
            new PrivateChannel('notifications.' . $this->avis->producer_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.review.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->avis->id,
            'note' => $this->avis->note,
            'consumer_name' => $this->avis->consumer->name, // Assumant la relation 'consumer'
            'created_at' => now()->toIso8601String(),
        ];
    }
}