<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-earth-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Mes Demandes</h1>
                        <p class="mt-2 text-sm text-gray-600">Gérez vos demandes de produits et services agricoles</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button wire:click="openCreateModal"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-xl hover:from-primary-700 hover:to-primary-800 shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nouvelle Demande
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $demands->total() }}</p>
                        </div>
                        <div class="bg-primary-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Actives</p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $demands->where('status', 'active')->count() }}</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Satisfaites</p>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $demands->where('status', 'satisfied')->count() }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Réponses</p>
                            <p class="text-2xl font-bold text-purple-600">{{ $demands->sum('contacts_received') }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <select wire:model.live="statusFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="all">Tous les statuts</option>
                            <option value="active">Active</option>
                            <option value="satisfied">Satisfaite</option>
                            <option value="expired">Expirée</option>
                            <option value="cancelled">Annulée</option>
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="categoryFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="regionFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Toutes les régions</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select wire:model.live="urgencyFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Toutes urgences</option>
                            <option value="high">🔴 Haute</option>
                            <option value="medium">🟡 Moyenne</option>
                            <option value="low">🟢 Basse</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Demands List -->
            <div class="space-y-4">
                @forelse($demands as $demand)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                            <div class="flex-1">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 mt-1">
                                        <span class="text-3xl">{{ $demand->category->icon }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $demand->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $demand->description }}
                                        </p>

                                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                    </path>
                                                </svg>
                                                {{ $demand->category->name }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ $demand->city }}, {{ $demand->region }}
                                            </span>
                                            @if ($demand->quantity)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                    {{ $demand->quantity }}
                                                </span>
                                            @endif
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                Expire le {{ $demand->validity_date->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2 mt-3">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $demand->status_badge_color }}">
                                                {{ ucfirst($demand->status) }}
                                            </span>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $demand->urgency_badge_color }}">
                                                @if ($demand->urgency === 'high')
                                                    🔴 Haute
                                                @elseif($demand->urgency === 'medium')
                                                    🟡 Moyenne
                                                @else
                                                    🟢 Basse
                                                @endif
                                            </span>
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                                👁️ {{ $demand->views_count }} vues
                                            </span>
                                            <span
                                                class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                                💬 {{ $demand->responses->count() }} réponses
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 mt-4 md:mt-0 md:ml-4">
                                <button wire:click="viewDetails({{ $demand->id }})"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                    title="Voir détails">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>

                                @if ($demand->status === 'active')
                                    <button wire:click="openEditModal({{ $demand->id }})"
                                        class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition"
                                        title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>

                                    <button wire:click="updateStatus({{ $demand->id }}, 'satisfied')"
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                        title="Marquer comme satisfaite">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>

                                    <button wire:click="updateStatus({{ $demand->id }}, 'cancelled')"
                                        class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition"
                                        title="Annuler">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </button>
                                @endif

                                <button wire:click="confirmDelete({{ $demand->id }})"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande trouvée</h3>
                        <p class="text-gray-600 mb-6">Commencez par créer votre première demande</p>
                        <button wire:click="openCreateModal"
                            class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Créer une demande
                        </button>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $demands->links() }}
            </div>
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $demandId ? 'Modifier la demande' : 'Nouvelle demande' }}
                            </h3>
                            <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form wire:submit.prevent="saveDemand" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre de la demande
                                        *</label>
                                    <input type="text" wire:model="title"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Ex: Recherche 500kg de maïs bio">
                                    @error('title')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description détaillée
                                        *</label>
                                    <textarea wire:model="description" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Décrivez en détail ce que vous recherchez..."></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                                    <select wire:model="category_id"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="">Sélectionnez une catégorie</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->icon }}
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantité</label>
                                    <input type="text" wire:model="quantity"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Ex: 500 kg, 20 sacs">
                                    @error('quantity')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Région *</label>
                                    <select wire:model="region"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="">Sélectionnez une région</option>
                                        @foreach ($regions as $reg)
                                            <option value="{{ $reg }}">{{ $reg }}</option>
                                        @endforeach
                                    </select>
                                    @error('region')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ville *</label>
                                    <input type="text" wire:model="city"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Ex: Douala">
                                    @error('city')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Budget (FCFA)</label>
                                    <input type="number" wire:model="budget"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Budget maximum">
                                    @error('budget')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de validité
                                        *</label>
                                    <input type="date" wire:model="validity_date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    @error('validity_date')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Urgence *</label>
                                    <select wire:model="urgency"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                        <option value="low">🟢 Basse</option>
                                        <option value="medium">🟡 Moyenne</option>
                                        <option value="high">🔴 Haute</option>
                                    </select>
                                    @error('urgency')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 pt-4 border-t">
                                <button type="button" wire:click="$set('showModal', false)"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                    Annuler
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 shadow-lg transition">
                                    {{ $demandId ? 'Mettre à jour' : 'Créer la demande' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Delete Confirmation Modal -->
        @if ($showDeleteModal)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDeleteModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                        <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Supprimer la demande</h3>
                        <p class="text-gray-600 text-center mb-6">Êtes-vous sûr de vouloir supprimer cette demande ?
                            Cette action est irréversible.</p>

                        <div class="flex space-x-3">
                            <button wire:click="$set('showDeleteModal', false)"
                                class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                Annuler
                            </button>
                            <button wire:click="deleteDemand"
                                class="flex-1 px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Details Modal -->
        @if ($showDetailsModal && $selectedDemand)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDetailsModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        class="inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl max-h-[90vh] overflow-y-auto">

                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Détails de la demande</h3>
                            <button wire:click="$set('showDetailsModal', false)"
                                class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <!-- Header Info -->
                            <div class="bg-gradient-to-r from-primary-50 to-earth-50 rounded-xl p-6">
                                <div class="flex items-start space-x-4">
                                    <span class="text-4xl">{{ $selectedDemand->category->icon }}</span>
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $selectedDemand->title }}
                                        </h4>
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $selectedDemand->status_badge_color }}">
                                                {{ ucfirst($selectedDemand->status) }}
                                            </span>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $selectedDemand->urgency_badge_color }}">
                                                @if ($selectedDemand->urgency === 'high')
                                                    🔴 Haute
                                                @elseif($selectedDemand->urgency === 'medium')
                                                    🟡 Moyenne
                                                @else
                                                    🟢 Basse
                                                @endif
                                            </span>
                                        </div>
                                        <p class="text-gray-700">{{ $selectedDemand->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium">Catégorie</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->category->name }}</p>
                                </div>

                                @if ($selectedDemand->quantity)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center text-gray-600 mb-1">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium">Quantité</span>
                                        </div>
                                        <p class="text-gray-900 font-semibold">{{ $selectedDemand->quantity }}</p>
                                    </div>
                                @endif

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Localisation</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->city }},
                                        {{ $selectedDemand->region }}</p>
                                </div>

                                @if ($selectedDemand->budget)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center text-gray-600 mb-1">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <span class="text-sm font-medium">Budget maximum</span>
                                        </div>
                                        <p class="text-gray-900 font-semibold">
                                            {{ number_format($selectedDemand->budget, 0, ',', ' ') }} FCFA</p>
                                    </div>
                                @endif

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium">Valide jusqu'au</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">
                                        {{ $selectedDemand->validity_date->format('d/m/Y') }}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-medium">Vues</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->views_count }} vues</p>
                                </div>
                            </div>

                            <!-- Responses Section -->
                            <div class="border-t pt-6">
                                <h5 class="text-lg font-bold text-gray-900 mb-4">
                                    Réponses reçues ({{ $selectedDemand->responses->count() }})
                                </h5>

                                @forelse($selectedDemand->responses as $response)
                                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center space-x-3">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($response->user->name) }}&background=22c55e&color=fff"
                                                    class="w-10 h-10 rounded-full" alt="{{ $response->user->name }}">
                                                <div>
                                                    <p class="font-semibold text-gray-900">{{ $response->user->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $response->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold {{ $response->status_badge_color }}">
                                                {{ ucfirst($response->status) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-700 mb-2">{{ $response->message }}</p>
                                        @if ($response->proposed_price)
                                            <p class="text-sm text-gray-600">
                                                <strong>Prix proposé:</strong>
                                                {{ number_format($response->proposed_price, 0, ',', ' ') }} FCFA
                                            </p>
                                        @endif
                                        @if ($response->contact_phone)
                                            <p class="text-sm text-gray-600">
                                                <strong>Contact:</strong> {{ $response->contact_phone }}
                                            </p>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500">Aucune réponse pour le moment</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('alert', (event) => {
                    const data = event[0] || event;
                    Swal.fire({
                        icon: data.type,
                        title: data.type === 'success' ? 'Succès' : 'Erreur',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
            });
        </script>
    @endpush
</div>
