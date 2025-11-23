<?php

namespace App\Events\Notifications;

use App\Models\DemandResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandResponseCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;

    public function __construct(DemandResponse $response)
    {
        $this->response = $response;
    }

    public function broadcastOn(): array
    {
        // Canal privé du créateur de la demande
        return [
            new PrivateChannel('notifications.' . $this->response->demand->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'demand.response.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->response->id,
            'demand_title' => $this->response->demand->title, // Assumant que 'demand' a un titre
            'responder_name' => $this->response->user->name, // Assumant relation 'user' (celui qui répond)
            'price' => $this->response->proposed_price,
            'created_at' => now()->toIso8601String(),
        ];
    }
}