<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Événement diffusé quand un utilisateur tape un message
 * Ne doit PAS être mis en queue (temps réel immédiat)
 */
class UserTyping implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public User $user,
        public int $conversationId
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->conversationId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }

    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'conversation_id' => $this->conversationId,
        ];
    }

    /**
     * Important : Ne PAS mettre en queue (synchrone)
     */
    public function shouldQueue(): bool
    {
        return false;
    }
}
