{{-- resources/views/livewire/demands/demands-table.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-[#F9F6EE] to-[#E8E5DC] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 space-y-4 sm:space-y-0">
            <div>
                <h1 class="text-4xl font-bold text-[#2E7D32]" style="font-family: 'Poppins', sans-serif;">
                    Demandes Agricoles
                </h1>
                <p class="text-gray-600 mt-2">Trouvez des produits et services recherchés par la communauté</p>
            </div>

            <button wire:click="openCreateModal"
                class="flex items-center space-x-2 px-6 py-3 bg-[#2E7D32] text-white rounded-xl font-semibold 
                       hover:bg-[#1B5E20] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Publier une demande</span>
            </button>
        </div>

        {{-- Statistiques Rapides --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-[#2E7D32]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Total des demandes</p>
                        <p class="text-3xl font-bold text-[#2E7D32] mt-1">{{ \App\Models\Demand::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#2E7D32]/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#2E7D32]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Demandes récentes</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1">
                            {{ \App\Models\Demand::where('created_at', '>=', now()->subDays(7))->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Mes demandes</p>
                        <p class="text-3xl font-bold text-purple-600 mt-1">
                            {{ \App\Models\Demand::where('user_id', auth()->id())->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtres et Recherche --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                {{-- Recherche --}}
                <div class="md:col-span-2">
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Rechercher une demande..."
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all">
                        <svg class="w-6 h-6 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>

                        @if ($search)
                            <button wire:click="$set('search', '')"
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Filtre Catégorie --}}
                <div>
                    <select wire:model.live="categoryFilter"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtre Région --}}
                <div>
                    <select wire:model.live="regionFilter"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all">
                        <option value="">Toutes les régions</option>
                        @foreach ($regions as $reg)
                            <option value="{{ $reg }}">{{ $reg }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tri --}}
                <div>
                    <select wire:model.live="sortBy"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all">
                        <option value="latest">Plus récentes</option>
                        <option value="oldest">Plus anciennes</option>
                        <option value="product_asc">Produit (A-Z)</option>
                        <option value="product_desc">Produit (Z-A)</option>
                    </select>
                </div>
            </div>

            {{-- Résultats de recherche --}}
            @if ($search || $categoryFilter || $regionFilter)
                <div class="mt-4 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold text-[#2E7D32]">{{ $demands->total() }}</span> résultat(s) trouvé(s)
                    </p>
                    <button wire:click="$set('search', ''); $set('categoryFilter', ''); $set('regionFilter', '')"
                        class="text-sm text-[#2E7D32] hover:text-[#1B5E20] font-medium">
                        Réinitialiser les filtres
                    </button>
                </div>
            @endif
        </div>

        {{-- Tableau Desktop / Cartes Mobile --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- Vue Tableau (Desktop) --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-[#2E7D32] to-[#1B5E20] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Produit</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Catégorie</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Quantité</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Région</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Contact</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Statut</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($demands as $demand)
                            <tr class="hover:bg-[#F9F6EE] transition-colors duration-150 group">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-semibold text-gray-900">{{ Str::limit($demand->product, 30) }}</span>
                                        <span class="text-xs text-gray-500">Par {{ $demand->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                        {{ $demand->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $demand->quantity ? number_format($demand->quantity) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <div class="flex items-center space-x-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>{{ $demand->region }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ Str::limit($demand->contact, 20) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 {{ $demand->status_color }} text-xs font-semibold rounded-full">
                                        {{ $demand->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        {{-- Voir Détails --}}
                                        <button wire:click="openDetailsModal({{ $demand->id }})"
                                            class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors"
                                            title="Voir les détails">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        @if ($demand->user_id === auth()->id())
                                            {{-- Modifier --}}
                                            <button wire:click="openEditModal({{ $demand->id }})"
                                                class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition-colors"
                                                title="Modifier">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>

                                            {{-- Supprimer --}}
                                            <button wire:click="openDeleteModal({{ $demand->id }})"
                                                class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors"
                                                title="Supprimer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg> </button>
                                        @endif
                                    </div>
                                </td>
                        </tr> @empty <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center"> <svg class="w-16 h-16 text-gray-300 mb-4"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune demande trouvée
                                        </h3>
                                        <p class="text-gray-500 mb-6">
                                            @if ($search || $categoryFilter || $regionFilter)
                                                Essayez de modifier vos critères de recherche
                                            @else
                                                Soyez le premier à publier une demande !
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Vue Cartes (Mobile/Tablette) --}}
            <div class="lg:hidden p-4 space-y-4">
                @forelse($demands as $demand)
                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg transition-all duration-300">
                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $demand->product }}</h3>
                                <p class="text-xs text-gray-500">Par {{ $demand->user->name }}</p>
                            </div>
                            <span class="px-3 py-1 {{ $demand->status_color }} text-xs font-semibold rounded-full">
                                {{ $demand->status }}
                            </span>
                        </div>

                        {{-- Description --}}
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ $demand->description }}
                        </p>

                        {{-- Infos --}}
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span class="text-gray-700">{{ $demand->category }}</span>
                            </div>

                            <div class="flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <span
                                    class="text-gray-700">{{ $demand->quantity ? number_format($demand->quantity) : 'N/A' }}</span>
                            </div>

                            <div class="flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                </svg>
                                <span class="text-gray-700">{{ $demand->region }}</span>
                            </div>

                            <div class="flex items-center space-x-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                <span class="text-gray-700 text-xs">{{ Str::limit($demand->contact, 15) }}</span>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center space-x-2 pt-3 border-t border-gray-100">
                            <button wire:click="openDetailsModal({{ $demand->id }})"
                                class="flex-1 px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                                Voir détails
                            </button>

                            @if ($demand->user_id === auth()->id())
                                <button wire:click="openEditModal({{ $demand->id }})"
                                    class="px-4 py-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>

                                <button wire:click="openDeleteModal({{ $demand->id }})"
                                    class="px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune demande trouvée</h3>
                        <p class="text-gray-500 mb-6">Soyez le premier à publier une demande !</p>
                        <button wire:click="openCreateModal"
                            class="px-6 py-3 bg-[#2E7D32] text-white rounded-xl font-semibold hover:bg-[#1B5E20] transition-all">
                            Publier ma première demande
                        </button>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($demands->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $demands->links() }}
                </div>
            @endif
        </div>

        {{-- Modal Création/Édition --}}
        @if ($showCreateModal || $showEditModal)
            <div x-data="{ isOpen: true }" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click="$wire.closeModals()"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
                <div @click.stop x-transition:enter="transition ease-out duration-300 delay-100"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto my-8">
                    {{-- Header --}}
                    <div
                        class="sticky top-0 bg-gradient-to-r from-[#2E7D32] to-[#1B5E20] px-6 py-5 flex items-center justify-between z-10 rounded-t-2xl">
                        <div>
                            <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                                {{ $showCreateModal ? 'Publier une Demande' : 'Modifier la Demande' }}
                            </h2>
                            <p class="text-white/80 text-sm mt-1">Trouvez ce dont vous avez besoin</p>
                        </div>
                        <button wire:click="closeModals" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Formulaire --}}
                    <form wire:submit.prevent="{{ $showCreateModal ? 'createDemand' : 'updateDemand' }}"
                        class="p-6 space-y-6">

                        {{-- Grille de champs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Produit recherché --}}
                            <div class="md:col-span-2">
                                <label for="product" class="block text-sm font-medium text-gray-700 mb-2">
                                    Produit ou service recherché <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="product" wire:model.live.debounce.300ms="product"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                @error('product') border-red-500 @else border-gray-300 @enderror"
                                    placeholder="Ex: 50 sacs de riz paddy">
                                @error('product')
                                    <p class="text-red-500 text-xs mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description détaillée <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description" wire:model.live.debounce.300ms="description" rows="4"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all resize-none
                                @error('description') border-red-500 @else border-gray-300 @enderror"
                                    placeholder="Décrivez en détail ce que vous recherchez (qualité, conditionnement, délai...)"></textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Catégorie --}}
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catégorie <span class="text-red-500">*</span>
                                </label>
                                <select id="category" wire:model="category"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                @error('category') border-red-500 @else border-gray-300 @enderror">
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="text-red-500 text-xs mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Quantité --}}
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantité souhaitée
                                </label>
                                <input type="number" id="quantity" wire:model="quantity" min="1"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                @error('quantity') border-red-500 @else border-gray-300 @enderror"
                                    placeholder="Ex: 50">
                                @error('quantity')
                                    <p class="text-red-500 text-xs mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Région --}}
                            <div>
                                <label for="region" class="block text-sm font-medium text-gray-700 mb-2">
                                    Région <span class="text-red-500">*</span>
                                </label>
                                <select id="region" wire:model="region"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                @error('region') border-red-500 @else border-gray-300 @enderror">
                                    <option value="">Sélectionnez une région</option>
                                    @foreach ($regions as $reg)
                                        <option value="{{ $reg }}">{{ $reg }}</option>
                                    @endforeach
                                </select>
                                @error('region')
                                    <p class="text-red-500 text-xs mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Contact --}}
                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contact <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="contact" wire:model="contact"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                @error('contact') border-red-500 @else border-gray-300 @enderror"
                                    placeholder="Ex: +237 6XX XX XX XX">
                                @error('contact')
                                    <p class="text-red-500 text-xs mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Soyez précis dans votre demande pour recevoir des propositions adaptées.
                                        Les autres utilisateurs pourront vous contacter directement.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Barre de progression --}}
                        <div wire:loading wire:target="{{ $showCreateModal ? 'createDemand' : 'updateDemand' }}"
                            class="relative h-1 bg-gray-200 rounded-full overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-[#2E7D32] to-[#4CAF50] animate-progress">
                            </div>
                        </div>

                        {{-- Boutons --}}
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" wire:click="closeModals"
                                class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                                Annuler
                            </button>

                            <button type="submit" wire:loading.attr="disabled"
                                wire:target="{{ $showCreateModal ? 'createDemand' : 'updateDemand' }}"
                                class="px-6 py-3 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] 
                               transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg
                               disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
                               flex items-center space-x-2">
                                <svg wire:loading.remove
                                    wire:target="{{ $showCreateModal ? 'createDemand' : 'updateDemand' }}"
                                    class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>

                                <svg wire:loading
                                    wire:target="{{ $showCreateModal ? 'createDemand' : 'updateDemand' }}"
                                    class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>

                                <span wire:loading.remove
                                    wire:target="{{ $showCreateModal ? 'createDemand' : 'updateDemand' }}">
                                    {{ $showCreateModal ? 'Publier la demande' : 'Enregistrer' }}
                                </span>
                                <span wire:loading
                                    wire:target="{{ $showCreateModal ? 'createDemand' : 'updateDemand' }}">
                                    Enregistrement...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Modal Détails --}}
        @if ($showDetailsModal && $selectedDemand)
            <div x-data="{ isOpen: @entangle('showDetailsModal') }" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click="$wire.closeModals()"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div @click.stop x-transition:enter="transition ease-out duration-300 delay-100"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    {{-- Header --}}
                    <div
                        class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5 flex items-center justify-between rounded-t-2xl">
                        <div>
                            <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                                Détails de la Demande
                            </h2>
                            <p class="text-white/80 text-sm mt-1">Informations complètes</p>
                        </div>
                        <button wire:click="closeModals" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Contenu --}} <div class="p-6 space-y-6"> {{-- Produit --}} <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $selectedDemand->product }}</h3>
                            <div class="flex items-center space-x-3"> <span
                                    class="px-3 py-1 {{ $selectedDemand->status_color }} text-xs font-semibold rounded-full">
                                    {{ $selectedDemand->status }} </span> <span
                                    class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                    {{ $selectedDemand->category }} </span> </div>
                        </div>
                        {{-- Description --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Description</h4>
                            <p class="text-gray-600 leading-relaxed">{{ $selectedDemand->description }}</p>
                        </div>

                        {{-- Informations --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($selectedDemand->quantity)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Quantité</p>
                                            <p class="text-lg font-bold text-gray-900">
                                                {{ number_format($selectedDemand->quantity) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Région</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $selectedDemand->region }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Contact</p>
                                        <p class="text-lg font-bold text-gray-900">{{ $selectedDemand->contact }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Auteur --}}
                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Publié par</h4>
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-[#2E7D32] rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white font-bold text-lg">{{ substr($selectedDemand->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $selectedDemand->user->name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $selectedDemand->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Bouton Contact --}}
                        <div class="bg-[#2E7D32]/5 border border-[#2E7D32]/20 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Intéressé par cette demande ?</h4>
                                    <p class="text-sm text-gray-600">Contactez directement le demandeur</p>
                                </div>
                                <a href="tel:{{ $selectedDemand->contact }}"
                                    class="px-6 py-3 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] transition-all transform hover:scale-105 shadow-md">
                                    Contacter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- Modal Suppression --}}
        @if ($showDeleteModal)
            <div x-data="{ isOpen: @entangle('showDeleteModal') }" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click="$wire.closeModals()"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div @click.stop x-transition:enter="transition ease-out duration-300 delay-100"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    {{-- Icône d'avertissement --}}
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 text-center mb-2"
                        style="font-family: 'Poppins', sans-serif;">
                        Confirmer la suppression
                    </h3>
                    <p class="text-gray-600 text-center mb-6">
                        Êtes-vous sûr de vouloir supprimer cette demande ? Cette action est irréversible.
                    </p>

                    {{-- Boutons --}}
                    <div class="flex items-center space-x-3">
                        <button wire:click="closeModals"
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            Annuler
                        </button>

                        <button wire:click="deleteDemand" wire:loading.attr="disabled"
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 
                           transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg
                           disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
                           flex items-center justify-center space-x-2">
                            <svg wire:loading.remove wire:target="deleteDemand" class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            <svg wire:loading wire:target="deleteDemand" class="animate-spin h-5 w-5" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="deleteDemand">Supprimer</span>
                            <span wire:loading wire:target="deleteDemand">Suppression...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Styles supplémentaires --}}
        <style>
            [x-cloak] {
                display: none !important;
            }

            @keyframes progress {
                0% {
                    transform: translateX(-100%);
                }

                100% {
                    transform: translateX(100%);
                }
            }

            .animate-progress {
                animation: progress 1.5s ease-in-out infinite;
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
    </div>
