<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-green-50 p-6" x-data="{
        viewMode: 'grid'
    }" x-cloak>

        <!-- Header -->
        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center space-x-3">
                        <span class="bg-primary-500 text-white p-2 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </span>
                        <span>{{ __('offers.my_offers') }}</span>
                    </h1>
                    <p class="text-gray-500 mt-1">{{ __('offers.manage_subtitle') }}</p>
                </div>
                <button wire:click="openCreateModal"
                    class="bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>{{ __('offers.new_offer') }}</span>
                </button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-primary-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-gray-800">{{ $stats['total'] }}</span>
                    </div>
                    <p class="text-gray-600 font-medium">{{ __('offers.total_offers') }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-green-600">{{ $stats['active'] }}</span>
                    </div>
                    <p class="text-gray-600 font-medium">{{ __('offers.active_offers') }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-blue-600">{{ $stats['vendue'] }}</span>
                    </div>
                    <p class="text-gray-600 font-medium">{{ __('offers.sold_offers') }}</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-red-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-red-600">{{ $stats['expiree'] }}</span>
                    </div>
                    <p class="text-gray-600 font-medium">{{ __('offers.expired_offers') }}</p>
                </div>
            </div>

            <!-- Barre de recherche et filtres - Version simplifiée -->
            <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect" x-data="{
                showFilters: false,
            }">
                <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 space-y-4 md:space-y-0 md:space-x-4">

                    <!-- Recherche -->
                    <div class="flex-1 relative">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="{{ __('offers.search_placeholder') }}"
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center space-x-3">
                        <button @click="showFilters = !showFilters"
                            class="px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            <span>{{ __('offers.filters') }}</span>
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

                <!-- Panel filtres -->
                <div x-show="showFilters" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="mt-4 pt-4 border-t grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('offers.category') }}</label>
                        <select wire:model.live="filterCategorie"
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                            <option value="">{{ __('offers.all_categories') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('offers.status') }}</label>
                        <select wire:model.live="filterStatut"
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                            <option value="all">{{ __('offers.all_statuses') }}</option>
                            <option value="pending">{{ __('offers.pending') }}</option>
                            <option value="validé">{{ __('offers.validated') }}</option>
                            <option value="rejeté">{{ __('offers.rejected') }}</option>
                            <option value="suspendue">{{ __('offers.suspended') }}</option>
                            <option value="expirée">{{ __('offers.expired') }}</option>
                            <option value="vendue">{{ __('offers.sold') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('offers.region') }}</label>
                        <select wire:model.live="filterRegion"
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                            <option value="">{{ __('offers.all_regions') }}</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="button" wire:click="resetFilters"
                            class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition font-medium">
                            {{ __('offers.reset') }}
                        </button>
                    </div>
                </div>
            </div>
            <!-- Liste des offres (Grid) -->
            <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($offers as $offre)
                    <div class="bg-white rounded-2xl shadow-lg overflow-visible hover:shadow-xl transition group">
                        <!-- Image -->
                        <div class="relative h-48 bg-gray-200 overflow-hidden rounded-t-2xl">
                            @if ($offre->photo_principale_url)
                                <img src="{{ $offre->photo_principale_url }}" alt="{{ $offre->titre }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                    <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Badge statut -->
                            <div class="absolute top-3 right-3">
                                @if ($offre->statut === 'active')
                                    <span
                                        class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.active') }}</span>
                                @elseif($offre->statut === 'vendue')
                                    <span
                                        class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.sold') }}</span>
                                @elseif($offre->statut === 'validé')
                                    <span
                                        class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.validated') }}</span>
                                @elseif($offre->statut === 'expirée')
                                    <span
                                        class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.expired') }}</span>
                                @elseif($offre->statut === 'en attente')
                                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.pending') }}</span>
                                @elseif($offre->statut === 'rejeté')
                                    <span
                                        class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.rejected') }}</span>
                                @else
                                    <span
                                        class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.suspended') }}</span>
                                @endif

                                @if ($offre->is_published)
                                    <span
                                        class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.published') }}</span>
                                @else
                                    <span
                                        class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.unpublished') }}</span>
                                @endif



                            </div>

                            <!-- Badge catégorie -->
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-white bg-opacity-90 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $offre->category->name }}
                                </span>
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="p-5 overflow-visible">
                            <h3 class="text-lg font-bold text-gray-800 mb-2 truncate">{{ $offre->titre }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $offre->description }}</p>

                            <!-- Infos -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-primary-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <span
                                        class="font-bold text-primary-600">{{ number_format($offre->prix, 0, ',', ' ') }}
                                        FCFA</span>
                                    <span class="mx-1">/</span>
                                    <span>{{ $offre->unite }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $offre->localisation }}</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span>{{ $offre->quantite }} {{ $offre->unite }}
                                        {{ __('offers.available') }}</span>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4 pb-4 border-b">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    {{ $offre->views_count }} {{ __('offers.views') }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    {{ $offre->contacts_count }} {{ __('offers.contacts') }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2 relative z-10">
                                <button wire:click="openDetailsModal({{ $offre->id }})"
                                    class="flex-1 bg-primary-50 text-primary-600 px-4 py-2 rounded-lg hover:bg-primary-100 transition font-medium text-sm">
                                    {{ __('offers.details') }}
                                </button>
                                <button wire:click="openEditModal({{ $offre->id }})"
                                    class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <div x-data="{ open: false }" class="relative z-10">
                                    <button @click="open = !open"
                                        class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div x-show="open" x-cloak @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-[100]">
                                        @if ($offre->statut === 'active')
                                            <button wire:click="markAsSold({{ $offre->id }})"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ __('offers.mark_as_sold') }}
                                            </button>
                                        @endif
                                        <button wire:click="duplicateOffer({{ $offre->id }})"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ __('offers.duplicate') }}
                                        </button>
                                        <hr class="my-2">
                                        <button wire:click="openDeleteModal({{ $offre->id }})"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            {{ __('offers.delete') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl p-12 text-center">
                            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-700 mb-2">{{ __('offers.no_offers_found') }}</h3>
                            <p class="text-gray-500 mb-6">{{ __('offers.create_first_offer') }}</p>
                            <button wire:click="openCreateModal"
                                class="bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition inline-flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>{{ __('offers.create_offer') }}</span>
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Liste des offres (List) -->
            <div x-show="viewMode === 'list'" class="bg-white rounded-2xl shadow-lg overflow-visible">
                @foreach ($offers as $offre)
                    <div class="border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition group">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                                <!-- Image -->
                                <div class="lg:w-48 lg:flex-shrink-0">
                                    <div class="relative h-40 lg:h-32 bg-gray-200 rounded-xl overflow-hidden">
                                        @if ($offre->photo_principale_url)
                                            <img src="{{ $offre->photo_principale_url }}" alt="{{ $offre->titre }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-100 to-primary-200">
                                                <svg class="w-12 h-12 text-primary-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Badge statut -->
                                        <div class="absolute top-2 right-2">
                                            @if ($offre->statut === 'active')
                                                <span
                                                    class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.active') }}</span>
                                            @elseif($offre->statut === 'vendue')
                                                <span
                                                    class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.sold') }}</span>
                                            @elseif($offre->statut === 'validé')
                                                <span
                                                    class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.validated') }}</span>
                                            @elseif($offre->statut === 'expirée')
                                                <span
                                                    class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.expired') }}</span>
                                            @elseif($offre->statut === 'en attente')
                                                <span
                                                    class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.pending') }}</span>
                                            @elseif($offre->statut === 'rejeté')
                                                <span
                                                    class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.rejected') }}</span>
                                            @else
                                                <span
                                                    class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.suspended') }}</span>
                                            @endif

                                            @if ($offre->is_published)
                                                <span
                                                    class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.published') }}</span>
                                            @else
                                                <span
                                                    class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">{{ __('offers.unpublished') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenu principal -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                        <!-- Informations principales -->
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between mb-3">
                                                <div>
                                                    <h3 class="text-xl font-bold text-gray-800 mb-1">
                                                        {{ $offre->titre }}</h3>
                                                    <!-- Badge catégorie -->
                                                    <span
                                                        class="inline-block bg-primary-50 text-primary-700 px-3 py-1 rounded-full text-sm font-semibold mb-3">
                                                        {{ $offre->category->name }}
                                                    </span>
                                                </div>
                                                <!-- Prix - Version desktop -->
                                                <div class="hidden lg:block text-right">
                                                    <div class="text-2xl font-bold text-primary-600">
                                                        {{ number_format($offre->prix, 0, ',', ' ') }} FCFA
                                                    </div>
                                                    <div class="text-sm text-gray-600">{{ __('offers.per') }} {{ $offre->unite }}</div>
                                                </div>
                                            </div>

                                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $offre->description }}</p>

                                            <!-- Informations détaillées -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                    <span class="truncate">{{ $offre->localisation }}</span>
                                                </div>
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400 flex-shrink-0"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                    <span>{{ $offre->quantite }} {{ $offre->unite }}
                                                        {{ __('offers.available') }}</span>
                                                </div>
                                            </div>

                                            <!-- Stats -->
                                            <div class="flex items-center space-x-6 text-xs text-gray-500">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                    {{ $offre->views_count }} {{ __('offers.views') }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                        </path>
                                                    </svg>
                                                    {{ $offre->contacts_count }} {{ __('offers.contacts') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Prix - Version mobile -->
                                        <div class="lg:hidden">
                                            <div class="text-xl font-bold text-primary-600">
                                                {{ number_format($offre->prix, 0, ',', ' ') }} FCFA
                                            </div>
                                            <div class="text-sm text-gray-600">{{ __('offers.per') }} {{ $offre->unite }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="lg:w-48 lg:flex-shrink-0 relative z-10">
                                    <div
                                        class="flex lg:flex-col items-center lg:items-end space-x-2 lg:space-x-0 lg:space-y-2">
                                        <button wire:click="openDetailsModal({{ $offre->id }})"
                                            class="flex-1 lg:w-full bg-primary-50 text-primary-600 px-4 py-2 rounded-lg hover:bg-primary-100 transition font-medium text-sm">
                                            {{ __('offers.details') }}
                                        </button>
                                        <button wire:click="openEditModal({{ $offre->id }})"
                                            class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>
                                        <div x-data="{ open: false }" class="relative z-10">
                                            <button @click="open = !open"
                                                class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div x-show="open" x-cloak @click.away="open = false"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-[100]"
                                                style="display: none;">
                                                @if ($offre->statut === 'validé')
                                                    <button wire:click="markAsSold({{ $offre->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center">
                                                        <svg class="w-4 h-4 mr-3" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        {{ __('offers.mark_as_sold') }}
                                                    </button>
                                                @endif
                                                <button wire:click="duplicateOffer({{ $offre->id }})"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center">
                                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    {{ __('offers.duplicate') }}
                                                </button>
                                                <hr class="my-2">
                                                <button wire:click="openDeleteModal({{ $offre->id }})"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                    {{ __('offers.delete') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $offers->links() }}
            </div>
        </div>

        <!-- Modales (Créer, Éditer, Supprimer, Détails) - À créer séparément -->

        <div x-show="$wire.showCreateModal || $wire.showEditModal"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-cloak class="fixed inset-0 z-50">

            {{-- Overlay avec backdrop blur --}}
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="$wire.closeModals()">
            </div>

            {{-- Modal Container --}}
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl transform transition-all"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    @click.stop>

                    {{-- Header Premium --}}
                    <div
                        class="relative bg-gradient-to-r from-green-600 via-green-700 to-emerald-600 px-6 sm:px-8 py-6 rounded-t-3xl overflow-hidden">
                        {{-- Pattern Background --}}
                        <div class="absolute inset-0 opacity-10"
                            style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                        </div>

                        <div class="relative flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        @if ($showEditModal)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">
                                        {{ $showEditModal ? __('offers.edit_offer') : __('offers.new_offer') }}
                                    </h3>
                                    <p class="text-sm text-green-100 mt-1">
                                        {{ $showEditModal ? __('offers.edit_subtitle') : __('offers.create_subtitle') }}
                                    </p>
                                </div>
                            </div>
                            <button @click="$wire.closeModals()"
                                class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2.5 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Body avec scroll --}}
                    <div class="max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                        <form wire:submit="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}"
                            class="p-6 sm:p-8 space-y-8">

                            {{-- Section Informations Générales --}}
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('offers.general_info') }}</h4>
                                </div>

                                <div class="grid grid-cols-1 gap-6">
                                    {{-- Titre --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.title') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="text" wire:model="titre"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                                placeholder="{{ __('offers.title_placeholder') }}">
                                        </div>
                                        @error('titre')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Description --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.description') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <textarea wire:model="description" rows="4"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 resize-y min-h-[100px]"
                                            placeholder="{{ __('offers.description_placeholder') }}"></textarea>
                                        @error('description')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-2">{{ __('offers.min_chars') }}</p>
                                    </div>

                                    {{-- Catégorie --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.category') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                            </div>
                                            <select wire:model="categorie"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                                <option value="">{{ __('offers.select_category') }}</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->icon }}
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('categorie')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Statut de publication --}}
                                    <div
                                        class="flex items-center justify-between bg-blue-50 border border-blue-100 rounded-2xl p-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-blue-900">{{ __('offers.publish_offer') }}</p>
                                                <p class="text-sm text-blue-700">{{ __('offers.publish_description') }}</p>
                                            </div>
                                        </div>
                                        <label class="flex items-center cursor-pointer select-none">
                                            <div class="relative">
                                                <input type="checkbox" wire:model="published" class="peer sr-only">
                                                <div
                                                    class="w-12 h-6 rounded-full bg-gray-300 peer-checked:bg-green-600 transition-colors">
                                                </div>
                                                <div
                                                    class="absolute top-0.5 left-0.5 h-5 w-5 bg-white rounded-full shadow transition-all peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Section Prix et Quantité --}}
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('offers.price_quantity') }}</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    {{-- Prix --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.price') }} (FCFA)
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="number" wire:model="prix" min="0"
                                                placeholder="5000"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        @error('prix')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Quantité --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.quantity') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="number" wire:model="quantite" min="1"
                                                placeholder="100"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        @error('quantite')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Unité --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.unit') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 8h14M5 8a2 2 0 110-4 2 2 0 010 4m14 0a2 2 0 110-4 2 2 0 010 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8M5 8V5a2 2 0 012-2h10a2 2 0 012 2v3m-9 4h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <select wire:model="unite"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                                <option value="">{{ __('offers.choose') }}</option>
                                                @foreach ($unites as $key => $label)
                                                    <option value="{{ $key }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('unite')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Section Localisation --}}
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('offers.location') }}</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    {{-- Région --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.region') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                                    </path>
                                                </svg>
                                            </div>
                                            <select wire:model="region"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                                <option value="">{{ __('offers.select') }}</option>
                                                @foreach ($regions as $reg)
                                                    <option value="{{ $reg }}">{{ $reg }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('region')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Ville --}}
                                    div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.city') }}
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="text" wire:model="ville" placeholder="{{ __('offers.city_placeholder') }}"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                    </div>

                                    {{-- Adresse --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.address') }}
                                            <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="text" wire:model="localisation"
                                                placeholder="{{ __('offers.address_placeholder') }}"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        @error('localisation')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Section Photos --}}
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-pink-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('offers.photos') }}</h4>
                                </div>

                                {{-- Photos existantes --}}
                                @if ($showEditModal && count($existingPhotos) > 0)
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-700 mb-3">{{ __('offers.current_photos') }}</p>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach ($existingPhotos as $photo)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $photo['path']) }}"
                                                        class="w-full h-32 object-cover rounded-xl border-2 border-gray-200 shadow-sm">

                                                    @if ($photo['is_principale'])
                                                        <div class="absolute top-2 left-2">
                                                            <span
                                                                class="bg-green-500 text-white text-xs px-2 py-1 rounded-full font-bold">{{ __('offers.main') }}</span>
                                                        </div>
                                                    @else
                                                        <button wire:click="setPhotoPrincipale({{ $photo['id'] }})"
                                                            class="absolute top-2 left-2 bg-white text-gray-700 text-xs px-2 py-1 rounded-full hover:bg-green-100 transition opacity-0 group-hover:opacity-100 shadow-sm">
                                                            {{ __('offers.set_main') }}
                                                        </button>
                                                    @endif

                                                    <button wire:click="deletePhoto({{ $photo['id'] }})"
                                                        class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition opacity-0 group-hover:opacity-100 shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Upload nouvelles photos --}}
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-bold text-gray-800 ml-1">
                                        {{ __('offers.add_photos') }}
                                    </label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-green-500 transition cursor-pointer bg-gray-50"
                                        onclick="document.getElementById('photos-input').click()">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                        </svg>
                                        <p class="text-sm text-gray-600 mb-1">{{ __('offers.upload_click') }}</p>
                                        <p class="text-xs text-gray-500">{{ __('offers.upload_format') }}</p>
                                        <input type="file" id="photos-input" wire:model="photos" multiple
                                            accept="image/*" class="hidden">
                                    </div>
                                    @error('photos.*')
                                        <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                            <span>⚠</span>{{ $message }}
                                        </p>
                                    @enderror

                                    {{-- Prévisualisation upload --}}
                                    @if ($photos)
                                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach ($photos as $photo)
                                                <div class="relative">
                                                    <img src="{{ $photo->temporaryUrl() }}"
                                                        class="w-full h-32 object-cover rounded-xl border-2 border-green-200 shadow-sm">
                                                    <div class="absolute top-2 right-2">
                                                        <span
                                                            class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">{{ __('offers.new') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Section Informations Complémentaires --}}
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('offers.additional_info') }}</h4>
                                </div>

                                <div class="grid grid-cols-1 gap-6">
                                    {{-- Conditions de livraison --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.delivery_conditions') }}
                                        </label>
                                        <textarea wire:model="conditions_livraison" rows="3"
                                            placeholder="{{ __('offers.delivery_placeholder') }}"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 resize-y min-h-[80px]"></textarea>
                                    </div>

                                    {{-- Contact --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.contact') }}
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="tel" wire:model="contact"
                                                placeholder="{{ __('offers.contact_placeholder') }}"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">{{ __('offers.contact_help') }}</p>
                                    </div>

                                    {{-- Date d'expiration --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('offers.expiration_date') }}
                                            <span class="text-gray-400 text-sm font-normal ml-2">{{ __('offers.optional') }}</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="date" wire:model="date_expiration"
                                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">{{ __('offers.expiration_help') }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer Actions --}}
                            <div
                                class="sticky bottom-0 -mx-8 -mb-8 px-8 py-6 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-4 mt-8 rounded-b-3xl">
                                <button type="button" @click="$wire.closeModals()"
                                    class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-white hover:shadow-sm transition-all focus:ring-2 focus:ring-gray-200">
                                    {{ __('offers.cancel') }}
                                </button>

                                <button type="submit"
                                    class="px-8 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-green-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="createOffer,updateOffer">
                                        {{ $showEditModal ? __('offers.update') : __('offers.create_offer') }}
                                    </span>
                                    <span wire:loading wire:target="createOffer,updateOffer"
                                        class="flex items-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        {{ __('offers.processing') }}
                                    </span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Détails Offre -->
        @if ($selectedOffer)

            <div x-show="$wire.showDetailsModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
                class="fixed inset-0 z-50" @click.self="$wire.closeModals()">

                {{-- Overlay avec backdrop blur --}}
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
                    @click="$wire.closeModals()">
                </div>

                {{-- Modal Container --}}
                <div class="flex min-h-screen items-center justify-center p-4">
                    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-6xl transform transition-all"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.stop>

                        {{-- Header Premium --}}
                        <div
                            class="relative bg-gradient-to-r from-green-600 via-green-700 to-emerald-600 px-6 sm:px-8 py-6 rounded-t-3xl overflow-hidden">
                            {{-- Pattern Background --}}
                            <div class="absolute inset-0 opacity-10"
                                style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                            </div>

                            <div class="relative flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-white">{{ __('offers.offer_details') }}</h3>
                                    </div>
                                </div>
                                <button @click="$wire.closeModals()"
                                    class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2.5 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Body avec scroll --}}
                        <div class="max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                            <div class="p-6 sm:p-8 space-y-8">

                                {{-- Section Images et Informations Principales --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                                    {{-- Galerie d'images --}}
                                    <div class="space-y-4">
                                        {{-- Image principale --}}
                                        <div
                                            class="relative h-80 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl overflow-hidden shadow-lg">
                                            @if ($selectedOffer->photos->count() > 0)
                                                <img src="{{ $selectedOffer->photo_principale_url }}"
                                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-24 h-24 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                    </svg>
                                                </div>
                                            @endif

                                            {{-- Badges statut --}}
                                            <div class="absolute top-4 right-4 flex flex-col gap-2">
                                                {{-- Statut principal --}}
                                                @if ($selectedOffer->statut === 'vendue')
                                                    <span
                                                        class="bg-green-500 text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        {{ __('offers.sold') }}
                                                    </span>
                                                @elseif($selectedOffer->statut === 'validé')
                                                    <span
                                                        class="bg-blue-500 text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.validated') }}
                                                    </span>
                                                @elseif($selectedOffer->statut === 'expirée')
                                                    <span
                                                        class="bg-red-500 text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ __('offers.expired') }}
                                                    </span>
                                                @elseif($selectedOffer->statut === 'en attente')
                                                    <span
                                                        class="bg-yellow-500 text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ __('offers.pending') }}
                                                    </span>
                                                @elseif($selectedOffer->statut === 'rejeté')
                                                    <span
                                                        class="bg-red-500 text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        {{ __('offers.rejected') }}
                                                    </span>
                                                @endif

                                                {{-- Statut publication --}}
                                                @if ($selectedOffer->is_published)
                                                    <span
                                                        class="bg-green-500 text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                        </svg>
                                                        {{ __('offers.published') }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="bg-gray-500 text-white px-3 py-2 rounded-xl text-sm font-bold shadow-lg flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.unpublished') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Miniatures --}}
                                        @if ($selectedOffer->photos->count() > 1)
                                            <div class="grid grid-cols-4 gap-3">
                                                @foreach ($selectedOffer->photos->take(4) as $photo)
                                                    <div class="relative group">
                                                        <img src="{{ asset('storage/' . $photo->path) }}"
                                                            class="w-full h-20 object-cover rounded-xl cursor-pointer transition-all duration-300 group-hover:scale-105 group-hover:shadow-lg border-2 border-gray-200">
                                                        <div
                                                            class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 rounded-xl transition-opacity">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Informations principales --}}
                                    <div class="space-y-6">
                                        {{-- Catégorie et Titre --}}
                                        <div class="space-y-4">
                                            <span
                                                class="inline-flex items-center gap-2 bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 px-4 py-2 rounded-xl text-sm font-semibold shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                                {{ $selectedOffer->category->name }}
                                            </span>

                                            <h2 class="text-3xl font-bold text-gray-800 leading-tight">
                                                {{ $selectedOffer->titre }}</h2>

                                            <div
                                                class="flex items-baseline space-x-3 bg-gradient-to-r from-gray-50 to-white p-4 rounded-2xl shadow-sm border border-gray-100">
                                                <span
                                                    class="text-4xl font-bold text-green-600">{{ number_format($selectedOffer->prix, 0, ',', ' ') }}</span>
                                                <span class="text-xl text-gray-600">FCFA /
                                                    {{ $selectedOffer->unite }}</span>
                                            </div>
                                        </div>

                                        {{-- Description --}}
                                        <div class="bg-gray-50 rounded-2xl p-6 shadow-sm border border-gray-100">
                                            <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2 text-lg">
                                                <svg class="w-5 h-5 text-green-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                {{ __('offers.description') }}
                                            </h3>
                                            <p class="text-gray-600 leading-relaxed text-sm">
                                                {{ $selectedOffer->description }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section Détails --}}
                                <div class="space-y-6">
                                    <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ __('offers.offer_details') }}</h4>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {{-- Informations principales --}}
                                        <div class="space-y-4">
                                            <div
                                                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-600 flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-green-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.quantity_available') }}
                                                    </span>
                                                    <span
                                                        class="font-bold text-gray-800 text-lg">{{ $selectedOffer->quantite }}
                                                        {{ $selectedOffer->unite }}</span>
                                                </div>

                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-600 flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-green-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.location') }}
                                                    </span>
                                                    <span
                                                        class="font-bold text-gray-800 text-lg">{{ $selectedOffer->localisation }}</span>
                                                </div>

                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-600 flex items-center gap-2">
                                                        <svg class="w-5 h-5 text-green-500" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                            </path>
                                                        </svg>
                                                        {{ __('offers.contact') }}
                                                    </span>
                                                    <span
                                                        class="font-bold text-gray-800 text-lg">{{ $selectedOffer->contact }}</span>
                                                </div>

                                                @if ($selectedOffer->date_expiration)
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-gray-600 flex items-center gap-2">
                                                            <svg class="w-5 h-5 text-green-500" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>
                                                            {{ __('offers.expires_on') }}
                                                        </span>
                                                        <span
                                                            class="font-bold text-gray-800 text-lg">{{ $selectedOffer->date_expiration->format('d/m/Y') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Statistiques --}}
                                        <div class="space-y-4">
                                            <div
                                                class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-6 shadow-sm border border-green-100">
                                                <h4 class="font-bold text-gray-800 mb-4 text-center">{{ __('offers.stats') }}</h4>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="text-center bg-white rounded-xl p-4 shadow-sm">
                                                        <div class="text-2xl font-bold text-green-600">
                                                            {{ $selectedOffer->views_count }}</div>
                                                        <div class="text-sm text-gray-600 mt-1">{{ __('offers.views') }}</div>
                                                    </div>
                                                    <div class="text-center bg-white rounded-xl p-4 shadow-sm">
                                                        <div class="text-2xl font-bold text-green-600">
                                                            {{ $selectedOffer->contacts_count }}</div>
                                                        <div class="text-sm text-gray-600 mt-1">{{ __('offers.contacts') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section Conditions de livraison --}}
                                @if ($selectedOffer->conditions_livraison)
                                    <div class="space-y-6">
                                        <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                            <div
                                                class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                                <svg class="w-5 h-5 text-purple-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                                                    </path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-900">{{ __('offers.delivery_conditions') }}</h4>
                                        </div>

                                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
                                            <p class="text-gray-700 leading-relaxed">
                                                {{ $selectedOffer->conditions_livraison }}</p>
                                        </div>
                                    </div>
                                @endif

                                {{-- Section Avis --}}
                                @if ($selectedOffer->avis->count() > 0)
                                    <div class="space-y-6">
                                        <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                            <div
                                                class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                                                <svg class="w-5 h-5 text-yellow-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-bold text-gray-900">
                                                {{ __('offers.buyer_reviews', ['count' => $selectedOffer->avis->count()]) }}
                                            </h4>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            @foreach ($selectedOffer->avis->take(4) as $avis)
                                                <div
                                                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                                                    <div class="flex items-start justify-between mb-3">
                                                        <div class="flex items-center space-x-3">
                                                            <img src="{{ $avis->consumer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($avis->consumer->name) . '&background=10b981&color=ffffff' }}"
                                                                class="w-12 h-12 rounded-xl object-cover border-2 border-green-100">
                                                            <div>
                                                                <p class="font-semibold text-gray-800">
                                                                    {{ $avis->consumer->name }}</p>
                                                                <div class="flex items-center mt-1">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <svg class="w-4 h-4 {{ $i <= $avis->note ? 'text-yellow-400' : 'text-gray-300' }}"
                                                                            fill="currentColor" viewBox="0 0 20 20">
                                                                            <path
                                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z">
                                                                            </path>
                                                                        </svg>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span
                                                            class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">{{ $avis->date_creation->diffForHumans() }}</span>
                                                    </div>
                                                    @if ($avis->commentaire)
                                                        <p
                                                            class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-3 rounded-lg">
                                                            {{ $avis->commentaire }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div
                            class="sticky bottom-0 -mb-8 px-8 py-6 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-4 mt-8 rounded-b-3xl">
                            <button type="button" @click="$wire.closeModals()"
                                class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-white hover:shadow-sm transition-all focus:ring-2 focus:ring-gray-200">
                                {{ __('offers.close') }}
                            </button>

                            <button wire:click="openEditModal({{ $selectedOffer->id }})"
                                class="px-8 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-green-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                {{ __('offers.edit_offer') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal Supprimer Offre -->
        <div x-show="$wire.showDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            @click.self="$wire.closeModals()">

            <div x-show="$wire.showDeleteModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">

                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('offers.delete_confirm_title') }}</h3>
                    <p class="text-gray-600 mb-6">
                        {{ __('offers.delete_confirm_message') }}
                    </p>

                    <div class="flex items-center justify-center space-x-3">
                        <button wire:click="closeModals"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                            {{ __('offers.cancel') }}
                        </button>
                        <button wire:click="deleteOffer" wire:loading.attr="disabled"
                            class="px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition font-medium shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            <span wire:loading.remove>{{ __('offers.delete') }}</span>
                            <span wire:loading>{{ __('offers.deleting') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .glass-effect {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
            }
        </style>

    </div>
</div>