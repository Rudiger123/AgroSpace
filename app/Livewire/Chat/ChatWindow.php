<?php

// app/Livewire/ChatWindow.php

namespace App\Livewire\Chat;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Events\UserTyping;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatWindow extends Component
{
    use WithFileUploads;

    public ?int $conversationId = null;
    public $conversation = null;
    public $messages = [];
    public $newMessage = '';
    public $typingUsers = [];
    public $loadingMore = false;
    public $hasMore = true;
    public $perPage = 50;

    // Fichiers joints
    public $attachments = [];

    protected $listeners = [
        'conversationSelected' => 'loadConversation',
        'messageReceived' => 'handleMessageReceived',
        'userTyping' => 'handleUserTyping',
        'messageRead' => 'handleMessageRead',
    ];

    protected $rules = [
        'newMessage' => 'required|string|max:5000',
        'attachments.*' => 'file|max:10240', // 10MB max
    ];

    /**
     * Charger une conversation
     */
    public function loadConversation($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->conversation = Conversation::with('users')
            ->findOrFail($conversationId);

        // Vérifier autorisation
        abort_unless(
            $this->conversation->hasParticipant(Auth::user()),
            403
        );

        $this->loadMessages();
        $this->markAsRead();
    }

    /**
     * Charger les messages
     */
    public function loadMessages($loadMore = false)
    {
        if (!$this->conversationId) {
            return;
        }

        $query = Message::where('conversation_id', $this->conversationId)
            ->with('user')
            ->orderByDesc('created_at');

        if ($loadMore && count($this->messages) > 0) {
            // Charger messages plus anciens
            $oldestMessage = collect($this->messages)->last();
            $query->where('created_at', '<', $oldestMessage['created_at']);
        }

        $newMessages = $query->limit($this->perPage)->get();

        $this->hasMore = $newMessages->count() === $this->perPage;

        $formattedMessages = $newMessages->map(function ($message) {
            return [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'user_name' => $message->user->name,
                'content' => $message->content,
                'attachments' => $message->attachments,
                'created_at' => $message->created_at->toISOString(),
                'formatted_time' => $message->created_at->format('H:i'),
                'is_mine' => $message->user_id === Auth::id(),
            ];
        })->reverse()->values()->toArray();

        if ($loadMore) {
            $this->messages = array_merge($formattedMessages, $this->messages);
        } else {
            $this->messages = $formattedMessages;
        }

        $this->loadingMore = false;
    }

    /**
     * Charger plus de messages (scroll vers le haut)
     */
    public function loadMore()
    {
        if (!$this->hasMore || $this->loadingMore) {
            return;
        }

        $this->loadingMore = true;
        $this->loadMessages(true);
    }

    /**
     * Envoyer un message
     */
    public function sendMessage()
    {
        $this->validate();

        if (!$this->conversationId) {
            return;
        }

        // Upload des attachments si présents
        $uploadedFiles = [];
        foreach ($this->attachments as $file) {
            $path = $file->store('chat-attachments', 'public');
            $uploadedFiles[] = asset('storage/' . $path);
        }

        // Créer le message
        $message = Message::create([
            'conversation_id' => $this->conversationId,
            'user_id' => Auth::id(),
            'content' => $this->newMessage,
            'attachments' => !empty($uploadedFiles) ? $uploadedFiles : null,
            'type' => !empty($uploadedFiles) ? 'file' : 'text',
        ]);

        $message->load('user');

        // Ajouter à la liste locale immédiatement
        $this->messages[] = [
            'id' => $message->id,
            'user_id' => $message->user_id,
            'user_name' => $message->user->name,
            'content' => $message->content,
            'attachments' => $message->attachments,
            'created_at' => $message->created_at->toISOString(),
            'formatted_time' => $message->created_at->format('H:i'),
            'is_mine' => true,
        ];

        // Diffuser l'événement
        broadcast(new MessageSent($message))->toOthers();

        // Réinitialiser le formulaire
        $this->reset(['newMessage', 'attachments']);
        $this->dispatch('messageSent'); // Pour scroll JS
    }

    /**
     * Gérer la réception d'un nouveau message (depuis Echo)
     */
    public function handleMessageReceived($data)
    {
        $message = $data['message'];

        // Ajouter le message si pas déjà présent
        if (!collect($this->messages)->contains('id', $message['id'])) {
            $this->messages[] = [
                'id' => $message['id'],
                'user_id' => $message['user_id'],
                'user_name' => $message['user_name'],
                'content' => $message['content'],
                'attachments' => $message['attachments'],
                'created_at' => $message['created_at'],
                'formatted_time' => now()->parse($message['created_at'])->format('H:i'),
                'is_mine' => $message['user_id'] === Auth::id(),
            ];

            $this->dispatch('messageReceived'); // Pour scroll JS
            $this->markAsRead();
        }
    }

    /**
     * Gérer l'indicateur "en train d'écrire"
     */
    public function handleUserTyping($data)
    {
        $userId = $data['user_id'];
        $userName = $data['user_name'];

        // Ajouter ou rafraîchir l'utilisateur qui tape
        $this->typingUsers[$userId] = [
            'name' => $userName,
            'timestamp' => now()->timestamp,
        ];

        // Supprimer automatiquement après 3 secondes
        $this->dispatch('clearTypingIndicator', userId: $userId);
    }

    /**
     * Émettre événement "typing" (throttle côté JS)
     */
    public function typing()
    {
        if (!$this->conversationId) {
            return;
        }

        broadcast(new UserTyping(Auth::user(), $this->conversationId))->toOthers();
    }

    /**
     * Marquer les messages comme lus
     */
    public function markAsRead()
    {
        if (!$this->conversationId) {
            return;
        }

        $this->conversation->markAsReadFor(Auth::user());

        // Informer les autres participants
        $lastMessage = Message::where('conversation_id', $this->conversationId)
            ->latest()
            ->first();

        if ($lastMessage && $lastMessage->user_id !== Auth::id()) {
            broadcast(new MessageRead($lastMessage, Auth::user()))->toOthers();
        }

        // Rafraîchir la liste des conversations
        $this->dispatch('refreshConversations')->to(ChatList::class);
    }

    /**
     * Gérer la lecture de messages (depuis Echo)
     */
    public function handleMessageRead($data)
    {
        // Mettre à jour l'UI si nécessaire (accusé de lecture)
        $this->dispatch(
            'messageReadByUser',
            messageId: $data['message_id'],
            userId: $data['user_id']
        );
    }

    public function render()
    {
        return view('livewire.chat.chat-window');
    }
}
