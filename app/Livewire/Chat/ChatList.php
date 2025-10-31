<?php

// app/Livewire/ChatList.php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ChatList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedConversationId = null;

    protected $listeners = [
        'conversationSelected' => 'selectConversation',
        'refreshConversations' => '$refresh',
    ];

    /**
     * Sélectionner une conversation et émettre événement
     */
    public function selectConversation($conversationId)
    {
        $this->selectedConversationId = $conversationId;

        // Émettre événement pour ChatWindow
        $this->dispatch('conversationSelected', conversationId: $conversationId);
    }

    /**
     * Recherche de conversations
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Créer une nouvelle conversation (avec un autre user)
     */
    public function startConversation($otherUserId)
    {
        $otherUser = \App\Models\User::findOrFail($otherUserId);

        // Créer ou récupérer conversation privée
        $conversation = Conversation::findOrCreatePrivate(
            Auth::user(),
            $otherUser
        );

        $this->selectConversation($conversation->id);
    }

    public function render()
    {
        $conversations = Conversation::query()
            ->forUser(Auth::user())
            ->with(['lastMessage.user', 'users'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    // Rechercher dans nom de conversation ou nom des participants
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('users', function ($userQuery) {
                          $userQuery->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(20);

        return view('livewire.chat.chat-list', [
            'conversations' => $conversations,
        ]);
    }
}
