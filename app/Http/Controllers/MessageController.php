<?php

// app/Http/Controllers/MessageController.php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Envoyer un nouveau message
     */
    public function store(Request $request, Conversation $conversation)
    {
        // Vérifier que l'utilisateur participe à la conversation
        abort_unless(
            $conversation->hasParticipant($request->user()),
            403,
            'Vous ne participez pas à cette conversation'
        );

        // Validation
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
            'attachments' => 'nullable|array',
            'attachments.*' => 'url',
            'type' => 'in:text,image,file',
        ]);

        // Créer le message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
            'attachments' => $validated['attachments'] ?? null,
            'type' => $validated['type'] ?? 'text',
        ]);

        // Charger la relation user pour l'événement
        $message->load('user');

        // 🚀 Diffuser l'événement via Reverb
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message,
            'status' => 'sent',
        ], 201);
    }
}
