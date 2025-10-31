{{-- resources/views/livewire/chat-list.blade.php --}}

<div class="flex flex-col h-full bg-white border-r border-gray-200">
    {{-- Header avec recherche --}}
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-3">Conversations</h2>
        
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search"
            placeholder="Rechercher une conversation..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
        >
    </div>

    {{-- Liste des conversations --}}
    <div class="flex-1 overflow-y-auto">
        @forelse($conversations as $conversation)
            <button
                wire:click="selectConversation({{ $conversation->id }})"
                class="w-full p-4 border-b border-gray-100 hover:bg-gray-50 transition text-left
                    {{ $selectedConversationId == $conversation->id ? 'bg-green-50 border-l-4 border-green-500' : '' }}"
            >
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        {{-- Nom de la conversation --}}
                        <div class="flex items-center gap-2 mb-1">
                            @if($conversation->type === 'group')
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $conversation->name }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    ({{ $conversation->users->count() }} membres)
                                </span>
                            @else
                                @php
                                    $otherUser = $conversation->getOtherParticipant(auth()->user());
                                @endphp
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $otherUser?->name ?? 'Utilisateur inconnu' }}
                                </span>
                                
                                {{-- Indicateur en ligne --}}
                                @if($otherUser?->is_online)
                                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                @endif
                            @endif
                        </div>

                        {{-- Dernier message --}}
                        @if($conversation->lastMessage)
                            <p class="text-sm text-gray-600 truncate">
                                @if($conversation->lastMessage->user_id === auth()->id())
                                    <span class="text-gray-500">Vous:</span>
                                @endif
                                {{ Str::limit($conversation->lastMessage->content, 50) }}
                            </p>
                            <span class="text-xs text-gray-400">
                                {{ $conversation->lastMessage->created_at->diffForHumans() }}
                            </span>
                        @else
                            <p class="text-sm text-gray-400 italic">Aucun message</p>
                        @endif
                    </div>

                    {{-- Badge messages non lus --}}
                    @php
                        $unreadCount = $conversation->unreadCountFor(auth()->user());
                    @endphp
                    @if($unreadCount > 0)
                        <span class="ml-2 px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </div>
            </button>
        @empty
            <div class="p-8 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p>Aucune conversation</p>
                <p class="text-sm mt-1">Commencez à discuter avec d'autres utilisateurs</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($conversations->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $conversations->links() }}
        </div>
    @endif
</div>