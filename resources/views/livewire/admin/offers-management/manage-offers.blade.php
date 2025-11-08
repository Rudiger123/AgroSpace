<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-green-50 p-6"
        x-data.ignore="{
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
                        <span>Mes Offres</span>
                    </h1>
                    <p class="text-gray-500 mt-1">Gérez vos offres de produits agricoles</p>
                </div>
                <button wire:click="openCreateModal"
                    class="bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Nouvelle Offre</span>
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
                    <p class="text-gray-600 font-medium">Total des offres</p>
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
                    <p class="text-gray-600 font-medium">Offres actives</p>
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
                    <p class="text-gray-600 font-medium">Offres vendues</p>
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
                    <p class="text-gray-600 font-medium">Offres expirées</p>
                </div>
            </div>

            <!-- Barre de recherche et filtres - Version simplifiée -->
            <div class="bg-white rounded-2xl p-6 shadow-lg glass-effect" x-data="{
                showFilters: false,
                viewMode: 'grid'
            }">
                <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 space-y-4 md:space-y-0 md:space-x-4">

                    <!-- Recherche -->
                    <div class="flex-1 relative">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Rechercher une offre..."
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
                            <span>Filtres</span>
                        </button>

                        <div class="flex items-center bg-gray-100 rounded-xl p-1">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                        <select wire:model.live="filterCategorie"
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                            <option value="">Toutes</option>
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <select wire:model.live="filterStatut"
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                            <option value="">Tous</option>
                            <option value="active">Active</option>
                            <option value="vendue">Vendue</option>
                            <option value="expirée">Expirée</option>
                            <option value="suspendue">Suspendue</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Région</label>
                        <select wire:model.live="filterRegion"
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500">
                            <option value="">Toutes</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="button" wire:click="resetFilters"
                            class="w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition font-medium">
                            Réinitialiser
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
                                        class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">Active</span>
                                @elseif($offre->statut === 'vendue')
                                    <span
                                        class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">Vendue</span>
                                @elseif($offre->statut === 'expirée')
                                    <span
                                        class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">Expirée</span>
                                @else
                                    <span
                                        class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold">Suspendue</span>
                                @endif
                            </div>

                            <!-- Badge catégorie -->
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-white bg-opacity-90 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $categories[$offre->categorie] ?? $offre->categorie }}
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
                                    <span>{{ $offre->quantite }} {{ $offre->unite }} disponible(s)</span>
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
                                    {{ $offre->views_count }} vues
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    {{ $offre->contacts_count }} contacts
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2 relative z-10">
                                <button wire:click="openDetailsModal({{ $offre->id }})"
                                    class="flex-1 bg-primary-50 text-primary-600 px-4 py-2 rounded-lg hover:bg-primary-100 transition font-medium text-sm">
                                    Détails
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
                                                Marquer comme vendue
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
                                            Dupliquer
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
                                            Supprimer
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
                            <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune offre trouvée</h3>
                            <p class="text-gray-500 mb-6">Créez votre première offre pour commencer à vendre vos
                                produits</p>
                            <button wire:click="openCreateModal"
                                class="bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition inline-flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Créer une offre</span>
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Liste des offres (List) -->
            <div x-show="viewMode === 'list'" class="bg-white rounded-2xl shadow-lg overflow-visible">
                @forelse($offers as $offre)
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
                                                    class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-bold">Active</span>
                                            @elseif($offre->statut === 'vendue')
                                                <span
                                                    class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs font-bold">Vendue</span>
                                            @elseif($offre->statut === 'expirée')
                                                <span
                                                    class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">Expirée</span>
                                            @else
                                                <span
                                                    class="bg-gray-500 text-white px-2 py-1 rounded-full text-xs font-bold">Suspendue</span>
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
                                                        {{ $categories[$offre->categorie] ?? $offre->categorie }}
                                                    </span>
                                                </div>
                                                <!-- Prix - Version desktop -->
                                                <div class="hidden lg:block text-right">
                                                    <div class="text-2xl font-bold text-primary-600">
                                                        {{ number_format($offre->prix, 0, ',', ' ') }} FCFA
                                                    </div>
                                                    <div class="text-sm text-gray-600">par {{ $offre->unite }}</div>
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
                                                        disponible(s)</span>
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
                                                    {{ $offre->views_count }} vues
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                        </path>
                                                    </svg>
                                                    {{ $offre->contacts_count }} contacts
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Prix - Version mobile -->
                                        <div class="lg:hidden">
                                            <div class="text-xl font-bold text-primary-600">
                                                {{ number_format($offre->prix, 0, ',', ' ') }} FCFA
                                            </div>
                                            <div class="text-sm text-gray-600">par {{ $offre->unite }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="lg:w-48 lg:flex-shrink-0 relative z-10">
                                    <div
                                        class="flex lg:flex-col items-center lg:items-end space-x-2 lg:space-x-0 lg:space-y-2">
                                        <button wire:click="openDetailsModal({{ $offre->id }})"
                                            class="flex-1 lg:w-full bg-primary-50 text-primary-600 px-4 py-2 rounded-lg hover:bg-primary-100 transition font-medium text-sm">
                                            Détails
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
                                                @if ($offre->statut === 'active')
                                                    <button wire:click="markAsSold({{ $offre->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition flex items-center">
                                                        <svg class="w-4 h-4 mr-3" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Marquer comme vendue
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
                                                    Dupliquer
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
                                                    Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Aucune offre trouvée</h3>
                        <p class="text-gray-500 mb-6">Créez votre première offre pour commencer à vendre vos
                            produits</p>
                        <button wire:click="openCreateModal"
                            class="bg-primary-500 text-white px-6 py-3 rounded-xl hover:bg-primary-600 transition inline-flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Créer une offre</span>
                        </button>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $offers->links() }}
            </div>
        </div>

        <!-- Modales (Créer, Éditer, Supprimer, Détails) - À créer séparément -->

        <!-- Modal Créer/Éditer Offre -->
        <div x-show="$wire.showCreateModal || $wire.showEditModal"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-y-auto">

            <div x-show="$wire.showCreateModal || $wire.showEditModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto my-8"
                @click.away="$wire.closeModals()">

                <!-- Header -->
                <div
                    class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between z-10 rounded-t-2xl">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span x-text="$wire.showCreateModal ? 'Créer une nouvelle offre' : 'Modifier l\'offre'"></span>
                    </h3>
                    <button type="button" wire:click="closeModals"
                        class="p-2 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}" @submit.prevent>

                    <!-- Body -->
                    <div class="p-6 space-y-6">

                        <!-- Informations générales -->
                        <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                            <h4 class="font-bold text-gray-800 flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Informations générales</span>
                            </h4>

                            <!-- Titre -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Titre de l'offre <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="titre" placeholder="Ex: Maïs bio de haute qualité"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                @error('titre')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea wire:model="description" rows="4" placeholder="Décrivez votre produit en détail..."
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Minimum 20 caractères</p>
                            </div>

                            <!-- Catégorie -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Catégorie <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="categorie"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach ($categories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('categorie')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Prix et quantité -->
                        <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                            <h4 class="font-bold text-gray-800 flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span>Prix et quantité</span>
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Prix -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Prix (FCFA) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" wire:model="prix" placeholder="5000" min="0"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                    @error('prix')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Quantité -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Quantité <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" wire:model="quantite" placeholder="100" min="1"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                    @error('quantite')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Unité -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Unité <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="unite"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                        <option value="">Choisir</option>
                                        @foreach ($unites as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('unite')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Localisation -->
                        <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                            <h4 class="font-bold text-gray-800 flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Localisation</span>
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Région -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Région <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="region"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                        <option value="">Sélectionnez</option>
                                        @foreach ($regions as $reg)
                                            <option value="{{ $reg }}">{{ $reg }}</option>
                                        @endforeach
                                    </select>
                                    @error('region')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ville -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Ville
                                    </label>
                                    <input type="text" wire:model="ville" placeholder="Ex: Douala"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                </div>

                                <!-- Localisation précise -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Adresse <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" wire:model="localisation" placeholder="Ex: Marché central"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                    @error('localisation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Photos -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="font-bold text-gray-800 flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Photos</span>
                            </h4>

                            <!-- Photos existantes -->
                            @if ($showEditModal && count($existingPhotos) > 0)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-3">Photos actuelles :</p>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($existingPhotos as $photo)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $photo['path']) }}"
                                                    class="w-full h-32 object-cover rounded-xl border-2 border-gray-200">

                                                @if ($photo['is_principale'])
                                                    <div class="absolute top-2 left-2">
                                                        <span
                                                            class="bg-primary-500 text-white text-xs px-2 py-1 rounded-full font-bold">Principale</span>
                                                    </div>
                                                @else
                                                    <button wire:click="setPhotoPrincipale({{ $photo['id'] }})"
                                                        class="absolute top-2 left-2 bg-white text-gray-700 text-xs px-2 py-1 rounded-full hover:bg-primary-100 transition opacity-0 group-hover:opacity-100">
                                                        Définir comme principale
                                                    </button>
                                                @endif

                                                <button wire:click="deletePhoto({{ $photo['id'] }})"
                                                    class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition opacity-0 group-hover:opacity-100">
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

                            <!-- Upload nouvelles photos -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ajouter des photos
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-500 transition cursor-pointer"
                                    onclick="document.getElementById('photos-input').click()">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="text-sm text-gray-600 mb-1">Cliquez pour télécharger ou glissez-déposez
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB (max 5 photos)</p>
                                    <input type="file" id="photos-input" wire:model="photos" multiple
                                        accept="image/*" class="hidden">
                                </div>
                                @error('photos.*')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <!-- Prévisualisation upload -->
                                @if ($photos)
                                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($photos as $photo)
                                            <div class="relative">
                                                <img src="{{ $photo->temporaryUrl() }}"
                                                    class="w-full h-32 object-cover rounded-xl border-2 border-primary-200">
                                                <div class="absolute top-2 right-2">
                                                    <span
                                                        class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Nouveau</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informations complémentaires -->
                        <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                            <h4 class="font-bold text-gray-800 flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span>Informations complémentaires</span>
                            </h4>

                            <!-- Conditions de livraison -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Conditions de livraison
                                </label>
                                <textarea wire:model="conditions_livraison" rows="3"
                                    placeholder="Ex: Livraison possible dans un rayon de 50km, frais en sus..."
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"></textarea>
                            </div>

                            <!-- Contact -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Numéro de contact
                                </label>
                                <input type="tel" wire:model="contact" placeholder="+237 6 90 12 34 56"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                <p class="text-xs text-gray-500 mt-1">Par défaut, votre numéro de profil sera utilisé
                                </p>
                            </div>

                            <!-- Date d'expiration -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Date d'expiration (optionnel)
                                </label>
                                <input type="date" wire:model="date_expiration"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                                <p class="text-xs text-gray-500 mt-1">L'offre sera automatiquement désactivée après
                                    cette
                                    date</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="sticky bottom-0 bg-white border-t px-6 py-4 flex items-center justify-end space-x-3 rounded-b-2xl">
                        <button type="button" wire:click="closeModals"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                            Annuler
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-6 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition font-medium shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2">
                            <span wire:loading.remove
                                x-text="$wire.showCreateModal ? 'Créer l\'offre' : 'Mettre à jour'"></span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Traitement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Détails Offre -->
        <div x-show="$wire.showDetailsModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 overflow-y-auto"
            @click.self="$wire.closeModals()">

            <div x-show="$wire.showDetailsModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-y-auto my-8">

                @if ($selectedOffer)
                    <!-- Header -->
                    <div
                        class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between z-10 rounded-t-2xl">
                        <h3 class="text-2xl font-bold text-gray-800">Détails de l'offre</h3>
                        <button wire:click="closeModals" class="p-2 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            <!-- Images -->
                            <div>
                                @if ($selectedOffer->photos->count() > 0)
                                    <div class="space-y-4">
                                        <!-- Image principale -->
                                        <div class="relative h-80 bg-gray-200 rounded-2xl overflow-hidden">
                                            <img src="{{ $selectedOffer->photo_principale_url }}"
                                                class="w-full h-full object-cover">

                                            <!-- Badge statut -->
                                            <div class="absolute top-4 right-4">
                                                @if ($selectedOffer->statut === 'active')
                                                    <span
                                                        class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">Active</span>
                                                @elseif($selectedOffer->statut === 'vendue')
                                                    <span
                                                        class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">Vendue</span>
                                                @elseif($selectedOffer->statut === 'expirée')
                                                    <span
                                                        class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">Expirée</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Miniatures -->
                                        @if ($selectedOffer->photos->count() > 1)
                                            <div class="grid grid-cols-4 gap-3">
                                                @foreach ($selectedOffer->photos->take(4) as $photo)
                                                    <img src="{{ asset('storage/' . $photo->path) }}"
                                                        class="w-full h-20 object-cover rounded-xl cursor-pointer hover:opacity-75 transition">
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div
                                        class="h-80 bg-gradient-to-br from-primary-100 to-primary-200 rounded-2xl flex items-center justify-center">
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
                                <!-- Titre et prix -->
                                <div>
                                    <span
                                        class="inline-block bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-semibold mb-3">
                                        {{ $categories[$selectedOffer->categorie] ?? $selectedOffer->categorie }}
                                    </span>
                                    <h2 class="text-3xl font-bold text-gray-800 mb-3">{{ $selectedOffer->titre }}</h2>
                                    <div class="flex items-baseline space-x-2">
                                        <span
                                            class="text-4xl font-bold text-primary-600">{{ number_format($selectedOffer->prix, 0, ',', ' ') }}</span>
                                        <span class="text-xl text-gray-600">FCFA / {{ $selectedOffer->unite }}</span>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <h3 class="font-bold text-gray-800 mb-2">Description</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $selectedOffer->description }}</p>
                                </div>

                                <!-- Détails -->
                                <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                            Quantité disponible
                                        </span>
                                        <span class="font-bold text-gray-800">{{ $selectedOffer->quantite }}
                                            {{ $selectedOffer->unite }}</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Localisation
                                        </span>
                                        <span
                                            class="font-bold text-gray-800">{{ $selectedOffer->localisation }}</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                            Contact
                                        </span>
                                        <span class="font-bold text-gray-800">{{ $selectedOffer->contact }}</span>
                                    </div>

                                    @if ($selectedOffer->date_expiration)
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-600 flex items-center">
                                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Expire le
                                            </span>
                                            <span
                                                class="font-bold text-gray-800">{{ $selectedOffer->date_expiration->format('d/m/Y') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Conditions de livraison -->
                                @if ($selectedOffer->conditions_livraison)
                                    <div>
                                        <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2 text-primary-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                                                </path>
                                            </svg>
                                            Conditions de livraison
                                        </h3>
                                        <p class="text-gray-600 bg-blue-50 p-3 rounded-lg">
                                            {{ $selectedOffer->conditions_livraison }}</p>
                                    </div>
                                @endif

                                <!-- Statistiques -->
                                <div class="bg-gradient-to-r from-primary-50 to-green-50 rounded-xl p-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-primary-600">
                                                {{ $selectedOffer->views_count }}</div>
                                            <div class="text-sm text-gray-600">Vues</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-2xl font-bold text-primary-600">
                                                {{ $selectedOffer->contacts_count }}</div>
                                            <div class="text-sm text-gray-600">Contacts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Avis si disponibles -->
                        @if ($selectedOffer->avis->count() > 0)
                            <div class="mt-8 pt-8 border-t">
                                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-primary-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                        </path>
                                    </svg>
                                    Avis des acheteurs ({{ $selectedOffer->avis->count() }})
                                </h3>

                                <div class="space-y-4">
                                    @foreach ($selectedOffer->avis->take(3) as $avis)
                                        <div class="bg-gray-50 rounded-xl p-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center space-x-3">
                                                    <img src="{{ $avis->acheteur->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($avis->acheteur->name) }}"
                                                        class="w-10 h-10 rounded-full">
                                                    <div>
                                                        <p class="font-semibold text-gray-800">
                                                            {{ $avis->acheteur->name }}</p>
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
                                                    class="text-sm text-gray-500">{{ $avis->date_creation->diffForHumans() }}</span>
                                            </div>
                                            @if ($avis->commentaire)
                                                <p class="text-gray-600 text-sm">{{ $avis->commentaire }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div
                        class="sticky bottom-0 bg-white border-t px-6 py-4 flex items-center justify-end space-x-3 rounded-b-2xl">
                        <button wire:click="closeModals"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                            Fermer
                        </button>
                        <button wire:click="openEditModal({{ $selectedOffer->id }})"
                            class="px-6 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition font-medium shadow-lg hover:shadow-xl flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            <span>Modifier</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

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
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">Supprimer cette offre ?</h3>
                    <p class="text-gray-600 mb-6">
                        Cette action est irréversible. Toutes les photos et informations liées à cette offre seront
                        définitivement supprimées.
                    </p>

                    <div class="flex items-center justify-center space-x-3">
                        <button wire:click="closeModals"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium">
                            Annuler
                        </button>
                        <button wire:click="deleteOffer" wire:loading.attr="disabled"
                            class="px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition font-medium shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            <span wire:loading.remove>Supprimer</span>
                            <span wire:loading>Suppression...</span>
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
