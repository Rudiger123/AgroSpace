@use('Namu\WireChat\Facades\WireChat')

@php
    $group = $conversation->group;
@endphp

<header class="w-full sticky inset-x-0 top-0 z-50 bg-gradient-to-r from-white to-gray-50/80 backdrop-blur-lg border-b border-gray-200 shadow-sm">

    <div class="flex w-full items-center px-4 py-3 lg:px-6 gap-3 md:gap-4">

        {{-- Return Button --}}
        <a @if ($this->isWidget()) 
            @click="$dispatch('close-chat',{conversation: {{json_encode($conversation->id)}} })"
            dusk="return_to_home_button_dispatch"
        @else
            href="{{ route(WireChat::indexRouteName(), $conversation->id) }}"
            dusk="return_to_home_button_link" 
        @endif
            @class([
                'shrink-0 cursor-pointer p-2 bg-white rounded-xl shadow-sm hover:shadow-md hover:bg-primary-50 transition-all duration-200 group',
                'lg:hidden' => !$this->isWidget(),
            ]) id="chatReturn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5 text-gray-600 group-hover:text-primary-600 transition-colors">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </a>

        {{-- Chat Info Section --}}
        <section class="flex items-center flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-1 min-w-0">

                {{-- Group Conversation --}}
                @if ($conversation->isGroup())
                    <x-wirechat::actions.show-group-info conversation="{{ $conversation->id }}"
                        widget="{{ $this->isWidget() }}">
                        <div class="flex items-center gap-3 cursor-pointer group flex-1 min-w-0">
                            <div class="relative">
                                <x-wirechat::avatar disappearing="{{ $conversation->hasDisappearingTurnedOn() }}"
                                    :group="true" :src="$group?->cover_url ?? null" :name="$group?->name"
                                    class="h-12 w-12 rounded-2xl ring-2 ring-white shadow-md group-hover:ring-primary-100 transition-all" />
                                @if($conversation->hasDisappearingTurnedOn())
                                <div class="absolute -bottom-1 -right-1 bg-primary-500 rounded-full p-1 shadow-lg">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h6 class="font-bold text-lg text-gray-900 truncate group-hover:text-primary-700 transition-colors">
                                    {{ $group?->name }}
                                </h6>
                                <p class="text-sm text-primary-600 font-medium flex items-center space-x-1">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                    <span>En ligne • {{ $conversation->participants->count() }} membres</span>
                                </p>
                            </div>
                        </div>
                    </x-wirechat::actions.show-group-info>
                @else
                    {{-- Private Conversation --}}
                    <x-wirechat::actions.show-chat-info conversation="{{ $conversation->id }}"
                        widget="{{ $this->isWidget() }}">
                        <div class="flex items-center gap-3 cursor-pointer group flex-1 min-w-0">
                            <div class="relative">
                                <x-wirechat::avatar disappearing="{{ $conversation->hasDisappearingTurnedOn() }}"
                                    :group="false" :src="$receiver?->cover_url ?? null" :name="$receiver?->name"
                                    class="h-12 w-12 rounded-2xl ring-2 ring-white shadow-md group-hover:ring-primary-100 transition-all" />
                                @if($conversation->hasDisappearingTurnedOn())
                                <div class="absolute -bottom-1 -right-1 bg-primary-500 rounded-full p-1 shadow-lg">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h6 class="font-bold text-lg text-gray-900 truncate group-hover:text-primary-700 transition-colors">
                                    {{ $receiver?->display_name }}
                                    @if ($conversation->isSelfConversation())
                                        <span class="text-primary-600 text-sm font-normal">({{ __('wirechat::chat.labels.you') }})</span>
                                    @endif
                                </h6>
                                <p class="text-sm text-gray-600 flex items-center space-x-1">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                    <span>En ligne • 
                                        <span class="font-medium {{ $receiver->role === 'producteur' ? 'text-green-600' : 'text-blue-600' }}">
                                            {{ $receiver->role === 'producteur' ? '👨‍🌾 Producteur' : '🛒 Consommateur' }}
                                        </span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </x-wirechat::actions.show-chat-info>
                @endif

            </div>

            {{-- Header Actions --}}
            <div class="flex items-center ml-2">
                <x-wirechat::dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="cursor-pointer inline-flex p-2 bg-white rounded-xl shadow-sm hover:shadow-md hover:bg-primary-50 transition-all duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="w-5 h-5 text-gray-600 group-hover:text-primary-600 transition-colors">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                    </x-slot>
                    
                    <x-slot name="content">
                        <div class="py-1 bg-white rounded-xl shadow-xl border border-gray-200">

                            @if ($conversation->isGroup())
                                {{-- Open group info button --}}
                                <x-wirechat::actions.show-group-info conversation="{{ $conversation->id }}"
                                    widget="{{ $this->isWidget() }}">
                                    <button class="w-full text-start hover:bg-primary-50 transition-colors rounded-lg mx-1">
                                        <div class="flex items-center space-x-3 px-3 py-2">
                                            <div class="bg-primary-100 rounded-lg p-2">
                                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium">{{ __('wirechat::chat.actions.open_group_info.label') }}</span>
                                        </div>
                                    </button>
                                </x-wirechat::actions.show-group-info>
                            @else
                                {{-- Open chat info button --}}
                                <x-wirechat::actions.show-chat-info conversation="{{ $conversation->id }}"
                                    widget="{{ $this->isWidget() }}">
                                    <button class="w-full text-start hover:bg-primary-50 transition-colors rounded-lg mx-1">
                                        <div class="flex items-center space-x-3 px-3 py-2">
                                            <div class="bg-primary-100 rounded-lg p-2">
                                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <span class="text-gray-700 font-medium">{{ __('wirechat::chat.actions.open_chat_info.label') }}</span>
                                        </div>
                                    </button>
                                </x-wirechat::actions.show-chat-info>
                            @endif

                            <div class="border-t border-gray-100 my-1"></div>

                            @if ($this->isWidget())
                                <button @click="$dispatch('close-chat',{conversation: {{json_encode($conversation->id)}} })" 
                                    class="w-full text-start hover:bg-gray-50 transition-colors rounded-lg mx-1">
                                    <div class="flex items-center space-x-3 px-3 py-2">
                                        <div class="bg-gray-100 rounded-lg p-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700 font-medium">@lang('wirechat::chat.actions.close_chat.label')</span>
                                    </div>
                                </button>
                            @else
                                <a href="{{ route(WireChat::indexRouteName()) }}" 
                                    class="w-full text-start hover:bg-gray-50 transition-colors rounded-lg mx-1 block">
                                    <div class="flex items-center space-x-3 px-3 py-2">
                                        <div class="bg-gray-100 rounded-lg p-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700 font-medium">@lang('wirechat::chat.actions.close_chat.label')</span>
                                    </div>
                                </a>
                            @endif

                            {{-- Only show delete and clear if conversation is NOT group --}}
                            @if (!$conversation->isGroup())
                                <div class="border-t border-gray-100 my-1"></div>

                                <button class="w-full text-start hover:bg-orange-50 transition-colors rounded-lg mx-1" 
                                    wire:click="clearConversation"
                                    wire:confirm="{{ __('wirechat::chat.actions.clear_chat.confirmation_message') }}">
                                    <div class="flex items-center space-x-3 px-3 py-2">
                                        <div class="bg-orange-100 rounded-lg p-2">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </div>
                                        <span class="text-gray-700 font-medium">@lang('wirechat::chat.actions.clear_chat.label')</span>
                                    </div>
                                </button>

                                <button wire:click="deleteConversation"
                                    wire:confirm="{{ __('wirechat::chat.actions.delete_chat.confirmation_message') }}"
                                    class="w-full text-start hover:bg-red-50 transition-colors rounded-lg mx-1">
                                    <div class="flex items-center space-x-3 px-3 py-2">
                                        <div class="bg-red-100 rounded-lg p-2">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </div>
                                        <span class="text-red-600 font-medium">@lang('wirechat::chat.actions.delete_chat.label')</span>
                                    </div>
                                </button>
                            @endif

                            @if ($conversation->isGroup() && !$this->auth->isOwnerOf($conversation))
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <button wire:click="exitConversation"
                                    wire:confirm="{{ __('wirechat::chat.actions.exit_group.confirmation_message') }}"
                                    class="w-full text-start hover:bg-red-50 transition-colors rounded-lg mx-1">
                                    <div class="flex items-center space-x-3 px-3 py-2">
                                        <div class="bg-red-100 rounded-lg p-2">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                                            </svg>
                                        </div>
                                        <span class="text-red-600 font-medium">@lang('wirechat::chat.actions.exit_group.label')</span>
                                    </div>
                                </button>
                            @endif

                        </div>
                    </x-slot>
                </x-wirechat::dropdown>
            </div>
        </section>

    </div>

</header>