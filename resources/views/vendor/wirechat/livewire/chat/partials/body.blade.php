<main x-data="{
    height: 0,
    previousHeight: 0,
    updateScrollPosition: function() {
        newHeight = $el.scrollHeight;
        heightDifference = newHeight - height;
        $el.scrollTop += heightDifference;
        height = newHeight;
    }
}" 
x-init="
    setTimeout(() => {
        requestAnimationFrame(() => {
            this.height = $el.scrollHeight;
            $el.scrollTop = this.height;
        });
    }, 300);
"
@scroll="
    scrollTop = $el.scrollTop;
    if((scrollTop <= 0) && $wire.canLoadMore){
        $wire.loadMore();
    }
"
@update-height.window="
    requestAnimationFrame(() => {
        updateScrollPosition();
    });
"
@scroll-bottom.window="
    requestAnimationFrame(() => {
        $el.style.overflowY='hidden';
        $el.scrollTop = $el.scrollHeight;
        $el.style.overflowY='auto';
    });
"
x-cloak
class="flex flex-col h-full relative gap-4 p-4 md:p-6 lg:p-8 grow overscroll-contain overflow-x-hidden w-full my-auto bg-gradient-to-br from-gray-50 to-white"
style="contain: content">

    <!-- Loading indicator -->
    <div x-cloak wire:loading.delay.class.remove="invisible" wire:target="loadMore" 
         class="invisible transition-all duration-300 flex justify-center py-4">
        <div class="bg-white rounded-2xl shadow-lg px-6 py-4 flex items-center space-x-3">
            <x-wirechat::loading-spin />
        </div>
    </div>

    @php
        $previousMessage = null;
    @endphp

    <!-- Messages -->
    @if ($loadedMessages)
        @foreach ($loadedMessages as $date => $messageGroup)
            <!-- Date separator -->
            <div class="sticky top-2 uppercase p-3 px-6 z-50 rounded-2xl bg-white/80 backdrop-blur-lg border border-gray-200 text-sm font-semibold flex text-center justify-center shadow-lg mx-auto">
                <span class="text-primary-600 bg-primary-50 px-4 py-1 rounded-full">
                    {{ $date }}
                </span>
            </div>

            @foreach ($messageGroup as $key => $message)
                @php
                    $belongsToAuth = $message->belongsToAuth();
                    $parent = $message->parent ?? null;
                    $attachment = $message->attachment ?? null;
                    $isEmoji = $message->isEmoji();

                    if ($key > 0) {
                        $previousMessage = $messageGroup->get($key - 1);
                    }

                    $nextMessage = $key < $messageGroup->count() - 1 ? $messageGroup->get($key + 1) : null;
                @endphp

                <div class="flex gap-3 group hover:bg-gray-50/50 rounded-2xl p-2 transition-all duration-200" 
                     wire:key="message-{{ $key }}">

                    <!-- Avatar -->
                    @if (!$belongsToAuth && !$isPrivate)
                        <div @class([
                            'shrink-0 mb-auto transition-opacity duration-300',
                            'invisible opacity-0' => $previousMessage && $message?->sendable?->is($previousMessage?->sendable),
                            'visible opacity-100' => !$previousMessage || !$message?->sendable?->is($previousMessage?->sendable),
                        ])>
                            <x-wirechat::avatar src="{{ $message->sendable?->cover_url ?? null }}" :name="$message->sendable?->name"
                                class="h-10 w-10 rounded-2xl ring-2 ring-white shadow-md" />
                        </div>
                    @endif

                    <!-- Message content -->
                    <div class="flex-1 mx-auto space-y-3">
                        <div @class([
                            'max-w-[85%] md:max-w-[78%] flex flex-col space-y-3 transition-all duration-300',
                            'ml-auto' => $belongsToAuth
                        ])>

                            <!-- Reply section -->
                            @if ($parent != null)
                                @php
                                    $sender = $message?->ownedBy($this->auth)
                                        ? __('wirechat::chat.labels.you')
                                        : ($message->sendable?->display_name ?? __('wirechat::chat.labels.user'));

                                    $receiver = $parent?->ownedBy($this->auth)
                                        ? __('wirechat::chat.labels.you')
                                        : ($parent->sendable?->display_name ?? __('wirechat::chat.labels.user'));
                                @endphp

                                <div @class([
                                    'max-w-fit flex flex-col space-y-2',
                                    'ml-auto' => $belongsToAuth,
                                ])>
                                    <h6 class="text-xs text-gray-500 font-medium px-3">
                                        @if ($parent?->ownedBy($this->auth) && $message?->ownedBy($this->auth))
                                            {{ __('wirechat::chat.labels.you_replied_to_yourself') }}
                                        @elseif ($parent?->ownedBy($this->auth))
                                            {{ __('wirechat::chat.labels.participant_replied_to_you', ['sender' => $sender]) }}
                                        @elseif ($message?->ownedBy($parent->sendable))
                                            {{ __('wirechat::chat.labels.participant_replied_to_themself', ['sender' => $sender]) }}
                                        @else
                                            {{ __('wirechat::chat.labels.participant_replied_other_participant', ['sender' => $sender, 'receiver' => $receiver]) }}
                                        @endif
                                    </h6>

                                    <div @class([
                                        'px-3 border-l-4 border-primary-300 bg-white/80 rounded-2xl shadow-sm py-2',
                                        'border-r-4 border-l-0 ml-auto' => $belongsToAuth,
                                        'border-l-4 mr-auto' => !$belongsToAuth,
                                    ])>
                                        <p class="text-gray-700 line-clamp-2 text-sm font-medium">
                                            {{ $parent?->body != '' ? $parent?->body : ($parent->hasAttachment() ?  __('wirechat::chat.labels.attachment') : '') }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Message body section -->
                            <div @class([
                                'flex gap-3 group transition-all duration-300',
                                'justify-end' => $belongsToAuth,
                            ])>

                                <!-- Message actions -->
                                @if (($isGroup && $conversation->group?->allowsMembersToSendMessages()) || $authParticipant->isAdmin())
                                <div dusk="message_actions" @class([ 
                                    'my-auto flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300',
                                    'order-1' => !$belongsToAuth, 
                                ])>
                                    <!-- Reply button -->
                                    <button wire:click="setReply('{{ encrypt($message->id) }}')"
                                        class="p-2 bg-white rounded-full shadow-md hover:shadow-lg hover:scale-110 transition-all duration-200 hover:bg-primary-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-reply-fill w-4 h-4 text-primary-600"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M5.921 11.9 1.353 8.62a.72.72 0 0 1 0-1.238L5.921 4.1A.716.716 0 0 1 7 4.719V6c1.5 0 6 0 7 8-2.5-4.5-7-4-7-4v1.281c0 .56-.606.898-1.079.62z" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Dropdown actions -->
                                    <x-wirechat::dropdown class="w-48" align="{{ $belongsToAuth ? 'right' : 'left' }}" width="48">
                                        <x-slot name="trigger">
                                            <button class="p-2 bg-white rounded-full shadow-md hover:shadow-lg hover:scale-110 transition-all duration-200 hover:bg-gray-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor"
                                                    class="bi bi-three-dots h-3 w-3 text-gray-600"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            @if ($message->ownedBy($this->auth)|| ($authParticipant->isAdmin() && $isGroup))
                                                <button dusk="delete_message_for_everyone" wire:click="deleteForEveryone('{{ encrypt($message->id) }}')"
                                                    wire:confirm="{{ __('wirechat::chat.actions.delete_for_everyone.confirmation_message') }}" 
                                                    class="w-full text-start hover:bg-red-50 transition-colors">
                                                    <x-wirechat::dropdown-link class="text-red-600">
                                                        @lang('wirechat::chat.actions.delete_for_everyone.label')
                                                    </x-wirechat::dropdown-link>
                                                </button>
                                            @endif

                                            @if (!$isGroup)
                                            <button dusk="delete_message_for_me" wire:click="deleteForMe('{{ encrypt($message->id) }}')"
                                                wire:confirm="{{ __('wirechat::chat.actions.delete_for_me.confirmation_message') }}" 
                                                class="w-full text-start hover:bg-gray-50 transition-colors">
                                                <x-wirechat::dropdown-link>
                                                    @lang('wirechat::chat.actions.delete_for_me.label')
                                                </x-wirechat::dropdown-link>
                                                </button>
                                            @endif

                                            <button dusk="reply_to_message_button" wire:click="setReply('{{ encrypt($message->id) }}')"
                                                class="w-full text-start hover:bg-primary-50 transition-colors">
                                                <x-wirechat::dropdown-link class="text-primary-600">
                                                    @lang('wirechat::chat.actions.reply.label')
                                                </x-wirechat::dropdown-link>
                                            </button>
                                        </x-slot>
                                    </x-wirechat::dropdown>
                                </div>
                                @endif

                                <!-- Message content -->
                                <div class="flex flex-col space-y-2 max-w-[95%] relative">
                                    <!-- Sender name for groups -->
                                    @if (!$belongsToAuth && $isGroup)
                                        <div class="text-primary-600 font-semibold text-sm px-3"
                                            :class="{ 'hidden': {{ $message?->sendable?->is($previousMessage?->sendable) ? 'true' : 'false' }} }">
                                            {{ $message->sendable?->display_name }}
                                        </div>
                                    @endif

                                    <!-- Attachment section -->
                                    @if ($attachment)
                                        @if (str()->startsWith($attachment->mime_type, 'application/'))
                                            @include('wirechat::livewire.chat.partials.file', [ 'attachment' => $attachment ])
                                        @endif

                                        @if (str()->startsWith($attachment->mime_type, 'video/'))
                                            <x-wirechat::video height="max-h-[400px]" :cover="false" 
                                                source="{{ $attachment?->url }}" 
                                                class="rounded-2xl shadow-lg" />
                                        @endif

                                        @if (str()->startsWith($attachment->mime_type, 'image/'))
                                            @include('wirechat::livewire.chat.partials.image', [ 
                                                'previousMessage' => $previousMessage, 
                                                'message' => $message, 
                                                'nextMessage' => $nextMessage, 
                                                'belongsToAuth' => $belongsToAuth, 
                                                'attachment' => $attachment 
                                            ])
                                        @endif
                                    @endif

                                    <!-- Emoji message -->
                                    @if ($isEmoji)
                                        <div class="bg-white rounded-2xl p-4 shadow-sm">
                                            <p class="text-5xl text-center">
                                                {{ $message->body }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Text message -->
                                    @if ($message->body && !$isEmoji)
                                        @include('wirechat::livewire.chat.partials.message', [ 
                                            'previousMessage' => $previousMessage, 
                                            'message' => $message, 
                                            'nextMessage' => $nextMessage, 
                                            'belongsToAuth' => $belongsToAuth, 
                                            'isGroup' => $isGroup, 
                                            'attachment' => $attachment 
                                        ])
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    @endif

</main>