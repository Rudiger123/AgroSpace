@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="{{ __('pagination.navigation_label') }}" class="flex flex-col items-center space-y-6 mt-12">
            
            <!-- Info Pagination (Mobile & Desktop) -->
            <div class="w-full">
                <p class="text-center text-sm text-gray-600 font-medium">
                    {{ __('pagination.showing') }}
                    <span class="font-bold text-green-600">{{ $paginator->firstItem() }}</span>
                    {{ __('pagination.to') }}
                    <span class="font-bold text-green-600">{{ $paginator->lastItem() }}</span>
                    {{ __('pagination.of') }}
                    <span class="font-bold text-green-600">{{ $paginator->total() }}</span>
                    {{ __('pagination.results') }}
                </p>
            </div>

            <!-- Pagination Mobile (sm et moins) -->
            <div class="flex sm:hidden justify-center items-center space-x-3 w-full">
                {{-- Bouton Précédent Mobile --}}
                @if ($paginator->onFirstPage())
                    <span class="px-6 py-3 rounded-xl border-2 border-gray-200 text-gray-400 bg-gray-50 cursor-not-allowed font-semibold flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>{{ __('pagination.previous') }}</span>
                    </span>
                @else
                    <button type="button" 
                            wire:click="previousPage('{{ $paginator->getPageName() }}')" 
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" 
                            wire:loading.attr="disabled"
                            class="px-6 py-3 rounded-xl border-2 border-green-600 text-green-600 hover:bg-green-50 transition-all font-semibold flex items-center space-x-2 transform hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>{{ __('pagination.previous') }}</span>
                    </button>
                @endif

                {{-- Info Page Actuelle Mobile --}}
                <div class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-600 to-green-700 text-white font-bold shadow-lg">
                    {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
                </div>

                {{-- Bouton Suivant Mobile --}}
                @if ($paginator->hasMorePages())
                    <button type="button" 
                            wire:click="nextPage('{{ $paginator->getPageName() }}')" 
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" 
                            wire:loading.attr="disabled"
                            class="px-6 py-3 rounded-xl border-2 border-green-600 text-green-600 hover:bg-green-50 transition-all font-semibold flex items-center space-x-2 transform hover:scale-105 active:scale-95">
                        <span>{{ __('pagination.next') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @else
                    <span class="px-6 py-3 rounded-xl border-2 border-gray-200 text-gray-400 bg-gray-50 cursor-not-allowed font-semibold flex items-center space-x-2">
                        <span>{{ __('pagination.next') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </div>

            <!-- Pagination Desktop (sm et plus) -->
            <div class="hidden sm:flex justify-center items-center space-x-2">
                {{-- Bouton Précédent Desktop --}}
                @if ($paginator->onFirstPage())
                    <span class="px-5 py-3 rounded-xl border-2 border-gray-200 text-gray-400 bg-gray-50 cursor-not-allowed font-semibold flex items-center space-x-2 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>{{ __('pagination.previous') }}</span>
                    </span>
                @else
                    <button type="button" 
                            wire:click="previousPage('{{ $paginator->getPageName() }}')" 
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            class="px-5 py-3 rounded-xl border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all font-semibold flex items-center space-x-2 transform hover:scale-105 active:scale-95 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>{{ __('pagination.previous') }}</span>
                    </button>
                @endif

                {{-- Numéros de Pages --}}
                @foreach ($elements as $element)
                    {{-- Séparateur "..." --}}
                    @if (is_string($element))
                        <span class="px-4 py-3 text-gray-500 font-semibold">{{ $element }}</span>
                    @endif

                    {{-- Liens de Pages --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                @if ($page == $paginator->currentPage())
                                    {{-- Page Actuelle --}}
                                    <span class="relative px-5 py-3 rounded-xl bg-gradient-to-r from-green-600 to-green-700 text-white font-bold shadow-lg transform scale-110 transition-all">
                                        {{ $page }}
                                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-pulse"></span>
                                    </span>
                                @else
                                    {{-- Autres Pages --}}
                                    <button type="button" 
                                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" 
                                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                            wire:loading.attr="disabled"
                                            class="px-5 py-3 rounded-xl border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 font-semibold transition-all transform hover:scale-110 active:scale-95"
                                            aria-label="{{ __('pagination.go_to_page') }} {{ $page }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            </span>
                        @endforeach
                    @endif
                @endforeach

                {{-- Bouton Suivant Desktop --}}
                @if ($paginator->hasMorePages())
                    <button type="button" 
                            wire:click="nextPage('{{ $paginator->getPageName() }}')" 
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            class="px-5 py-3 rounded-xl border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all font-semibold flex items-center space-x-2 transform hover:scale-105 active:scale-95 group">
                        <span>{{ __('pagination.next') }}</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                @else
                    <span class="px-5 py-3 rounded-xl border-2 border-gray-200 text-gray-400 bg-gray-50 cursor-not-allowed font-semibold flex items-center space-x-2 transition-all">
                        <span>{{ __('pagination.next') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </div>

            <!-- Indicateur de Chargement -->
            <div wire:loading class="flex items-center space-x-2 text-green-600">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="font-medium">{{ __('pagination.loading') }}</span>
            </div>

            <!-- Navigation Rapide (Optionnel - pour grandes listes) -->
            @if ($paginator->lastPage() > 10)
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600 font-medium">{{ __('pagination.go_to_page') }} :</span>
                    <input type="number" 
                           min="1" 
                           max="{{ $paginator->lastPage() }}" 
                           value="{{ $paginator->currentPage() }}"
                           wire:change="gotoPage($event.target.value, '{{ $paginator->getPageName() }}')"
                           class="w-20 px-3 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-center font-semibold"
                           placeholder="{{ $paginator->currentPage() }}">
                    <span class="text-sm text-gray-500">/ {{ $paginator->lastPage() }}</span>
                </div>
            @endif
        </nav>
    @endif
</div>

<style>
    /* Animation pour le point de la page active */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.7;
            transform: scale(1.2);
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Effet de survol amélioré */
    button:hover {
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
    }

    /* Désactivation du bouton pendant le chargement */
    button[disabled] {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }
</style>