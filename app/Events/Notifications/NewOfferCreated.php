<?php

namespace App\Events\Notifications;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOfferCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Offer $offer;
    public User $creator;

    /**
     * Create a new event instance.
     *
     * @param Offer $offer
     * @param User $creator
     */
    public function __construct(Offer $offer, User $creator)
    {
        $this->offer = $offer;
        $this->creator = $creator;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.notifications'),
            // Broadcast to interested consumers (if applicable)
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'new.offer.created';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'offer_id' => $this->offer->id,
            'offer_title' => $this->offer->titre,
            'creator_name' => $this->creator->name,
            'created_at' => $this->offer->created_at->toIso8601String(),
        ];
    }
}