<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-6 sm:py-8 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6 sm:mb-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                    {{ __('offers.moderation_title') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('offers.moderation_subtitle') }}</p>
            </div>
            <button wire:click="bulkValidate"
                class="inline-flex justify-center items-center px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white text-sm font-medium rounded-lg hover:from-green-700 hover:to-green-800 focus:ring-4 focus:ring-green-200 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('offers.bulk_validate') }}
            </button>
        </div>

        {{-- Statistiques Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3 sm:gap-4 mb-6 sm:mb-8">
            <div
                class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-2">{{ __('offers.total') }}
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</div>
                <div class="text-xs text-blue-600 mt-1 font-medium flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ __('offers.offers') }}
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 sm:p-5 rounded-xl shadow-sm border border-orange-200 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-orange-600 text-xs font-bold uppercase tracking-wider mb-2">{{ __('offers.pending') }}
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-orange-700">{{ $stats['pending'] }}</div>
                <div class="text-xs text-orange-600 mt-1 font-medium">{{ __('offers.to_moderate') }}</div>
            </div>

            <div
                class="bg-gradient-to-br from-green-50 to-green-100 p-4 sm:p-5 rounded-xl shadow-sm border border-green-200 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-green-600 text-xs font-bold uppercase tracking-wider mb-2">{{ __('offers.validated') }}
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-green-700">{{ $stats['validated'] }}</div>
                <div class="text-xs text-green-600 mt-1 font-medium">{{ __('offers.active') }}</div>
            </div>

            <div
                class="bg-gradient-to-br from-red-50 to-red-100 p-4 sm:p-5 rounded-xl shadow-sm border border-red-200 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-red-600 text-xs font-bold uppercase tracking-wider mb-2">{{ __('offers.rejected') }}
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-red-700">{{ $stats['rejected'] }}</div>
                <div class="text-xs text-red-600 mt-1 font-medium">{{ __('offers.refused') }}</div>
            </div>

            <div
                class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 sm:p-5 rounded-xl shadow-sm border border-purple-200 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-purple-600 text-xs font-bold uppercase tracking-wider mb-2">
                    {{ __('offers.suspended') }}</div>
                <div class="text-2xl sm:text-3xl font-extrabold text-purple-700">{{ $stats['suspended'] }}</div>
                <div class="text-xs text-purple-600 mt-1 font-medium">{{ __('offers.blocked') }}</div>
            </div>

            <div
                class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 sm:p-5 rounded-xl shadow-sm border border-yellow-200 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-yellow-600 text-xs font-bold uppercase tracking-wider mb-2">
                    {{ __('offers.featured') }}</div>
                <div class="text-2xl sm:text-3xl font-extrabold text-yellow-700">{{ $stats['featured'] }}</div>
                <div class="text-xs text-yellow-600 mt-1 font-medium">{{ __('offers.featured_label') }}</div>
            </div>

            <div
                class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 sm:p-5 rounded-xl shadow-sm border border-blue-200 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="text-blue-600 text-xs font-bold uppercase tracking-wider mb-2">{{ __('offers.today') }}
                </div>
                <div class="text-2xl sm:text-3xl font-extrabold text-blue-700">{{ $stats['today'] }}</div>
                <div class="text-xs text-blue-600 mt-1 font-medium">+{{ $stats['thisWeek'] }}
                    {{ __('offers.this_week') }}</div>
            </div>
        </div>

        {{-- Graphiques --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">

            {{-- Graphique Statuts (Donut) --}}
            <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow"
                wire:ignore>
                <h3 class="text-gray-800 font-bold text-sm sm:text-base mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    {{ __('offers.status_distribution') }}
                </h3>
                <div id="statusChart"></div>
            </div>

            {{-- Top Catégories (Barres horizontales) --}}
            <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow"
                wire:ignore>
                <h3 class="text-gray-800 font-bold text-sm sm:text-base mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                    {{ __('offers.top_categories') }}
                </h3>
                <div id="catChart"></div>
            </div>

            {{-- Évolution 7 derniers jours (Line) --}}
            <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow"
                wire:ignore>
                <h3 class="text-gray-800 font-bold text-sm sm:text-base mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                    {{ __('offers.last_7_days_evolution') }}
                </h3>
                <div id="evolutionChart"></div>
            </div>

            {{-- Top Régions (Radar) --}}
            <div class="bg-white p-5 sm:p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-shadow"
                wire:ignore>
                <h3 class="text-gray-800 font-bold text-sm sm:text-base mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ __('offers.top_regions') }}
                </h3>
                <div id="regionChart"></div>
            </div>
        </div>

        {{-- Filtres --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-5 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                <div class="lg:col-span-2 relative">
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('offers.search_placeholder') }}"
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <select wire:model.live="statusFilter"
                    class="border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2.5 transition">
                    <option value="all">📋 {{ __('offers.all_statuses') }}</option>
                    <option value="pending">⏳ {{ __('offers.pending') }}</option>
                    <option value="validé">✅ {{ __('offers.validated') }}</option>
                    <option value="rejeté">❌ {{ __('offers.rejected') }}</option>
                    <option value="suspendue">🚫 {{ __('offers.suspended') }}</option>
                </select>
                <select wire:model.live="categorieFilter"
                    class="border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2.5 transition">
                    <option value="">🏷️ {{ __('offers.all_categories') }}</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select wire:model.live="sortBy"
                    class="border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-2.5 transition">
                    <option value="latest">📅 {{ __('offers.most_recent') }}</option>
                    <option value="oldest">🕐 {{ __('offers.oldest') }}</option>
                    <option value="price_high">💰 {{ __('offers.price_desc') }}</option>
                    <option value="price_low">💵 {{ __('offers.price_asc') }}</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                {{ __('offers.offer') }}</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                {{ __('offers.producer') }}</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                {{ __('offers.price_location') }}</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                {{ __('offers.status') }}</th>
                            <th
                                class="px-4 sm:px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">
                                {{ __('offers.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($offers as $offer)
                            <tr class="hover:bg-blue-50 transition-colors">
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="flex items-center space-x-3 sm:space-x-4">
                                        <div
                                            class="h-12 w-12 sm:h-14 sm:w-14 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm">
                                            @if ($offer->photos->first())
                                                <img class="h-full w-full object-cover"
                                                    src="{{ $offer->photos->first()->url }}" alt="">
                                            @else
                                                <div
                                                    class="h-full w-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div
                                                class="text-sm font-semibold text-gray-900 truncate max-w-[150px] sm:max-w-[200px]">
                                                {{ $offer->titre }}</div>
                                            <div class="text-xs text-gray-500">{{ $offer->category->name ?? 'N/A' }}
                                            </div>
                                            @if ($offer->is_featured)
                                                <span
                                                    class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 mt-1">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                    {{ __('offers.featured') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center font-bold text-sm mr-3">
                                            {{ substr($offer->producer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $offer->producer->name }}</div>
                                            <div class="text-xs text-gray-500 hidden sm:block">
                                                {{ $offer->producer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">
                                        {{ number_format($offer->prix, 0, ',', ' ') }} <span
                                            class="text-xs text-gray-500">FCFA</span></div>
                                    <div class="text-xs text-gray-500">📍 {{ $offer->ville }}, {{ $offer->region }}
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    @php
                                        $classes = match ($offer->statut) {
                                            'validé' => 'bg-green-100 text-green-800 border-green-200',
                                            'rejeté' => 'bg-red-100 text-red-800 border-red-200',
                                            'en attente' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'suspendue' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                                        };
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $classes }}">
                                        {{ ucfirst($offer->statut) }}
                                    </span>
                                </td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="viewDetails({{ $offer->id }})"
                                            class="text-gray-400 hover:text-blue-600 transition p-1.5 hover:bg-blue-50 rounded-lg"
                                            title="{{ __('offers.details') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        @if ($offer->statut === 'en attente')
                                            <button wire:click="openValidateModal({{ $offer->id }})"
                                                class="text-gray-400 hover:text-green-600 transition p-1.5 hover:bg-green-50 rounded-lg"
                                                title="{{ __('offers.validate') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                            <button wire:click="openRejectModal({{ $offer->id }})"
                                                class="text-gray-400 hover:text-red-600 transition p-1.5 hover:bg-red-50 rounded-lg"
                                                title="{{ __('offers.reject') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif

                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open"
                                                class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-lg transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-transition
                                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl z-50 border border-gray-200 py-1 divide-y divide-gray-100"
                                                style="display: none;">
                                                <div class="py-1">
                                                    <button wire:click="toggleFeatured({{ $offer->id }})"
                                                        class="flex items-center w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-700 transition">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z">
                                                            </path>
                                                        </svg>
                                                        {{ $offer->is_featured ? __('offers.remove_featured') : __('offers.set_featured') }}
                                                    </button>
                                                </div>
                                                <div class="py-1">
                                                    <button
                                                        wire:click="updateStatus({{ $offer->id }}, 'suspendue')"
                                                        class="flex items-center w-full text-left px-4 py-2.5 text-sm text-purple-600 hover:bg-purple-50 transition">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.suspend_offer') }}
                                                    </button>
                                                    <button wire:click="suspendProducer({{ $offer->producer_id }})"
                                                        class="flex items-center w-full text-left px-4 py-2.5 text-sm text-orange-600 hover:bg-orange-50 transition">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.suspend_producer') }}
                                                    </button>
                                                </div>
                                                <div class="py-1">
                                                    <button wire:click="confirmDelete({{ $offer->id }})"
                                                        class="flex items-center w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                                        <svg class="w-4 h-4 mr-2" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.delete_permanently') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">{{ __('offers.no_offers_match') }}</p>
                                        <p class="text-gray-400 text-sm mt-1">{{ __('offers.adjust_filters') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $offers->links() }}
            </div>
        </div>
    </div>

    {{-- Modal de Validation --}}
    <div x-show="$wire.showValidateModal"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6 overflow-y-auto"
        style="display: none;">
        <div class="absolute inset-0 bg-gray-900 opacity-75 transition-opacity" wire:click="resetModals"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 p-6 sm:p-8 transform transition-all"
            @click.away="$wire.resetModals()">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ __('offers.validate_offer') }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ __('offers.validate_notification') }}</p>
            </div>
            <div class="space-y-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __('offers.validation_note') }}</label>
                    <textarea wire:model="validationNote" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm transition"
                        placeholder="{{ __('offers.validation_note_placeholder') }}"></textarea>
                    <p class="text-xs text-gray-500 mt-1">{{ __('offers.validation_note_help') }}</p>
                </div>
            </div>
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <button wire:click="resetModals"
                    class="flex-1 px-5 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all">
                    {{ __('offers.cancel') }}
                </button>
                <button wire:click="validateOffer"
                    class="flex-1 px-5 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    ✅ {{ __('offers.validate_offer_button') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Modal de Rejet --}}
    <div x-show="$wire.showRejectModal"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6 overflow-y-auto"
        style="display: none;">
        <div class="absolute inset-0 bg-gray-900 opacity-75 transition-opacity" wire:click="resetModals"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 p-6 sm:p-8 transform transition-all"
            @click.away="$wire.resetModals()">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ __('offers.reject_offer') }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ __('offers.reject_notification') }}</p>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('offers.reject_reason') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="rejectionReason" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition"
                        placeholder="{{ __('offers.reject_reason_placeholder') }}"></textarea>
                    @error('rejectionReason')
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">{{ __('offers.reject_reason_help') }}</p>
                </div>
            </div>
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <button wire:click="resetModals"
                    class="flex-1 px-5 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all">
                    {{ __('offers.cancel') }}
                </button>
                <button wire:click="rejectOffer"
                    class="flex-1 px-5 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    ❌ {{ __('offers.reject_offer_button') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Modal de Suppression --}}
    <div x-show="$wire.showDeleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6 overflow-y-auto"
        style="display: none;">
        <div class="absolute inset-0 bg-gray-900 opacity-75 transition-opacity" wire:click="resetModals"></div>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg relative z-10 p-6 sm:p-8 transform transition-all"
            @click.away="$wire.resetModals()">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ __('offers.delete_permanently') }}</h3>
                <p class="text-sm text-red-600 mt-2 font-medium">⚠️ {{ __('offers.irreversible_action') }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ __('offers.delete_notification') }}</p>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        {{ __('offers.deletion_reason') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="deletionReason" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition"
                        placeholder="{{ __('offers.deletion_reason_placeholder') }}"></textarea>
                    @error('deletionReason')
                        <span class="text-red-500 text-xs mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">{{ __('offers.deletion_reason_help') }}</p>
                </div>
            </div>
            <div class="mt-8 flex flex-col sm:flex-row gap-3">
                <button wire:click="resetModals"
                    class="flex-1 px-5 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-semibold transition-all">
                    {{ __('offers.cancel') }}
                </button>
                <button wire:click="deleteOffer"
                    class="flex-1 px-5 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 font-semibold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    🗑️ {{ __('offers.delete_button') }}
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Détails Offre --}}
    @if ($showDetailsModal && $selectedOffer)
        <div class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6 py-6 overflow-y-auto"
            x-transition>
            <div class="absolute inset-0 bg-gray-900/80 backdrop-blur-sm" wire:click="resetModals"></div>

            <div
                class="bg-white w-full max-w-5xl max-h-[90vh] rounded-2xl shadow-2xl relative z-10 flex flex-col overflow-hidden">

                <div
                    class="px-4 sm:px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-gray-50 to-gray-100">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ __('offers.offer_details') }}</h3>
                        <p class="text-xs sm:text-sm text-gray-500">{{ __('offers.ref') }}
                            #{{ $selectedOffer->id }} • {{ __('offers.published_on') }}
                            {{ $selectedOffer->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <button wire:click="resetModals"
                        class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

                        <div class="space-y-4 sm:space-y-6">
                            <div
                                class="rounded-xl overflow-hidden border-2 border-gray-200 shadow-lg bg-gray-100 relative aspect-[4/3]">
                                @if ($selectedOffer->photos->count() > 0)
                                    <img src="{{ $selectedOffer->photos->first()->url }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                    @if ($selectedOffer->photos->count() > 1)
                                        <span
                                            class="absolute bottom-2 right-2 bg-black/70 text-white text-xs px-3 py-1.5 rounded-lg backdrop-blur-sm font-medium">
                                            +{{ $selectedOffer->photos->count() - 1 }} {{ __('offers.photos') }}
                                        </span>
                                    @endif
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div
                                class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-md">
                                        {{ substr($selectedOffer->producer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm">
                                            {{ $selectedOffer->producer->name }}</h4>
                                        <p class="text-xs text-gray-600">{{ $selectedOffer->producer->email }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs border-t border-blue-200 pt-3">
                                    <div class="text-center p-2 bg-white/60 rounded-lg">
                                        <span
                                            class="block font-bold text-gray-800 text-lg">{{ $selectedOffer->producer->offers->count() }}</span>
                                        <span class="text-gray-600">{{ __('offers.offers') }}</span>
                                    </div>
                                    <div class="text-center p-2 bg-white/60 rounded-lg">
                                        <span
                                            class="block font-bold text-gray-800 text-lg">{{ $selectedOffer->producer->created_at->format('Y') }}</span>
                                        <span class="text-gray-600">{{ __('offers.member') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                                <div>
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-2">
                                        {{ $selectedOffer->category->name ?? 'N/A' }}
                                    </span>
                                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
                                        {{ $selectedOffer->titre }}</h2>
                                </div>
                                <div class="text-left sm:text-right">
                                    <div class="text-2xl sm:text-3xl font-bold text-blue-600">
                                        {{ number_format($selectedOffer->prix, 0, ',', ' ') }}
                                        <span class="text-sm text-gray-500 font-normal">FCFA</span>
                                    </div>
                                    <div class="text-sm text-gray-600">{{ __('offers.for') }}
                                        {{ $selectedOffer->quantite }}
                                        {{ $selectedOffer->unite }}</div>
                                </div>
                            </div>

                            <div
                                class="prose prose-sm max-w-none text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <h5 class="text-gray-900 font-semibold mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                    {{ __('offers.description') }}
                                </h5>
                                <p class="text-sm leading-relaxed">{{ $selectedOffer->description }}</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <div class="p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 transition">
                                    <span class="text-xs text-gray-500 block font-medium mb-1">📍
                                        {{ __('offers.location') }}</span>
                                    <span
                                        class="font-semibold text-gray-900 text-sm">{{ $selectedOffer->ville }}</span>
                                </div>
                                <div class="p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 transition">
                                    <span class="text-xs text-gray-500 block font-medium mb-1">🗺️
                                        {{ __('offers.region') }}</span>
                                    <span
                                        class="font-semibold text-gray-900 text-sm">{{ $selectedOffer->region }}</span>
                                </div>
                                <div class="p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 transition">
                                    <span class="text-xs text-gray-500 block font-medium mb-1">📊
                                        {{ __('offers.status') }}</span>
                                    @php
                                        $statusColor = match ($selectedOffer->statut) {
                                            'validé' => 'text-green-600',
                                            'rejeté' => 'text-red-600',
                                            'en attente' => 'text-orange-600',
                                            'suspendue' => 'text-purple-600',
                                            default => 'text-gray-600',
                                        };
                                    @endphp
                                    <span
                                        class="font-semibold text-sm capitalize {{ $statusColor }}">{{ $selectedOffer->statut }}</span>
                                </div>
                            </div>

                            @if ($selectedOffer->conditions_livraison)
                                <div
                                    class="flex items-start gap-3 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-800 rounded-lg text-sm">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <span class="font-semibold block mb-1">{{ __('offers.delivery_conditions') }}
                                            :</span>
                                        <p class="leading-relaxed">{{ $selectedOffer->conditions_livraison }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div
                    class="px-4 sm:px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200 flex flex-wrap justify-end gap-3">
                    <button wire:click="resetModals"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium shadow-sm transition-all">
                        {{ __('offers.close') }}
                    </button>

                    @if ($selectedOffer->statut === 'en attente')
                        <button wire:click="openRejectModal({{ $selectedOffer->id }})"
                            class="px-4 py-2 bg-red-100 text-red-700 border border-red-200 rounded-lg hover:bg-red-200 font-medium transition-all">
                            ❌ {{ __('offers.reject') }}
                        </button>
                        <button wire:click="openValidateModal({{ $selectedOffer->id }})"
                            class="px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 font-medium shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                            ✅ {{ __('offers.validate_offer') }}
                        </button>
                    @endif

                    @if ($selectedOffer->statut === 'validé')
                        <button wire:click="updateStatus({{ $selectedOffer->id }}, 'suspendue')"
                            class="px-4 py-2 bg-purple-100 text-purple-700 border border-purple-200 rounded-lg hover:bg-purple-200 font-medium transition-all">
                            🚫 {{ __('offers.suspend') }}
                    @endif



    @endif
</div>
{{-- SCRIPT D'INITIALISATION DES GRAPHIQUES --}}
@push('scripts')
    <script>
     // Réinitialiser les graphiques après chaque mise à jour Livewire
            document.addEventListener('livewire:navigated', function() {
                initCharts();
            });

        function initCharts() {
            // Données depuis le backend
            const chartStatusData = @json($chartStatusData);
            const chartCategoryData = @json($chartCategoryData);
            const evolutionData = @json($evolutionData);
            const chartRegionData = @json($chartRegionData);

            console.log('Initialisation des graphiques...', {
                chartStatusData,
                chartCategoryData,
                evolutionData,
                chartRegionData
            });

            // ===== GRAPHIQUE 1 : STATUTS (DONUT) =====
            const statusChartEl = document.querySelector('#statusChart');
            if (statusChartEl) {
                // Détruire l'ancien graphique s'il existe
                if (window.statusChartInstance) {
                    window.statusChartInstance.destroy();
                }

                const statusOptions = {
                    series: chartStatusData.series || [],
                    labels: chartStatusData.labels || [],
                    chart: {
                        type: 'donut',
                        height: 280,
                        fontFamily: 'inherit',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    colors: ['#F59E0B', '#10B981', '#EF4444', '#8B5CF6', '#3B82F6'],
                    legend: {
                        position: 'bottom',
                        fontSize: '12px',
                        horizontalAlign: 'center'
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '12px',
                            fontWeight: 600
                        },
                        dropShadow: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: '{{ __('offers.total') }}',
                                        fontSize: '16px',
                                        fontWeight: 700,
                                        color: '#374151'
                                    }
                                }
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            chart: {
                                height: 240
                            },
                            legend: {
                                fontSize: '10px'
                            }
                        }
                    }]
                };

                window.statusChartInstance = new ApexCharts(statusChartEl, statusOptions);
                window.statusChartInstance.render();
                console.log('✅ Graphique Statuts rendu');
            }

            // ===== GRAPHIQUE 2 : CATÉGORIES (BARRES) =====
            const catChartEl = document.querySelector('#catChart');
            if (catChartEl) {
                if (window.catChartInstance) {
                    window.catChartInstance.destroy();
                }

                const catOptions = {
                    series: [{
                        name: '{{ __('offers.offers') }}',
                        data: chartCategoryData.series || []
                    }],
                    xaxis: {
                        categories: chartCategoryData.labels || [],
                        labels: {
                            style: {
                                fontSize: '11px',
                                fontWeight: 500
                            }
                        }
                    },
                    chart: {
                        type: 'bar',
                        height: 280,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    colors: ['#3B82F6'],
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            horizontal: true,
                            distributed: false,
                            dataLabels: {
                                position: 'center'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '11px',
                            colors: ['#fff'],
                            fontWeight: 600
                        }
                    },
                    grid: {
                        borderColor: '#f3f4f6',
                        padding: {
                            left: 10,
                            right: 10
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + ' {{ __('offers.offers') }}';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            chart: {
                                height: 240
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '10px'
                                    }
                                }
                            }
                        }
                    }]
                };

                window.catChartInstance = new ApexCharts(catChartEl, catOptions);
                window.catChartInstance.render();
                console.log('✅ Graphique Catégories rendu');
            }

            // ===== GRAPHIQUE 3 : ÉVOLUTION (AREA) =====
            const evolutionChartEl = document.querySelector('#evolutionChart');
            if (evolutionChartEl) {
                if (window.evolutionChartInstance) {
                    window.evolutionChartInstance.destroy();
                }

                const evolutionOptions = {
                    series: [{
                        name: '{{ __('offers.published_offers') }}',
                        data: evolutionData.counts || []
                    }],
                    xaxis: {
                        categories: evolutionData.dates || [],
                        labels: {
                            style: {
                                fontSize: '11px',
                                fontWeight: 500
                            }
                        }
                    },
                    chart: {
                        type: 'area',
                        height: 280,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit',
                        sparkline: {
                            enabled: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    colors: ['#10B981'],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.2,
                            stops: [0, 90, 100]
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    grid: {
                        borderColor: '#f3f4f6',
                        padding: {
                            left: 10,
                            right: 10
                        }
                    },
                    markers: {
                        size: 4,
                        colors: ['#10B981'],
                        strokeColors: '#fff',
                        strokeWidth: 2,
                        hover: {
                            size: 6
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + ' {{ __('offers.offers') }}';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            chart: {
                                height: 240
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '9px'
                                    }
                                }
                            }
                        }
                    }]
                };

                window.evolutionChartInstance = new ApexCharts(evolutionChartEl, evolutionOptions);
                window.evolutionChartInstance.render();
                console.log('✅ Graphique Évolution rendu');
            }

            // ===== GRAPHIQUE 4 : RÉGIONS (RADAR) =====
            const regionChartEl = document.querySelector('#regionChart');
            if (regionChartEl) {
                if (window.regionChartInstance) {
                    window.regionChartInstance.destroy();
                }

                const regionOptions = {
                    series: [{
                        name: '{{ __('offers.offers') }}',
                        data: chartRegionData.series || []
                    }],
                    xaxis: {
                        categories: chartRegionData.labels || [],
                        labels: {
                            style: {
                                fontSize: '10px',
                                fontWeight: 500
                            }
                        }
                    },
                    chart: {
                        type: 'radar',
                        height: 280,
                        toolbar: {
                            show: false
                        },
                        fontFamily: 'inherit',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    colors: ['#F59E0B'],
                    stroke: {
                        width: 2,
                        colors: ['#F59E0B']
                    },
                    fill: {
                        opacity: 0.2,
                        colors: ['#F59E0B']
                    },
                    markers: {
                        size: 4,
                        colors: ['#F59E0B'],
                        strokeColors: '#fff',
                        strokeWidth: 2
                    },
                    yaxis: {
                        show: false
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + ' {{ __('offers.offers') }}';
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 640,
                        options: {
                            chart: {
                                height: 240
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '8px'
                                    }
                                }
                            }
                        }
                    }]
                };

                window.regionChartInstance = new ApexCharts(regionChartEl, regionOptions);
                window.regionChartInstance.render();
                console.log('✅ Graphique Régions rendu');
            }

            console.log('🎉 Tous les graphiques ont été initialisés avec succès !');
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('toast', (event) => {
                const data = event[0] || event;
                Swal.fire({
                    icon: data.type,
                    title: data.type === 'success' ? '✅ ' + '{{ __('offers.success') }}' : data
                        .type === 'warning' ?
                        '⚠️ ' + '{{ __('offers.warning') }}' : '❌ ' +
                        '{{ __('offers.error') }}',
                    text: data.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast',
                        title: 'text-sm font-semibold',
                        htmlContainer: 'text-xs'
                    },
                    background: data.type === 'success' ? '#f0fdf4' : data.type === 'warning' ?
                        '#fffbeb' : '#fef2f2',
                    color: data.type === 'success' ? '#166534' : data.type === 'warning' ?
                        '#92400e' : '#991b1b',
                });
            });
        });
    </script>
@endpush
