<?php

namespace App\Events\Notifications;

use App\Models\Demand;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandCreated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $demand;
    public $user;
    public $category;

    /**
     * Create a new event instance.
     */
    public function __construct(Demand $demand, User $user)
    {
        $this->demand = $demand;
        $this->user = $user;
        $this->category = $demand->category;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'demand.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->demand->id,
            'title' => $this->demand->title,
            'user_name' => $this->user->name,
            'category_name' => $this->category->name,
            'region' => $this->demand->region,
            'urgency' => $this->demand->urgency,
            'created_at' => now()->toIso8601String(),
        ];
    }
}
