<?php

// app/Events/MessageSent.php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Événement diffusé quand un message est envoyé
 * Sera reçu par tous les participants de la conversation via WebSocket
 */
class MessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public Message $message
    ) {
    }

    /**
     * Canal de diffusion : privé, limité aux participants
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->conversation_id),
        ];
    }

    /**
     * Nom de l'événement côté client (Echo écoutera ceci)
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    /**
     * Données envoyées aux clients
     */
    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'conversation_id' => $this->message->conversation_id,
                'user_id' => $this->message->user_id,
                'user_name' => $this->message->user->name,
                'content' => $this->message->content,
                'attachments' => $this->message->attachments,
                'type' => $this->message->type,
                'created_at' => $this->message->created_at->toISOString(),
            ],
        ];
    }

    /**
     * Optionnel : Envoyer l'événement en queue pour ne pas bloquer
     */
    public function broadcastQueue(): string
    {
        return 'broadcasting';
    }
}
