{{-- resources/views/livewire/chat-window.blade.php --}}

<div class="flex flex-col h-full bg-gray-50">
    @if ($conversation)
        {{-- Header de la conversation --}}
        <div class="bg-white border-b border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if ($conversation->type === 'private')
                        @php
                            $otherUser = $conversation->getOtherParticipant(auth()->user());
                        @endphp
                        <div class="relative">
                            <div
                                class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr($otherUser?->name ?? '?', 0, 1) }}
                            </div>
                            @if ($otherUser?->is_online)
                                <span
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $otherUser?->name }}</h3>
                            <p class="text-sm text-gray-500">
                                @if ($otherUser?->is_online)
                                    En ligne
                                @else
                                    Hors ligne
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $conversation->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $conversation->users->count() }} membres</p>
                        </div>
                    @endif
                </div>

                <button class="p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Zone des messages --}}
        <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-4" wire:ignore.self>
            {{-- Bouton charger plus --}}
            @if ($hasMore)
                <div class="text-center">
                    <button wire:click="loadMore"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="loadMore">Charger plus de messages</span>
                        <span wire:loading wire:target="loadMore">Chargement...</span>
                    </button>
                </div>
            @endif

            {{-- Messages --}}
            @foreach ($messages as $message)
                <div class="flex {{ $message['is_mine'] ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        @if (!$message['is_mine'])
                            <p class="text-xs text-gray-500 mb-1 px-1">{{ $message['user_name'] }}</p>
                        @endif

                        <div
                            class="
                            {{ $message['is_mine']
                                ? 'bg-green-500 text-white rounded-l-lg rounded-tr-lg'
                                : 'bg-white text-gray-900 rounded-r-lg rounded-tl-lg border border-gray-200' }} 
                            p-3 shadow-sm
                        ">
                            <p class="break-words">{{ $message['content'] }}</p>

                            @if ($message['attachments'])
                                <div class="mt-2 space-y-2">
                                    @foreach ($message['attachments'] as $attachment)
                                        <a href="{{ $attachment }}" target="_blank" class="block text-sm underline">
                                            📎 Fichier joint
                                        </a>
                                    @endforeach
                                </div>
                            @endif

                            <p class="text-xs mt-1 {{ $message['is_mine'] ? 'text-green-100' : 'text-gray-400' }}">
                                {{ $message['formatted_time'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Indicateur "en train d'écrire" --}}
            @if (count($typingUsers) > 0)
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <div class="flex gap-1">
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                            style="animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                            style="animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                            style="animation-delay: 300ms"></span>
                    </div>
                    <span>
                        {{ collect($typingUsers)->pluck('name')->join(', ') }}
                        {{ count($typingUsers) > 1 ? 'sont en train d\'écrire' : 'est en train d\'écrire' }}...
                    </span>
                </div>
            @endif
        </div>

        {{-- Formulaire d'envoi --}}
        <div class="bg-white border-t border-gray-200 p-4">
            <form wire:submit="sendMessage" class="flex items-end gap-2">
                <div class="flex-1">
                    <textarea wire:model="newMessage" wire:keydown="typing" placeholder="Écrivez votre message..." rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"></textarea>

                    {{-- Upload de fichiers --}}
                    <div class="mt-2">
                        <input type="file" wire:model="attachments" multiple class="hidden" id="file-upload">
                        <label for="file-upload" class="text-sm text-gray-500 hover:text-gray-700 cursor-pointer">
                            📎 Joindre des fichiers
                        </label>

                        @if ($attachments)
                            <div class="mt-1 text-sm text-gray-600">
                                {{ count($attachments) }} fichier(s) sélectionné(s) </div>
                        @endif
                    </div>
                </div>

                <button type="submit"
                    class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span>Envoyer</span>
                    {{-- <span wire:loading.remove>Envoyer</span>
                    <span wire:loading>...</span> --}}
                </button>
            </form>

            @error('newMessage')
                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>
    @else
        {{-- État vide : aucune conversation sélectionnée --}}
        <div class="flex-1 flex items-center justify-center text-gray-400">
            <div class="text-center">
                <svg class="w-24 h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2">Sélectionnez une conversation</h3>
                <p class="text-sm">Choisissez une conversation dans la liste pour commencer à discuter</p>
            </div>
        </div>
    @endif
</div>

@script
    <script>
        // Auto-scroll vers le bas lors de nouveaux messages
        $wire.on('messageSent', () => {
            scrollToBottom();
        });

        $wire.on('messageReceived', () => {
            scrollToBottom();
            // Jouer un son de notification
            playNotificationSound();
        });

        // Nettoyer l'indicateur typing après délai
        $wire.on('clearTypingIndicator', (data) => {
            setTimeout(() => {
                $wire.typingUsers = Object.fromEntries(
                    Object.entries($wire.typingUsers).filter(([key]) => key !== data.userId.toString())
                );
            }, 3000);
        });

        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }

        function playNotificationSound() {
            const audio = new Audio('/sounds/notification.mp3');
            audio.volume = 0.3;
            audio.play().catch(() => {
                // Ignorer si autoplay bloqué
            });
        }

        // Scroll initial
        document.addEventListener('livewire:initialized', () => {
            setTimeout(scrollToBottom, 100);
        });
    </script>
@endscript
