<div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-earth-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des Demandes</h1>
                    <p class="mt-2 text-sm text-gray-600">Modérer et gérer toutes les demandes de la plateforme</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <button wire:click="expireOldDemands"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white font-semibold rounded-xl hover:from-orange-700 hover:to-orange-800 shadow-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Expirer anciennes demandes
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Demandes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-primary-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
                    </div>
                    <div class="bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Vérifiées</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['verified'] }}</p>
                        <p class="text-xs text-orange-600 mt-1">{{ $stats['pending_verification'] }} en attente</p>
                    </div>
                    <div class="bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Réponses Totales</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['responses'] }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="md:col-span-2">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div>
                    <select wire:model.live="statusFilter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="all">Tous statuts</option>
                        <option value="active">Active</option>
                        <option value="satisfied">Satisfaite</option>
                        <option value="expired">Expirée</option>
                        <option value="cancelled">Annulée</option>
                    </select>
                </div>

                <div>
                    <select wire:model.live="verifiedFilter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="all">Toutes</option>
                        <option value="verified">✓ Vérifiées</option>
                        <option value="unverified">⏳ Non vérifiées</option>
                    </select>
                </div>

                <div>
                    <select wire:model.live="categoryFilter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Toutes catégories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select wire:model.live="sortBy"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="latest">Plus récentes</option>
                        <option value="oldest">Plus anciennes</option>
                        <option value="most_viewed">Plus consultées</option>
                        <option value="most_responses">Plus de réponses</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Demands Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Demande</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Demandeur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Localisation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stats</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($demands as $demand)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-start space-x-3">
                                        <span class="text-2xl flex-shrink-0">{{ $demand->category->icon }}</span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 line-clamp-2 truncate">
                                                {{ Str::words($demand->title,5) }}</p>
                                            <p class="text-xs text-gray-500 line-clamp-2">{{ Str::words($demand->description, 10) }}
                                            </p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span
                                                    class="px-2 py-1 rounded text-xs font-semibold {{ $demand->urgency_badge_color }}">
                                                    @if ($demand->urgency === 'high')
                                                        🔴 Urgente
                                                    @elseif($demand->urgency === 'medium')
                                                        🟡 Moyenne
                                                    @else
                                                        🟢 Normal
                                                    @endif
                                                </span>
                                                @if ($demand->is_verified)
                                                    <span
                                                        class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">✓
                                                        Vérifié</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($demand->user->name) }}&background=random"
                                            class="w-8 h-8 rounded-full" alt="{{ $demand->user->name }}">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $demand->user->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $demand->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $demand->city }}</div>
                                    <div class="text-xs text-gray-500">{{ $demand->region }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-xs text-gray-600 space-y-1">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            {{ $demand->views_count }} vues
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                                </path>
                                            </svg>
                                            {{ $demand->responses->count() }} réponses
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-2">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold {{ $demand->status_badge_color }} inline-block text-center">
                                            {{ ucfirst($demand->status) }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Expire: {{ $demand->validity_date->format('d/m') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="viewDetails({{ $demand->id }})"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                            title="Voir détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        @if (!$demand->is_verified)
                                            <button wire:click="openVerifyModal({{ $demand->id }})"
                                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition"
                                                title="Vérifier">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @else
                                            <button wire:click="unverifyDemand({{ $demand->id }})"
                                                class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition"
                                                title="Retirer vérification">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif

                                        <div x-data="{ open: false }" class="relative" x-cloak>
                                            <button @click="open = !open"
                                                class="p-2 text-gray-600 hover:bg-gray-50 rounded-lg transition"
                                                title="Plus d'actions">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>
                                            </button>

                                            <div x-show="open" @click.away="open = false" x-transition
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                                <button wire:click="updateStatus({{ $demand->id }}, 'active')"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-green-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Marquer active
                                                </button>
                                                <button wire:click="updateStatus({{ $demand->id }}, 'satisfied')"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                                                        </path>
                                                    </svg>
                                                    Marquer satisfaite
                                                </button>
                                                <button wire:click="updateStatus({{ $demand->id }}, 'cancelled')"
                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-orange-600" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    Annuler
                                                </button>
                                                <hr class="my-1">
                                                <button wire:click="confirmDelete({{ $demand->id }})"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande trouvée</h3>
                                    <p class="text-gray-600">Essayez de modifier vos critères de recherche</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $demands->links() }}
        </div>
    </div>

    <!-- Details Modal -->
    @if ($showDetailsModal && $selectedDemand)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDetailsModal') }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
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
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-primary-50 to-earth-50 rounded-xl p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-start space-x-4 flex-1">
                                    <span class="text-5xl">{{ $selectedDemand->category->icon }}</span>
                                    <div class="flex-1">
                                        <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $selectedDemand->title }}
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
                                            @if ($selectedDemand->is_verified)
                                                <span
                                                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                                    ✓ Vérifié le {{ $selectedDemand->verified_at->format('d/m/Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 leading-relaxed">{{ $selectedDemand->description }}</p>
                        </div>

                        <!-- User Info -->
                        <div class="bg-white border border-gray-200 rounded-xl p-4">
                            <h5 class="font-semibold text-gray-900 mb-3">Demandeur</h5>
                            <div class="flex items-center space-x-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedDemand->user->name) }}&background=random"
                                    class="w-12 h-12 rounded-full" alt="{{ $selectedDemand->user->name }}">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $selectedDemand->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $selectedDemand->user->email }}</p>
                                    <p class="text-xs text-gray-400">Inscrit le
                                        {{ $selectedDemand->user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                        <span class="text-sm font-medium">Budget</span>
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
                                    <span class="text-sm font-medium">Statistiques</span>
                                </div>
                                <p class="text-gray-900 font-semibold">{{ $selectedDemand->views_count }} vues •
                                    {{ $selectedDemand->contacts_received }} contacts</p>
                            </div>
                        </div>

                        <!-- Responses -->
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
                                                <p class="font-semibold text-gray-900">{{ $response->user->name }}</p>
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
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-sm">
                                        @if ($response->proposed_price)
                                            <p class="text-gray-600">
                                                <strong>Prix:</strong>
                                                {{ number_format($response->proposed_price, 0, ',', ' ') }} FCFA
                                            </p>
                                        @endif
                                        @if ($response->contact_phone)
                                            <p class="text-gray-600">
                                                <strong>Tél:</strong> {{ $response->contact_phone }}
                                            </p>
                                        @endif
                                        @if ($response->contact_email)
                                            <p class="text-gray-600">
                                                <strong>Email:</strong> {{ $response->contact_email }}
                                            </p>
                                        @endif
                                    </div>
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

    <!-- Verify Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDeleteModal') }">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

                <div x-show="show" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">

                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Supprimer la demande</h3>
                    <p class="text-gray-600 text-center mb-6">Êtes-vous sûr de vouloir supprimer cette demande ? Cette
                        action est irréversible.</p>

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
</div>

