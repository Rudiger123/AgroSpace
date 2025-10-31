<div>
    <div class="min-h-screen bg-gradient-to-br from-[#F9F6EE] to-[#E8E5DC] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div
                class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 space-y-4 sm:space-y-0">
                <div>
                    <h1 class="text-4xl font-bold text-[#2E7D32]" style="font-family: 'Poppins', sans-serif;">
                        Nos Offres Agricoles
                    </h1>
                    <p class="text-gray-600 mt-2">Découvrez les produits et services de notre communauté</p>
                </div>

                <button wire:click="openCreateModal"
                    class="flex items-center space-x-2 px-6 py-3 bg-[#2E7D32] text-white rounded-xl font-semibold 
                       hover:bg-[#1B5E20] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Publier une offre</span>
                </button>
            </div>

            {{-- Filtres et Recherche --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Recherche --}}
                    <div class="md:col-span-2">
                        <div class="relative">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Rechercher une offre..."
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
                </div>

                {{-- Résultats de recherche --}}
                @if ($search || $categoryFilter || $regionFilter)
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold text-[#2E7D32]">{{ $offers->total() }}</span> résultat(s)
                            trouvé(s)
                        </p>
                        <button wire:click="$set('search', ''); $set('categoryFilter', ''); $set('regionFilter', '')"
                            class="text-sm text-[#2E7D32] hover:text-[#1B5E20] font-medium">
                            Réinitialiser les filtres
                        </button>
                    </div>
                @endif
            </div>

            {{-- Grille d'Offres --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @forelse($offers as $offer)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden group"
                        wire:key="offer-{{ $offer->id }}">
                        {{-- Image --}}
                        <div class="relative h-48 overflow-hidden bg-gray-200">

                            @php
                                $imageUrl = $offer->image_url;
                            @endphp

                            <img src="{{ $imageUrl }}" alt="{{ $offer->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />

                            {{-- Badge Catégorie --}}
                            <div class="absolute top-3 left-3">
                                <span
                                    class="px-3 py-1 bg-[#2E7D32] text-white text-xs font-semibold rounded-full shadow-lg">
                                    {{ $offer->category }}
                                </span>
                            </div>

                            {{-- Actions (apparaissent au survol) --}}
                            @if ($offer->user_id === auth()->id())
                                <div
                                    class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex space-x-2">
                                    <button wire:click="openEditModal({{ $offer->id }})"
                                        class="p-2 bg-white rounded-full shadow-lg hover:bg-blue-50 transition-colors"
                                        title="Modifier">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="openDetailsModal({{ $offer->id }})"
                                        class="p-2 bg-white rounded-full shadow-lg hover:bg-blue-50 transition-colors"
                                        title="Modifier">
                                        <svg class="w-4 h-4 text-blue-600" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10 12.5C11.3807 12.5 12.5 11.3807 12.5 10C12.5 8.61929 11.3807 7.5 10 7.5C8.61929 7.5 7.5 8.61929 7.5 10C7.5 11.3807 8.61929 12.5 10 12.5Z"
                                                fill="#2E7D32" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.664255 10.5904C0.517392 10.2087 0.517518 9.78563 0.66461 9.40408C2.10878 5.65788 5.7433 3 9.99859 3C14.256 3 17.892 5.66051 19.3347 9.40962C19.4816 9.79127 19.4814 10.2144 19.3344 10.5959C17.8902 14.3421 14.2557 17 10.0004 17C5.74298 17 2.10698 14.3395 0.664255 10.5904ZM14.0004 10C14.0004 12.2091 12.2095 14 10.0004 14C7.79123 14 6.00037 12.2091 6.00037 10C6.00037 7.79086 7.79123 6 10.0004 6C12.2095 6 14.0004 7.79086 14.0004 10Z"
                                                fill="#0F172A" />
                                        </svg>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $offer->id }})"
                                        class="p-2 bg-white rounded-full shadow-lg hover:bg-red-50 transition-colors"
                                        title="Supprimer">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Contenu --}}
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1"
                                style="font-family: 'Poppins', sans-serif;">
                                {{ $offer->title }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $offer->description }}
                            </p>

                            {{-- Prix --}}
                            @if ($offer->price)
                                <div class="flex items-center mb-3">
                                    <span class="text-2xl font-bold text-[#2E7D32]">
                                        {{ number_format($offer->price, 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            @endif

                            {{-- Informations --}}
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $offer->region }}</span>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span class="line-clamp-1">{{ $offer->contact }}</span>
                                </div>
                            </div>

                            {{-- Auteur et Date --}}
                            <div
                                class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                                <span>Par {{ $offer->user->name }}</span>
                                <span>{{ $offer->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                            <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune offre trouvée</h3>
                            <p class="text-gray-500 mb-6">
                                @if ($search || $categoryFilter || $regionFilter)
                                    Essayez de modifier vos critères de recherche
                                @else
                                    Soyez le premier à publier une offre !
                                @endif
                            </p>
                            @if (!$search && !$categoryFilter && !$regionFilter)
                                <button wire:click="openCreateModal"
                                    class="px-6 py-3 bg-[#2E7D32] text-white rounded-xl font-semibold hover:bg-[#1B5E20] transition-all">
                                    Publier ma première offre
                                </button>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if ($offers->hasPages())
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    {{ $offers->links() }}
                </div>
            @endif
        </div>

        {{-- Modal Création/Édition --}}
        @if ($showCreateModal || $showEditModal)
            <div x-data="{ isOpen: true }" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click="$wire.closeModals()"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
                <div @click.stop x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto my-8">
                    {{-- Header --}}
                    <div
                        class="sticky top-0 bg-gradient-to-r from-[#2E7D32] to-[#1B5E20] px-6 py-5 flex items-center justify-between z-10">
                        <h2 class="text-2xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">
                            {{ $showCreateModal ? 'Publier une Offre' : 'Modifier l\'Offre' }}
                        </h2>
                        <button wire:click="closeModals" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12
"></path>
                            </svg> </button>
                    </div>
                    {{-- Formulaire --}}
                    <form wire:submit.prevent="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}"
                        class="p-6 space-y-6">

                        {{-- Upload Image Livewire simple --}}
                        <div class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Photo de l'offre</label>

                            <div
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors relative overflow-hidden group">

                                {{-- Prévisualisation Livewire --}}
                                @if ($image)
                                    <div class="absolute inset-0">
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" wire:click="$set('image', null)"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all">
                                                Changer l'image
                                            </button>
                                        </div>
                                    </div>
                                @elseif($existingImage)
                                    <div class="absolute inset-0">
                                        <img src="{{ Storage::url($existingImage) }}"
                                            class="w-full h-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <button type="button" wire:click="$set('image', null)"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all">
                                                Modifier
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-16 h-16 mb-4 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Cliquez pour télécharger</span> ou
                                            glissez-déposez
                                        </p>
                                        <p class="text-xs text-gray-400">PNG, JPG, JPEG (MAX. 5MB)</p>
                                    </div>
                                @endif

                                <input id="imageInput" type="file" wire:model="image"
                                    accept="image/png,image/jpeg,image/jpg"
                                    class="absolute inset-0 opacity-0 cursor-pointer" />
                            </div>

                            {{-- Indicateur de chargement --}}
                            <div wire:loading wire:target="image" class="text-sm text-green-700 font-medium">
                                Téléversement en cours...
                            </div>

                            {{-- Erreur validation --}}
                            @error('image')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Grille de champs --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Titre --}}
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Titre de l'offre <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title" wire:model.live.debounce.300ms="title"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                 border-gray-300"
                                    placeholder="Ex: Vente de 100 sacs de maïs">
                                @error('title')
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
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea id="description" wire:model.live.debounce.300ms="description" rows="4"
                                    class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all resize-none
                                 border-gray-300"
                                    placeholder="Décrivez votre offre en détail..."></textarea>
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
                                  border-gray-300">
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

                            {{-- Prix --}}
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prix (FCFA)
                                </label>
                                <div class="relative">
                                    <input type="number" id="price" wire:model="price" step="0.01"
                                        min="0"
                                        class="w-full pl-4 pr-20 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                     border-gray-300"
                                        placeholder="0">
                                    <span
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">
                                        FCFA
                                    </span>
                                </div>
                                @error('price')
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
                                 border-gray-300">
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
                                 border-gray-300"
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

                        {{-- Barre de progression --}}
                        <div wire:loading wire:target="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}"
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
                                wire:target="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}"
                                class="px-6 py-3 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] 
                               transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg
                               disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
                               flex items-center space-x-2">
                                <svg wire:loading.remove
                                    wire:target="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}"
                                    class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>

                                <svg wire:loading wire:target="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}"
                                    class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>

                                <span wire:loading.remove
                                    wire:target="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}">
                                    {{ $showCreateModal ? 'Publier l\'offre' : 'Enregistrer' }}
                                </span>
                                <span wire:loading
                                    wire:target="{{ $showCreateModal ? 'createOffer' : 'updateOffer' }}">
                                    Enregistrement...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        {{-- Modal Suppression --}}
        @if ($showDeleteModal)
            <div x-data="{ isOpen: @entangle('showDeleteModal') }" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @click="$wire.closeModals()"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div @click.stop x-transition:enter="transition ease-out duration-300"
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
                        Êtes-vous sûr de vouloir supprimer cette offre ? Cette action est irréversible.
                    </p>

                    {{-- Boutons --}}
                    <div class="flex items-center space-x-3">
                        <button wire:click="closeModals"
                            class="flex-1 px-4 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                            Annuler
                        </button>

                        <button wire:click="deleteOffer" wire:loading.attr="disabled"
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 
                           transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg
                           disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
                           flex items-center justify-center space-x-2">
                            <svg wire:loading.remove wire:target="deleteOffer" class="w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            <svg wire:loading wire:target="deleteOffer" class="animate-spin h-5 w-5" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="deleteOffer">Supprimer</span>
                            <span wire:loading wire:target="deleteOffer">Suppression...</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Modal Détails de l’Offre --}}
        @if ($showDetailsModal)
            <div x-data="{ isOpen: @entangle('showDetailsModal') }" x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                @keydown.escape.window="$wire.closeModals()" @click.self="$wire.closeModals()"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">

                {{-- Contenu principal --}}
                <div @click.stop x-transition:enter="transition ease-out duration-300 delay-100"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">

                    {{-- Header --}}
                    <div
                        class="bg-gradient-to-r from-[#2E7D32] to-[#1B5E20] px-6 py-5 flex items-center justify-between rounded-t-2xl">
                        <div>
                            <h2 class="text-2xl font-bold text-white font-poppins">Détails de l’offre</h2>
                            <p class="text-white/80 text-sm mt-1">Informations complètes sur cette offre</p>
                        </div>
                        <button wire:click="closeModals" class="p-2 hover:bg-white/10 rounded-lg transition-colors"
                            aria-label="Fermer le modal">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Contenu du modal --}}
                    <div class="p-6 space-y-8">

                        {{-- Image de l’offre --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Photo de l'offre</h3>
                            <div class="w-full h-64 rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                @if ($existingImage)
                                    <img src="{{ Storage::url($existingImage) }}" alt="Photo de l'offre"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400 italic">
                                        Aucune image disponible
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Informations principales --}}
                        <div class="space-y-4">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $title }}</h3>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    {{ $category }}
                                </span>
                                @if ($price)
                                    <span
                                        class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                        {{ number_format($price, 0, ',', ' ') }} FCFA
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Description</h4>
                            <p class="text-gray-600 leading-relaxed">{{ $description }}</p>
                        </div>

                        {{-- Informations complémentaires --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- Région --}}
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
                                        <p class="text-lg font-bold text-gray-900">{{ $region }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Contact --}}
                            <div class="bg-gray-50 rounded-lg p-4">
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
                                        <p class="text-lg font-bold text-gray-900">{{ $contact }}</p>
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
                                        class="text-white font-bold text-lg">{{ substr($author_name ?? '', 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $offer->user->name ?? 'Utilisateur' }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $offer->created_at?->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Bouton Contact --}}
                        <div class="bg-[#2E7D32]/5 border border-[#2E7D32]/20 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Intéressé par cette offre ?</h4>
                                    <p class="text-sm text-gray-600">Contactez directement le vendeur</p>
                                </div>
                                <a href="tel:{{ $contact }}"
                                    class="px-6 py-3 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] transition-all transform hover:scale-105 shadow-md">
                                    Contacter
                                </a>
                            </div>
                        </div>

                        {{-- Barre de chargement Livewire --}}
                        <div wire:loading class="relative h-1 bg-gray-200 rounded-full overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-[#2E7D32] to-[#4CAF50] animate-progress">
                            </div>
                        </div>

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
