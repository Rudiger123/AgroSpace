@use('Namu\WireChat\Facades\WireChat')
<ul wire:loading.delay.long.remove wire:target="search" class="p-0">
    @foreach ($conversations as $key => $conversation)
        @php
            $group = $conversation->isGroup() ? $conversation->group : null;
            $receiver = $conversation->isGroup()
                ? null
                : ($conversation->isPrivate()
                    ? $conversation->peer_participant?->participantable
                    : $this->auth);
            $lastMessage = $conversation->lastMessage;
            $isReadByAuth =
                $conversation?->readBy($conversation->auth_participant ?? $this->auth) ||
                $selectedConversationId == $conversation->id;
            $belongsToAuth = $lastMessage?->belongsToAuth();
        @endphp

        <li x-data="{
            conversationID: @js($conversation->id),
            showUnreadStatus: @js(!$isReadByAuth),
            handleChatOpened(event) {
                if (event.detail.conversation == this.conversationID) {
                    this.showUnreadStatus = false;
                }
                $wire.selectedConversationId = event.detail.conversation;
            },
            handleChatClosed(event) {
                $wire.selectedConversationId = null;
            },
            handleOpenChat(event) {
                if (this.showUnreadStatus && event.detail.conversation == this.conversationID) {
                    this.showUnreadStatus = false;
                }
            }
        }" id="conversation-{{ $conversation->id }}"
            wire:key="conversation-em-{{ $conversation->id }}-{{ $conversation->updated_at->timestamp }}"
            x-on:chat-opened.window="handleChatOpened($event)" x-on:chat-closed.window="handleChatClosed($event)"
            class="animate-slideIn border-b border-gray-100 last:border-b-0"
            :style="'animation-delay: {{ $key * 50 }}ms'">

            <a @if ($widget) tabindex="0" 
                role="button" 
                dusk="openChatWidgetButton"
                @click="$dispatch('open-chat',{conversation:@js($conversation->id)})"
                @keydown.enter="$dispatch('open-chat',{conversation:@js($conversation->id)})"
            @else
                wire:navigate href="{{ route(WireChat::viewRouteName(), $conversation->id) }}" 
            @endif
                :class="$wire.selectedConversationId == conversationID ?
                    'bg-primary-50 border-r-4 border-primary-500' :
                    'bg-white hover:bg-gray-50 border-r-4 border-transparent'"
                class="p-4 cursor-pointer transition-all duration-200 w-full flex items-start space-x-4 relative">

                <!-- Avatar avec statut en ligne -->
                <div class="relative flex-shrink-0">
                    <x-wirechat::avatar disappearing="{{ $conversation->hasDisappearingTurnedOn() }}" :name="$group ? $group?->name : $receiver?->name"
                        group="{{ $conversation->isGroup() }}" :src="$group ? $group?->cover_url : $receiver?->cover_url ?? null" 
                        class="w-12 h-12 rounded-full object-cover" />

                    <!-- Indicateur en ligne -->
                    @if ($receiver && method_exists($receiver, 'isOnline') && $receiver->isOnline())
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    @endif
                </div>

                <!-- Contenu de la conversation -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <!-- Nom -->
                        <h4 class="font-semibold text-gray-900 truncate flex items-center space-x-2">
                            <span>{{ $group ? $group?->name : $receiver?->display_name }}</span>
                            @if ($conversation->isSelfConversation())
                                <span class="text-xs text-gray-500">({{ __('wirechat::chats.labels.you') }})</span>
                            @endif
                        </h4>

                        <!-- Heure du dernier message -->
                        @if ($lastMessage)
                            <span class="text-xs text-gray-500 whitespace-nowrap flex-shrink-0 ml-2">
                                {{ $lastMessage->created_at->format('H:i') }}
                            </span>
                        @endif
                    </div>

                    <!-- Dernier message et badge non lu -->
                    <div class="flex items-center justify-between">
                        @if ($lastMessage)
                            <p class="text-sm text-gray-600 truncate flex-1 pr-2">
                                @include('wirechat::livewire.chats.partials.message-body')
                            </p>
                        @else
                            <p class="text-sm text-gray-400 italic flex-1">Aucun message</p>
                        @endif

                        <!-- Badge non lu -->
                        @if ($lastMessage != null && !$lastMessage?->ownedBy($this->auth) && !$isReadByAuth)
                            <div x-show="showUnreadStatus" dusk="unreadMessagesDot" class="flex-shrink-0 ml-2">
                                <span class="bg-primary-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center"
                                    dusk="unreadDotItem">
                                    ●
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Badge rôle/type -->
                    <div class="flex items-center space-x-2 mt-2">
                        @if ($conversation->isGroup())
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">
                                👥 Groupe
                            </span>
                        @elseif($receiver)
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                {{ $receiver->role === 'producteur' ? 
                                   'bg-green-100 text-green-700' : 
                                   'bg-blue-100 text-blue-700' }}">
                                {{ $receiver->role === 'producteur' ? '👨‍🌾 Producteur' : '🛒 Consommateur' }}
                            </span>
                        @endif

                        <!-- Indicateur de message éphémère -->
                        @if ($conversation->hasDisappearingTurnedOn())
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Éphémère
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        </li>
    @endforeach
</ul>

<!-- État vide -->
@if ($conversations->count() === 0)
    <div class="p-8 text-center border-t border-gray-100">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Aucune conversation</h3>
        <p class="text-gray-500 mb-4">Commencez une nouvelle conversation pour échanger</p>
        <button class="bg-primary-500 text-white px-6 py-3 rounded-lg hover:bg-primary-600 transition inline-flex items-center space-x-2 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Nouvelle conversation</span>
        </button>
    </div>
@endif