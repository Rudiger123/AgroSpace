<div x-data="{
    open: @entangle('isOpen'),
    query: @entangle('query').live,
    selectedIndex: @entangle('selectedIndex')
}" x-init="$watch('open', value => {
    if (value) {
        $nextTick(() => $refs.searchInput.focus());
    }
});

window.addEventListener('keydown', (e) => {
    // Ctrl+K or Cmd+K to open search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        @this.call('open');
    }

    // Escape to close
    if (e.key === 'Escape' && open) {
        @this.call('close');
    }

    // Arrow navigation when open
    if (open) {
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            @this.call('selectNext');
        }
        if (e.key === 'ArrowUp') {
            e.preventDefault();
            @this.call('selectPrevious');
        }
        if (e.key === 'Enter' && selectedIndex >= 0) {
            e.preventDefault();
            @this.call('selectResult');
        }
    }
});">

    <!-- Search Trigger Button (Responsive) -->
    <button @click="@this.call('open')" type="button"
        class="flex items-center space-x-2 sm:space-x-3 w-full px-3 sm:px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200 group">
        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 group-hover:text-gray-600 flex-shrink-0" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <span class="flex-1 text-left text-xs sm:text-sm truncate md:block hidden">Rechercher...</span>
        <kbd
            class="hidden sm:inline-flex items-center px-2 py-1 text-xs font-semibold text-gray-500 bg-white border border-gray-300 rounded">
            <span class="text-xs">⌘</span>K
        </kbd>
    </button>

    <!-- Search Modal (Responsive) -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm transition-opacity overflow-y-auto"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <!-- Background Overlay -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="@this.call('close')"></div>

        <!-- Modal Content (Responsive) --> 
        <div class="flex min-h-screen items-start justify-center p-2 sm:p-4 pt-4 sm:pt-20">
            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                class="relative w-full max-w-2xl transform overflow-hidden rounded-xl sm:rounded-2xl bg-white shadow-2xl transition-all"
                @click.away="@this.call('close')">

                <!-- Search Input (Responsive) -->
                <div class="relative border-b border-gray-200">
                    <div class="flex items-center px-3 sm:px-4">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input x-ref="searchInput" wire:model.live.debounce.300ms="query" type="text"
                            placeholder="Rechercher..."
                            class="w-full px-3 sm:px-4 py-3 sm:py-4 text-base sm:text-lg text-gray-900 placeholder-gray-500 bg-transparent border-0 focus:outline-none focus:ring-0"
                            autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">

                        @if ($query)
                            <button @click="query = ''; @this.set('query', '')"
                                class="flex-shrink-0 p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                    </div>

                    <!-- Loading Indicator -->
                    <div wire:loading wire:target="query" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary-500">
                        <div class="h-full bg-primary-600 animate-pulse"></div>
                    </div>
                </div>

                <!-- Search Results (Responsive) -->
                <div class="max-h-[60vh] sm:max-h-96 overflow-y-auto">
                    @if (strlen($query) < 2)
                        <div class="px-4 sm:px-6 py-8 sm:py-12 text-center">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-gray-300 mb-3 sm:mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-base sm:text-lg font-medium">Commencez à taper pour rechercher</p>
                            <p class="text-gray-400 text-xs sm:text-sm mt-2">Articles, offres, demandes, utilisateurs...</p>
                        </div>
                    @elseif($totalResults > 0)
                        <div class="py-2">
                            <div class="px-3 sm:px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                {{ $totalResults }} résultat{{ $totalResults > 1 ? 's' : '' }}
                                trouvé{{ $totalResults > 1 ? 's' : '' }}
                            </div>

                            @foreach ($results as $index => $result)
                                <button wire:click="goToResult({{ $index }})"
                                    class="w-full text-left px-3 sm:px-4 py-3 hover:bg-gray-50 transition-colors duration-150 flex items-start space-x-3 sm:space-x-4 group {{ $selectedIndex === $index ? 'bg-primary-50' : '' }}"
                                    type="button">

                                    <!-- Icon (Responsive) -->
                                    <div
                                        class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 rounded-lg {{ $result['color'] }} flex items-center justify-center">
                                        {!! $result['icon'] !!}
                                    </div>

                                    <!-- Content (Responsive) -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 mb-1">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $result['title'] }}
                                            </p>
                                            <span
                                                class="flex-shrink-0 px-2 py-0.5 text-xs font-medium rounded-full {{ $result['color'] }} inline-block mt-1 sm:mt-0 w-fit">
                                                {{ $result['label'] }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-gray-600 line-clamp-2 mb-2">
                                            {{ $result['excerpt'] }}
                                        </p>

                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500">
                                            <span class="flex items-center space-x-1">
                                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                <span class="truncate max-w-[100px] sm:max-w-none">{{ $result['author'] }}</span>
                                            </span>

                                            <span class="flex items-center space-x-1">
                                                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span>{{ $result['date'] }}</span>
                                            </span>

                                            @if ($result['status'])
                                                <span class="flex items-center space-x-1">
                                                    <span
                                                        class="w-2 h-2 rounded-full flex-shrink-0 {{ $result['status'] === 'active' || $result['status'] === 'approved' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                                    <span class="capitalize">{{ $result['status'] }}</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Arrow Icon (Hidden on mobile) -->
                                    <div class="hidden sm:flex flex-shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @else
                        <div class="px-4 sm:px-6 py-8 sm:py-12 text-center">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-gray-300 mb-3 sm:mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <p class="text-gray-500 text-base sm:text-lg font-medium">Aucun résultat trouvé</p>
                            <p class="text-gray-400 text-xs sm:text-sm mt-2">Essayez avec d'autres mots-clés</p>
                        </div>
                    @endif
                </div>

                <!-- Footer (Responsive - Hidden on mobile) -->
                <div class="hidden sm:block border-t border-gray-200 px-4 py-3 bg-gray-50">
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <div class="flex items-center space-x-4">
                            <span class="flex items-center space-x-1">
                                <kbd class="px-2 py-1 bg-white border border-gray-300 rounded shadow-sm">↑</kbd>
                                <kbd class="px-2 py-1 bg-white border border-gray-300 rounded shadow-sm">↓</kbd>
                                <span class="ml-1">Naviguer</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <kbd class="px-2 py-1 bg-white border border-gray-300 rounded shadow-sm">↵</kbd>
                                <span class="ml-1">Sélectionner</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <kbd class="px-2 py-1 bg-white border border-gray-300 rounded shadow-sm">Esc</kbd>
                                <span class="ml-1">Fermer</span>
                            </span>
                        </div>
                        <span class="text-gray-400 hidden lg:inline">
                            Recherche globale AgroSpace
                        </span>
                    </div>
                </div>

                <!-- Mobile Footer -->
                <div class="sm:hidden border-t border-gray-200 px-3 py-2 bg-gray-50">
                    <div class="flex items-center justify-center text-xs text-gray-500">
                        <span>Appuyez sur Échap pour fermer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>