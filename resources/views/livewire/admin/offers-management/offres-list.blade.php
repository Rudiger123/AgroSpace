<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-green-50" x-data="{
        showFilters: false,
        viewMode: 'grid',
        priceRange: [0, 100000]
    }" x-cloak>

        <!-- Hero Section -->
        <div class="gradient-bg text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fadeIn">
                        {{ __('offers.title') }}
                    </h1>
                    <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                        {{ __('offers.subtitle') }}
                    </p>

                    <!-- Barre de recherche principale -->
                    <div class="max-w-3xl mx-auto">
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.500ms="search"
                                placeholder="{{ __('offers.search_placeholder') }}"
                                class="w-full px-6 py-4 pl-14 text-gray-800 rounded-2xl shadow-2xl focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="w-6 h-6 text-gray-400 absolute left-5 top-1/2 transform -translate-y-1/2"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <button
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-primary-500 text-white px-6 py-2 rounded-xl hover:bg-primary-600 transition font-semibold">
                                {{ __('offers.search_button') }}
                            </button>
                        </div>
                    </div>

                    <!-- Quick filters -->
                    <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                        <span class="text-primary-200 text-sm">{{ __('offers.popular_categories') }}</span>
                        @foreach ($categories as $category)
                            <button wire:click="$set('filterCategorie', '{{ $category->id }}')"
                                class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-full text-sm font-medium transition backdrop-blur-sm">
                                {{ $category->icon }} {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Offres en vedette -->
        @if ($featuredOffres->count() > 0)
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center space-x-2">
                        <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <span>{{ __('offers.featured_offers') }}</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($featuredOffres as $offre)
                        <div
                            class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition group relative">
                            <!-- Badge Featured -->
                            <div class="absolute top-4 left-4 z-10">
                                <span
                                    class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center space-x-1 shadow-lg">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                    <span>{{ __('offers.featured') }}</span>
                                </span>
                            </div>

                            <!-- Image -->
                            <div
                                class="relative h-56 bg-gradient-to-br from-primary-100 to-primary-200 overflow-hidden">
                                @if ($offre->photo_principale_url)
                                    <img src="{{ $offre->photo_principale_url }}" alt="{{ $offre->titre }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-20 h-20 text-primary-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Contenu -->
                            <div class="p-6">
                                <span
                                    class="inline-block bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-xs font-semibold mb-3">
                                    {{ $offre->category->name }}
                                </span>

                                <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1">{{ $offre->titre }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $offre->description }}</p>

                                <!-- Prix -->
                                <div class="flex items-baseline space-x-2 mb-4">
                                    <span
                                        class="text-3xl font-bold text-primary-600">{{ number_format($offre->prix, 0, ',', ' ') }}</span>
                                    <span class="text-gray-600">FCFA/{{ $offre->unite }}</span>
                                </div>

                                <!-- Producteur -->
                                <div class="flex items-center justify-between pt-4 border-t">
                                    <div class="flex items-center space-x-2">
                                        <img src="{{ $offre->producer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($offre->producer->name) }}"
                                            class="w-8 h-8 rounded-full">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $offre->producer->name }}
                                            </p>
                                            <div class="flex items-center">
                                                @php
                                                    $noteMoyenne = $offre->producer->note_moyenne ?? 0;
                                                    $nombreAvis = $offre->producer->nombre_avis ?? 0;
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $noteMoyenne ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                @endfor
                                                <span class="text-xs text-gray-500 ml-1">({{ $nombreAvis }})</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button wire:click="openDetailsModal({{ $offre->id }})"
                                        class="text-primary-600 hover:text-primary-700 font-semibold text-sm">
                                        {{ __('offers.view') }} →
                                    </button>
                                </div>
                            </div>

                            <!-- Bouton Contact -->
                            <button wire:click="contactproducer({{ $offre->id }})"
                                class="w-full mt-4 bg-primary-500 text-white py-3 rounded-xl hover:bg-primary-600 transition font-semibold shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <span>{{ __('offers.contact') }}</span>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Filtres et Liste principale -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 mt-8">

            <!-- Barre de contrôle -->
            <div class="bg-white rounded-2xl shadow-lg p-4 mb-6 sticky top-4 z-20">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">

                    <!-- Résultats -->
                    <div class="flex items-center space-x-4">
                        <p class="text-gray-600">
                            <span class="font-bold text-gray-800">{{ $offres->total() }}</span> {{ __('offers.found') }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-3">
                        <!-- Tri -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 px-4 py-2 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ __('offers.sort') }}</span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-50">
                                <button wire:click="sortBy('date_publication')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-50 transition text-sm">
                                    📅 {{ __('offers.latest') }}
                                </button>
                                <button wire:click="sortBy('prix')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-50 transition text-sm">
                                    💰 {{ __('offers.price_asc') }}
                                </button>
                                <button wire:click="$set('sortBy', 'prix'); $set('sortDirection', 'desc')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-50 transition text-sm">
                                    💎 {{ __('offers.price_desc') }}
                                </button>
                                <button wire:click="sortBy('views_count')"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-50 transition text-sm">
                                    👁️ {{ __('offers.popular') }}
                                </button>
                            </div>
                        </div>

                        <!-- Filtres -->
                        <button @click="showFilters = !showFilters"
                            class="flex items-center space-x-2 px-4 py-2 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">{{ __('offers.filters') }}</span>
                        </button>

                        <!-- Vue -->
                        <div class="hidden md:flex items-center bg-gray-100 rounded-xl p-1">
                            <button @click="viewMode = 'grid'"
                                :class="viewMode === 'grid' ? 'bg-white shadow' : ''"
                                class="p-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                            </button>
                            <button @click="viewMode = 'list'"
                                :class="viewMode === 'list' ? 'bg-white shadow' : ''"
                                class="p-2 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Panel filtres avancés -->
                <div x-show="showFilters" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-4 pt-4 border-t">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Catégorie -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('offers.category') }}</label>
                            <select wire:model.live="filterCategorie"
                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">{{ __('offers.all_categories') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <!-- Région -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('offers.region') }}</label>
                            <select wire:model.live="filterRegion"
                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">{{ __('offers.all_regions') }}</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region }}">{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Prix min -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('offers.min_price') }}</label>
                            <input type="number" wire:model.live.debounce.500ms="filterPrixMin" placeholder="0"
                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <!-- Prix max -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('offers.max_price') }}</label>
                            <input type="number" wire:model.live.debounce.500ms="filterPrixMax"
                                placeholder="1000000"
                                class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <!-- Bouton réinitialiser -->
                    <div class="mt-4 flex justify-end">
                        <button wire:click="resetFilters"
                            class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition font-medium text-sm">
                            {{ __('offers.reset_filters') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Liste des offres (Grid View) -->
            <div x-show="viewMode === 'grid'"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($offres as $index => $offre)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group animate-fadeIn"
                        style="animation-delay: {{ $index * 50 }}ms">

                        <!-- Image -->
                        <div class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden cursor-pointer"
                            wire:click="openDetailsModal({{ $offre->id }})">
                            @if ($offre->photo_principale_url)
                                <img src="{{ $offre->photo_principale_url }}" alt="{{ $offre->titre }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Overlay hover -->
                            <div
                                class="absolute inset-0 bg-gray-600 bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <svg class="w-12 h-12 text-primary-500 opacity-0 group-hover:opacity-100 transition-all duration-300 transform scale-50 group-hover:scale-100"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </div>

                            <!-- Badge catégorie -->
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-white bg-opacity-95 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm shadow">
                                    {{ $offre->category->name }}
                                </span>
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1 cursor-pointer hover:text-primary-600 transition"
                                wire:click="openDetailsModal({{ $offre->id }})">
                                {{ $offre->titre }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $offre->description }}</p>

                            <!-- Prix et quantité -->
                            <div class="mb-4">
                                <div class="flex items-baseline space-x-2 mb-2">
                                    <span
                                        class="text-2xl font-bold text-primary-600">{{ number_format($offre->prix, 0, ',', ' ') }}</span>
                                    <span class="text-sm text-gray-600">FCFA/{{ $offre->unite }}</span>
                                </div>
                                <p class="text-xs text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    {{ $offre->quantite }} {{ $offre->unite }} {{ __('offers.available') }}
                                </p>
                            </div>

                            <!-- Localisation -->
                            <p class="text-sm text-gray-600 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-primary-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $offre->localisation }}
                            </p>

                            <!-- Producteur -->
                            <div class="flex items-center justify-between pt-4 border-t">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ Storage::url($offre->producer->avatar) ?? 'https://ui-avatars.com/api/?name=' . urlencode($offre->producer->name) }}"
                                        class="w-8 h-8 rounded-full ring-2 ring-primary-100">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">{{ $offre->producer->name }}
                                        </p>
                                        <div class="flex items-center">
                                            @php
                                                $noteMoyenne = $offre->producer->note_moyenne ?? 0;
                                                $nombreAvis = $offre->producer->nombre_avis ?? 0;
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $noteMoyenne ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                            <span class="text-xs text-gray-500 ml-1">({{ $nombreAvis }})</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton Contact -->
                            <button wire:click="contactproducer({{ $offre->id }})"
                                class="w-full mt-4 bg-primary-500 text-white py-3 rounded-xl hover:bg-primary-600 transition font-semibold shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <span>{{ __('offers.contact') }}</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl p-12 text-center">
                            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">{{ __('offers.no_offer_found') }}</h3>
                            <p class="text-gray-500">{{ __('offers.try_changing_filters') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Liste des offres (List View) -->
            <div x-show="viewMode === 'list'" class="space-y-4">
                @foreach ($offres as $offre)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition group">
                        <div class="md:flex">
                            <!-- Image -->
                            <div class="md:w-64 h-48 md:h-auto bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden cursor-pointer relative"
                                wire:click="openDetailsModal({{ $offre->id }})">
                                @if ($offre->photo_principale_url)
                                    <img src="{{ $offre->photo_principale_url }}" alt="{{ $offre->titre }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Badge catégorie -->
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="bg-white bg-opacity-95 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm shadow">
                                        {{ $offre->category->name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Contenu -->
                            <div class="flex-1 p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2 cursor-pointer hover:text-primary-600 transition"
                                            wire:click="openDetailsModal({{ $offre->id }})">
                                            {{ $offre->titre }}
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $offre->description }}
                                        </p>
                                    </div>
                                    <div class="text-right ml-4">
                                        <div class="text-3xl font-bold text-primary-600">
                                            {{ number_format($offre->prix, 0, ',', ' ') }}</div>
                                        <div class="text-sm text-gray-600">FCFA/{{ $offre->unite }}</div>
                                    </div>
                                </div>

                                <!-- Détails -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-primary-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        {{ $offre->quantite }} {{ $offre->unite }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-primary-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                        </svg>
                                        {{ $offre->localisation }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        {{ $offre->views_count }} {{ __('offers.views') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $offre->date_publication->diffForHumans() }}
                                    </div>
                                </div>

                                <!-- Producteur et Actions -->
                                <div class="flex items-center justify-between pt-4 border-t">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $offre->producer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($offre->producer->name) }}"
                                            class="w-10 h-10 rounded-full ring-2 ring-primary-100">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $offre->producer->name }}</p>
                                            <div class="flex items-center">
                                                @php
                                                    $noteMoyenne = $offre->producer->note_moyenne ?? 0;
                                                    $nombreAvis = $offre->producer->nombre_avis ?? 0;
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 {{ $i <= $noteMoyenne ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                @endfor
                                                <span class="text-xs text-gray-500 ml-1">({{ $nombreAvis }})</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2">
                                        <button wire:click="openDetailsModal({{ $offre->id }})"
                                            class="px-4 py-2 border-2 border-primary-500 text-primary-600 rounded-xl hover:bg-primary-50 transition font-medium">
                                            {{ __('offers.details') }}
                                        </button>
                                        <button wire:click="contactproducer({{ $offre->id }})"
                                            class="px-4 py-2 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition font-medium">
                                            {{ __('offers.contact') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $offres->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Détails Offre -->
    @if ($selectedOffre)
        <div x-data="{ currentPhoto: 0 }" x-show="$wire.showDetailsModal"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity flex items-center justify-center z-50 p-4 overflow-y-auto"
            @click.self="$wire.showDetailsModal = false" x-cloak>

            <div x-show="$wire.showDetailsModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-y-auto my-8">

                <!-- Header -->
                <div
                    class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between z-10 rounded-t-2xl">
                    <h3 class="text-2xl font-bold text-gray-800">{{ __('offers.offer_details') }}</h3>
                    <button wire:click="$set('showDetailsModal', false)"
                        class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- Galerie photos -->
                        <div>
                            @if ($selectedOffre->photos->count() > 0)
                                <!-- Photo principale -->
                                <div class="relative h-96 bg-gray-200 rounded-2xl overflow-hidden mb-4">
                                    <template x-for="(photo, index) in {{ $selectedOffre->photos->toJson() }}"
                                        :key="index">
                                        <img x-show="currentPhoto === index"
                                            :src="'{{ asset('storage/') }}/' + photo.path"
                                            class="w-full h-full object-cover">
                                    </template>
                                </div>

                                <!-- Miniatures -->
                                @if ($selectedOffre->photos->count() > 1)
                                    <div class="grid grid-cols-4 gap-3">
                                        @foreach ($selectedOffre->photos as $index => $photo)
                                            <button @click="currentPhoto = {{ $index }}"
                                                :class="currentPhoto === {{ $index }} ? 'ring-4 ring-primary-500' : ''"
                                                class="h-20 rounded-xl overflow-hidden transition">
                                                <img src="{{ asset('storage/' . $photo->path) }}"
                                                    class="w-full h-full object-cover hover:opacity-75 transition">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <div
                                    class="h-96 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
                                    <svg class="w-24 h-24 text-primary-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Informations -->
                        <div class="space-y-6">
                            <!-- Titre et catégorie -->
                            <div>
                                <span
                                    class="inline-block bg-primary-100 text-primary-700 px-4 py-1.5 rounded-full text-sm font-semibold mb-3">
                                    {{ $selectedOffre->category->name }}
                                </span>
                                <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $selectedOffre->titre }}</h2>
                                <div class="flex items-baseline space-x-3">
                                    <span
                                        class="text-4xl font-bold text-primary-600">{{ number_format($selectedOffre->prix, 0, ',', ' ') }}</span>
                                    <span class="text-xl text-gray-600">FCFA / {{ $selectedOffre->unite }}</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h3 class="font-bold text-gray-800 mb-3 flex items-center text-lg">
                                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    {{ __('offers.description') }}
                                </h3>
                                <p class="text-gray-700 leading-relaxed">{{ $selectedOffre->description }}</p>
                            </div>

                            <!-- Détails -->
                            <div class="bg-gray-50 rounded-xl p-5 space-y-3">
                                <h3 class="font-bold text-gray-800 mb-4">{{ __('offers.details') }}</h3>

                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                            </path>
                                        </svg>
                                        {{ __('offers.available_quantity') }}
                                    </span>
                                    <span class="font-bold text-gray-800">{{ $selectedOffre->quantite }}
                                        {{ $selectedOffre->unite }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ __('offers.location') }}
                                    </span>
                                    <span class="font-bold text-gray-800">{{ $selectedOffre->region }},
                                        {{ $selectedOffre->localisation }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        {{ __('offers.contact') }}
                                    </span>
                                    <span class="font-bold text-gray-800">{{ $selectedOffre->contact }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-600 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ __('offers.published_on') }}
                                    </span>
                                    <span
                                        class="font-bold text-gray-800">{{ $selectedOffre->date_publication->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Conditions de livraison -->
                            @if ($selectedOffre->conditions_livraison)
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-xl">
                                    <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                                            </path>
                                        </svg>
                                        {{ __('offers.delivery_conditions') }}
                                    </h3>
                                    <p class="text-gray-700 text-sm">{{ $selectedOffre->conditions_livraison }}</p>
                                </div>
                            @endif

                            <!-- Producteur -->
                            <div class="bg-gradient-to-br from-primary-50 to-green-50 rounded-xl p-5">
                                <h3 class="font-bold text-gray-800 mb-4">{{ __('offers.about_producer') }}</h3>
                                <div class="flex items-center space-x-4 mb-4">
                                    <img src="{{ $selectedOffre->producer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($selectedOffre->producer->name) }}"
                                        class="w-16 h-16 rounded-full ring-4 ring-white shadow">
                                    <div class="flex-1">
                                        <p class="font-bold text-lg text-gray-800">
                                            {{ $selectedOffre->producer->name }}</p>
                                        <div class="flex items-center mb-1">
                                            @php
                                                $noteMoyenne = $selectedOffre->producer->note_moyenne ?? 0;
                                                $nombreAvis = $selectedOffre->producer->nombre_avis ?? 0;
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $noteMoyenne ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            @endfor
                                            <span
                                                class="text-sm text-gray-600 ml-2">{{ number_format($noteMoyenne, 1) }}
                                                ({{ $nombreAvis }} {{ __('offers.reviews') }})</span>
                                        </div>
                                        @if ($selectedOffre->producer->bio)
                                            <p class="text-sm text-gray-600">{{ $selectedOffre->producer->bio }}</p>
                                        @endif
                                    </div>
                                </div>

                                <button
                                    wire:click="openAvisModal({{ $selectedOffre->producer_id }}, {{ $selectedOffre->id }})"
                                    class="w-full bg-white text-primary-600 py-2 rounded-xl hover:bg-primary-50 transition font-medium text-sm border-2 border-primary-200">
                                    ⭐ {{ __('offers.leave_review') }} 
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Avis clients -->
                    @if ($selectedOffre->producer->avisRecus->count() > 0)
                        <div class="mt-8 pt-8 border-t">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <svg class="w-7 h-7 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                                {{ __('offers.customer_reviews') }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($selectedOffre->producer->avisRecus->take(4) as $avis)
                                    <div class="bg-gray-50 rounded-xl p-5 hover:shadow-md transition">
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ $avis->consumer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($avis->consumer->name) }}"
                                                    class="w-10 h-10 rounded-full">
                                                <div>
                                                    <p class="font-semibold text-gray-800">{{ $avis->consumer->name }}
                                                    </p>
                                                    <div class="flex items-center">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $avis->note ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path
                                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                                </path>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-500">{{ $avis->date_creation->diffForHumans() }}</span>
                                        </div>
                                        @if ($avis->commentaire)
                                            <p class="text-gray-600 text-sm leading-relaxed">{{ $avis->commentaire }}
                                            </p>
                                        @endif
                                        @if ($avis->is_verified)
                                            <div class="mt-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ __('offers.verified_purchase') }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer -->
                <div
                    class="sticky bottom-0 bg-white border-t px-6 py-4 flex items-center justify-between rounded-b-2xl">
                    <button wire:click="$set('showDetailsModal', false)"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                        {{ __('offers.close') }}
                    </button>
                    <button wire:click="contactproducer({{ $selectedOffre->id }})"
                        class="px-8 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition font-semibold shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span>{{ __('offers.contact_producer') }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Notation/Avis -->
    <div x-show="$wire.showAvisModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="$wire.showAvisModal = false" x-cloak>

        <div x-show="$wire.showAvisModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6" x-data="{ hoverNote: 0 }" x-cloak>

            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-8 w-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('offers.leave_review') }}</h3>
                <p class="text-gray-600">{{ __('offers.share_experience') }}</p>
            </div>

            <form wire:submit.prevent="submitAvis" class="space-y-6">
                <!-- Notation par étoiles -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3 text-center">
                        {{ __('offers.your_rating') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center justify-center space-x-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" @mouseenter="hoverNote = {{ $i }}"
                                @mouseleave="hoverNote = 0" wire:click="$set('avisNote', {{ $i }})"
                                class="transition-transform hover:scale-125">
                                <svg class="w-12 h-12 cursor-pointer transition-colors"
                                    :class="(hoverNote >= {{ $i }} || $wire.avisNote >= {{ $i }}) ?
                                    'text-yellow-400' : 'text-gray-300'"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <p class="text-center mt-2 text-sm font-medium"
                        x-text="$wire.avisNote === 5 ? '😍 {{ __("offers.excellent") }}' : 
                        $wire.avisNote === 4 ? '😊 {{ __("offers.very_good") }}' : 
                        $wire.avisNote === 3 ? '😐 {{ __("offers.good") }}' : 
                        $wire.avisNote === 2 ? '😕 {{ __("offers.average") }}' : 
                        $wire.avisNote === 1 ? '😞 {{ __("offers.disappointing") }}' : ''">
                    </p>
                    @error('avisNote')
                        <p class="text-center text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Commentaire -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('offers.your_comment') }} ({{ __('offers.optional') }})
                    </label>
                    <textarea wire:model="avisCommentaire" rows="4" placeholder="{{ __('offers.share_experience') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition resize-none"></textarea>
                    @error('avisCommentaire')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">{{ __('offers.max_500_characters') }}</p>
                </div>

                <!-- Note d'information -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-xl">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mr-3 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-sm text-blue-700">
                            {{ __('offers.review_info') }}
                        </p>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex items-center justify-end space-x-3 pt-4">
                    <button type="button" wire:click="$set('showAvisModal', false)"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                        {{ __('offers.cancel') }}
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-6 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition font-semibold shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span wire:loading.remove>{{ __('offers.publish_review') }}</span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{ __('offers.publishing') }}...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('notify', (event) => {
                    const data = event;
                    Swal.fire({
                        icon: data.type,
                        title: data.type === 'success' ? '{{ __("offers.success") }}' : data.type === 'info' ?
                            '{{ __("offers.info") }}' : '{{ __("offers.error") }}',
                        text: data.message,
                        timer: data.type === 'success' ? 3000 : null,
                        showConfirmButton: data.type !== 'success',
                        confirmButtonColor: '#22c55e'
                    });
                });
            });
        </script>
    @endpush

</div>