@use('Namu\WireChat\Facades\WireChat')

<header class="px-6 py-4 z-10 sticky top-0 w-full bg-white/80 backdrop-blur-lg border-b border-gray-100" dusk="header">

    {{-- Title/name and Icon --}}
    <section class="flex items-center justify-between pb-3">

        @if (isset($title))
            <div class="flex items-center gap-3 truncate" wire:ignore>
                <div class="bg-primary-500 text-white p-2 rounded-xl shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800" dusk="title">{{ $title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Communiquez avec la communauté</p>
                </div>
            </div>
        @endif

        <div class="flex gap-x-3 items-center">

            @if ($showNewChatModalButton)
                <x-wirechat::actions.new-chat widget="{{ $this->isWidget() }}">
                    <button id="open-new-chat-modal-button" 
                            class="flex items-center space-x-2 bg-primary-500 text-white px-4 py-2 rounded-xl hover:bg-primary-600 transition shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        {{-- <span class="font-medium">Nouveau</span> --}} 
                    </button>
                </x-wirechat::actions.new-chat>
            @endif

            {{-- Only show if is not widget --}}
            @if ($showHomeRouteButton)
                <a id="redirect-button" href="{{ config('wirechat.home_route', '/') }}" 
                   class="flex items-center p-2 hover:bg-gray-100 rounded-xl transition duration-200">
                    <svg class="w-6 h-6 text-gray-500 hover:text-gray-700 transition" 
                         xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor">
                            <path d="M5 12.76c0-1.358 0-2.037.274-2.634c.275-.597.79-1.038 1.821-1.922l1-.857C9.96 5.75 10.89 4.95 12 4.95s2.041.799 3.905 2.396l1 .857c1.03.884 1.546 1.325 1.82 1.922c.275.597.275 1.276.275 2.634V17c0 1.886 0 2.828-.586 3.414S16.886 21 15 21H9c-1.886 0-2.828 0-3.414-.586S5 18.886 5 17z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.5 21v-5a1 1 0 0 0-1-1h-3a1 1 0 0 0-1 1v5"/>
                        </g>
                    </svg>
                </a>
            @endif

        </div>

    </section>

    {{-- Search input --}}
    @if ($allowChatsSearch)
        <section class="mt-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input id="chats-search-field" 
                       name="chats_search" 
                       maxlength="100" 
                       type="search" 
                       wire:model.live.debounce='search'
                       placeholder="{{ __('wirechat::chats.inputs.search.placeholder') }}" 
                       autocomplete="off"
                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition placeholder-gray-500">
            </div>
        </section>
    @endif

</header>