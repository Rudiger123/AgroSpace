<div x-data="tagManager()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
         <!-- Header -->
         <div class="bg-agro-white rounded-xl shadow-lg p-6 mb-6 border border-primary-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-agro-green font-poppins"># Gestion des Tags</h1>
                    <p class="text-agro-gray mt-2 font-inter">Organisez et catégorisez vos contenus avec style</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 animate-slide-up animation-delay-400">
                    <button wire:click="create" 
                            class="group bg-gradient-to-br from-agro-green to-primary-700 hover:to-yellow-500 text-primary-100 px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-agro-yellow focus:ring-opacity-50 font-poppins flex items-center">
                        <!-- SVG Plus -->
                        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouveau Tag
                    </button>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="bg-gradient-to-br from-earth-500 to-earth-600 bg-opacity-20 hover:bg-opacity-30 text-agro-white px-6 py-4 rounded-xl font-semibold transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-agro-white focus:ring-opacity-50 font-poppins flex items-center">
                            <!-- SVG Ellipsis Vertical -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                            </svg>
                            Plus d'actions
                        </button>
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-agro-white ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <button wire:click="export" 
                                        class="group flex items-center px-4 py-3 text-sm text-agro-gray hover:bg-primary-50 w-full text-left transition-colors duration-200">
                                    <!-- SVG Download -->
                                    <svg class="w-4 h-4 mr-3 text-primary-600 group-hover:text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Exporter CSV
                                </button>
                                <button wire:click="$set('showImportModal', true)" 
                                        class="group flex items-center px-4 py-3 text-sm text-agro-gray hover:bg-primary-50 w-full text-left transition-colors duration-200">
                                    <!-- SVG Upload -->
                                    <svg class="w-4 h-4 mr-3 text-primary-600 group-hover:text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Importer CSV
                                </button>
                                @if(count($selectedTags) > 0)
                                    <button wire:click="$set('showBulkModal', true)" 
                                            class="group flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 w-full text-left transition-colors duration-200">
                                        <!-- SVG Trash -->
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Supprimer la sélection ({{ count($selectedTags) }})
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de recherche et filtres -->
        <div class="bg-agro-white rounded-xl shadow-xl mb-8 border border-primary-100 overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Recherche -->
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input type="text" 
                                   wire:model.debounce.500ms="search" 
                                   placeholder="Rechercher un tag..."
                                   class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <!-- SVG Search -->
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            @if($search)
                                <button wire:click="$set('search', '')" 
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-primary-400 hover:text-primary-600 transition-colors duration-300">
                                    <!-- SVG Close -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Tri -->
                    <div>
                        <select wire:model="sortField" 
                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition">
                            <option value="name">Trier par nom</option>
                            <option value="created_at">Date de création</option>
                            <option value="color">Couleur</option>
                            <option value="is_active">Statut</option>
                        </select>
                    </div>

                    <!-- Direction du tri -->
                    <div>
                        <button wire:click="sortBy('{{ $sortField }}')" 
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 bg-primary-100 hover:bg-primary-200 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 font-inter font-medium">
                            <span>Ordre</span>
                            <!-- SVG Sort -->
                            <svg class="w-5 h-5 text-agro-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Filtres rapides -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <button wire:click="$set('search', '')" 
                            class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ empty($search) ? 'bg-agro-green text-agro-white' : 'bg-primary-100 text-agro-gray hover:bg-primary-200' }}">
                        Tous les tags
                    </button>
                    <button wire:click="$set('search', 'is:active')" 
                            class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ $search === 'is:active' ? 'bg-agro-green text-agro-white' : 'bg-primary-100 text-agro-gray hover:bg-primary-200' }}">
                        Actifs
                    </button>
                    <button wire:click="$set('search', 'is:inactive')" 
                            class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ $search === 'is:inactive' ? 'bg-agro-green text-agro-white' : 'bg-primary-100 text-agro-gray hover:bg-primary-200' }}">
                        Inactifs
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-agro-green to-primary-700 rounded-xl p-6 text-agro-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-agro-beige text-sm font-inter">Total Tags</p>
                        <p class="text-3xl font-bold font-poppins">{{ $tags->total() }}</p>
                    </div>
                    <!-- SVG Hashtag -->
                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-br from-agro-yellow to-yellow-500 rounded-xl p-6 text-agro-green shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-700 text-sm font-inter">Actifs</p>
                        <p class="text-3xl font-bold font-poppins">{{ \App\Models\Tag::where('is_active', true)->count() }}</p>
                    </div>
                    <!-- SVG Check Circle -->
                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-br from-earth-500 to-earth-600 rounded-xl p-6 text-agro-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-earth-100 text-sm font-inter">Sélectionnés</p>
                        <p class="text-3xl font-bold font-poppins">{{ count($selectedTags) }}</p>
                    </div>
                    <!-- SVG Hand Pointer -->
                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-br from-secondary to-primary-600 rounded-xl p-6 text-agro-white shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-100 text-sm font-inter">Couleurs</p>
                        <p class="text-3xl font-bold font-poppins">{{ \App\Models\Tag::whereNotNull('color')->count() }}</p>
                    </div>
                    <!-- SVG Palette -->
                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Grille des tags -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($tags as $tag)
                <div wire:key="tag-{{ $tag->id }}" 
                     class="group relative bg-agro-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-2 border-transparent hover:border-agro-green overflow-hidden">
                    
                    <!-- Checkbox pour sélection multiple -->
                    <div class="absolute top-4 left-4 z-10">
                        <input type="checkbox" 
                               wire:model="selectedTags" 
                               value="{{ $tag->id }}"
                               class="w-5 h-5 text-agro-green border-2 border-primary-300 rounded focus:ring-agro-green focus:ring-2 transition-all duration-300">
                    </div>

                    <!-- Actions rapides -->
                    <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="flex gap-2">
                            <button wire:click="toggleStatus({{ $tag->id }})" 
                                    class="w-8 h-8 rounded-full {{ $tag->is_active ? 'bg-green-500 hover:bg-green-600' : 'bg-gray-400 hover:bg-gray-500' }} text-agro-white flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                                <!-- SVG Power -->
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </button>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="w-8 h-8 bg-agro-gray hover:bg-agro-green text-agro-white rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                                    <!-- SVG Ellipsis Horizontal -->
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-agro-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-20">
                                    <div class="py-1">
                                        <button wire:click="edit({{ $tag->id }})" 
                                                class="flex items-center px-4 py-2 text-sm text-agro-gray hover:bg-primary-50 w-full text-left transition-colors duration-200">
                                            <!-- SVG Edit -->
                                            <svg class="w-4 h-4 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Modifier
                                        </button>
                                        <button wire:click="duplicate({{ $tag->id }})" 
                                                class="flex items-center px-4 py-2 text-sm text-agro-gray hover:bg-primary-50 w-full text-left transition-colors duration-200">
                                            <!-- SVG Copy -->
                                            <svg class="w-4 h-4 mr-3 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Dupliquer
                                        </button>
                                        <button wire:click="confirmDelete({{ $tag->id }})" 
                                                class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left transition-colors duration-200">
                                            <!-- SVG Trash -->
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Supprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu du tag -->
                    <div class="p-6">
                        <!-- Couleur du tag -->
                        <div class="mb-4">
                            <div class="flex items-center gap-3">
                                @if($tag->color)
                                    <div class="w-6 h-6 rounded-full border-2 border-agro-white shadow-lg" 
                                         style="background-color: {{ $tag->color }}"></div>
                                    <span class="text-sm text-agro-gray font-inter">{{ $tag->color }}</span>
                                @else
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-r from-primary-400 to-primary-600 border-2 border-agro-white shadow-lg"></div>
                                    <span class="text-sm text-primary-500 font-inter">Couleur par défaut</span>
                                @endif
                            </div>
                        </div>

                        <!-- Nom et slug -->
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-agro-gray mb-1 font-poppins group-hover:text-agro-green transition-colors duration-300">
                                {{ $tag->name }}
                            </h3>
                            <p class="text-sm text-primary-500 font-inter">{{ $tag->slug }}</p>
                        </div>

                        <!-- Description -->
                        @if($tag->description)
                            <p class="text-agro-gray text-sm mb-4 font-inter line-clamp-2 group-hover:line-clamp-none transition-all duration-300">
                                {{ $tag->description }}
                            </p>
                        @endif

                        <!-- Statut et date -->
                        <div class="flex items-center justify-between pt-4 border-t border-primary-100">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full {{ $tag->is_active ? 'bg-green-500' : 'bg-gray-400' }} animate-pulse"></div>
                                <span class="text-xs font-medium {{ $tag->is_active ? 'text-green-600' : 'text-gray-600' }} font-inter">
                                    {{ $tag->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                            <span class="text-xs text-primary-500 font-inter">{{ $tag->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Effet au survol -->
                    <div class="absolute inset-0 bg-gradient-to-r from-agro-green to-primary-700 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-agro-white rounded-xl shadow-lg p-6 border border-primary-100">
            {{ $tags->links() }}
        </div>
    </div>

    <!-- Modal Create/Edit -->
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 animate-fade-in backdrop-blur-sm" 
             x-data="{ show: false, colorPicker: false }" 
             x-init="setTimeout(() => show = true, 10)" 
             x-show="show">
            <div class="bg-gradient-to-br from-agro-white to-primary-50 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto animate-scale-in border border-primary-200" 
                 @click.away="show = false; $wire.closeModal()">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-agro-green to-primary-700 p-8 text-agro-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold font-poppins">
                                {{ $tagId ? 'Modifier le Tag' : 'Créer un Tag' }}
                            </h2>
                            <p class="text-agro-beige mt-2 font-inter opacity-90">
                                {{ $tagId ? 'Mettez à jour les informations du tag' : 'Ajoutez un nouveau tag à votre collection' }}
                            </p>
                        </div>
                        <button wire:click="closeModal" 
                                class="text-agro-white hover:text-agro-beige transition-colors duration-300 transform hover:rotate-90">
                            <!-- SVG Close -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="p-8 space-y-8">
                    <!-- Nom et Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Nom *</label>
                            <div class="relative">
                                <input type="text" 
                                       wire:model="name" 
                                       placeholder="Entrez le nom du tag..."
                                       class="w-full pl-12 pr-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg">
                                <!-- SVG Hashtag -->
                                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                            @error('name') 
                                <span class="text-red-500 text-sm mt-2 block font-inter">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Slug *</label>
                            <div class="relative">
                                <input type="text" 
                                       wire:model="slug" 
                                       placeholder="slug-automatique"
                                       class="w-full pl-12 pr-4 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg bg-primary-50">
                                <!-- SVG Link -->
                                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            @error('slug') 
                                <span class="text-red-500 text-sm mt-2 block font-inter">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Description</label>
                        <textarea wire:model="description" 
                                  rows="4" 
                                  placeholder="Décrivez ce tag en détail..."
                                  class="w-full px-6 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter text-lg resize-none"></textarea>
                        @error('description') 
                            <span class="text-red-500 text-sm mt-2 block font-inter">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Couleur avec sélecteur avancé -->
                    <div>
                        <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Couleur</label>
                        <div class="space-y-4">
                            <!-- Sélecteur de couleur -->
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <input type="color" 
                                           wire:model="color" 
                                           class="w-16 h-16 rounded-xl border-4 border-agro-white shadow-lg cursor-pointer">
                                    <div class="absolute inset-0 rounded-xl ring-2 ring-primary-200 pointer-events-none"></div>
                                </div>
                                <input type="text" 
                                       wire:model="color" 
                                       placeholder="#22c55e"
                                       class="flex-1 px-6 py-4 border-2 border-primary-200 rounded-xl focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 text-lg">
                            </div>
                            
                            <!-- Préréglages de couleurs -->
                            <div>
                                <p class="text-sm font-medium text-agro-gray mb-3 font-inter">Couleurs prédéfinies :</p>
                                <div class="grid grid-cols-10 gap-2">
                                    @foreach($colorPresets as $preset)
                                        <button type="button" 
                                                wire:click="$set('color', '{{ $preset }}')"
                                                class="w-10 h-10 rounded-lg border-2 border-agro-white shadow-md hover:scale-110 transition-all duration-300 transform"
                                                style="background-color: {{ $preset }}"
                                                title="{{ $preset }}">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('color') 
                            <span class="text-red-500 text-sm mt-2 block font-inter">{{ $message }}</span> 
                        @enderror
                    </div>

                    <!-- Statut -->
                    <div class="flex items-center justify-between p-6 bg-gradient-to-r from-primary-50 to-primary-100 rounded-xl border border-primary-200">
                        <div>
                            <label class="text-lg font-bold text-agro-gray font-inter">Statut du tag</label>
                            <p class="text-sm text-agro-gray font-inter opacity-80">Activez ou désactivez ce tag</p>
                        </div>
                        <button type="button" 
                                wire:click="$set('is_active', !{{ $is_active }})"
                                class="relative inline-flex h-8 w-14 items-center rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-agro-green focus:ring-offset-2"
                                :class="{'bg-agro-green': {{ $is_active }}, 'bg-gray-300': !{{ $is_active }}}">
                            <span class="inline-block h-6 w-6 transform rounded-full bg-agro-white shadow-lg transition-transform duration-300" 
                                  :class="{'translate-x-7': {{ $is_active }}, 'translate-x-1': !{{ $is_active }}}">
                            </span>
                        </button>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-4 pt-6">
                        <button type="button" 
                                wire:click="closeModal" 
                                class="px-8 py-4 border-2 border-primary-300 text-agro-gray rounded-xl hover:bg-primary-50 transition-all duration-300 font-poppins font-semibold transform hover:scale-105 flex items-center">
                            <!-- SVG Close -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-8 py-4 bg-gradient-to-r from-agro-green to-primary-700 hover:from-primary-700 hover:to-base text-agro-white rounded-xl transition-all duration-300 font-poppins font-semibold transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-agro-green focus:ring-opacity-50 flex items-center">
                            <!-- SVG Save -->
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            {{ $tagId ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal de suppression -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 animate-fade-in backdrop-blur-sm" 
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 10)" 
             x-show="show">
            <div class="bg-agro-white rounded-2xl shadow-2xl max-w-md w-full animate-scale-in overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-agro-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold font-poppins">Confirmer la suppression</h3>
                        <button wire:click="closeDeleteModal" 
                                class="text-agro-white hover:text-agro-beige transition-colors duration-300">
                            <!-- SVG Close -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                        <!-- SVG Warning -->
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <p class="text-agro-gray mb-8 font-inter text-lg">
                        Êtes-vous sûr de vouloir supprimer ce tag ? Cette action est irréversible.
                    </p>
                    <div class="flex gap-4 justify-center">
                        <button wire:click="closeDeleteModal" 
                                class="px-8 py-3 border-2 border-primary-300 text-agro-gray rounded-xl hover:bg-primary-50 transition-all duration-300 font-poppins font-semibold">
                            Annuler
                        </button>
                        <button wire:click="delete" 
                                class="px-8 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-agro-white rounded-xl transition-all duration-300 font-poppins font-semibold transform hover:scale-105">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal d'import -->
    @if($showImportModal)
        <div class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 animate-fade-in backdrop-blur-sm" 
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 10)" 
             x-show="show">
            <div class="bg-agro-white rounded-2xl shadow-2xl max-w-lg w-full animate-scale-in overflow-hidden">
                <div class="bg-gradient-to-r from-agro-green to-primary-700 p-6 text-agro-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold font-poppins">Importer des tags</h3>
                        <button wire:click="$set('showImportModal', false)" 
                                class="text-agro-white hover:text-agro-beige transition-colors duration-300">
                            <!-- SVG Close -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <form wire:submit.prevent="import" class="p-8">
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-agro-gray mb-3 font-inter">Fichier CSV</label>
                        <div class="border-2 border-dashed border-primary-300 rounded-xl p-8 text-center hover:border-agro-green transition-colors duration-300">
                            <input type="file" 
                                   wire:model="importFile" 
                                   accept=".csv,.txt"
                                   class="hidden" 
                                   id="import-file">
                            <label for="import-file" class="cursor-pointer">
                                <!-- SVG Cloud Upload -->
                                <svg class="w-12 h-12 text-primary-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-agro-gray font-inter">Cliquez pour choisir un fichier CSV</p>
                                <p class="text-sm text-primary-500 font-inter mt-2">Format: nom, description, couleur, statut</p>
                            </label>
                        </div>
                        @error('importFile') 
                            <span class="text-red-500 text-sm mt-2 block font-inter">{{ $message }}</span> 
                        @enderror
                    </div>
                    <div class="flex gap-4 justify-end">
                        <button type="button" 
                                wire:click="$set('showImportModal', false)" 
                                class="px-6 py-3 border-2 border-primary-300 text-agro-gray rounded-xl hover:bg-primary-50 transition-all duration-300 font-poppins font-semibold">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-agro-green to-primary-700 hover:from-primary-700 hover:to-base text-agro-white rounded-xl transition-all duration-300 font-poppins font-semibold">
                            Importer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal de suppression en masse -->
    @if($showBulkModal)
        <div class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 animate-fade-in backdrop-blur-sm" 
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 10)" 
             x-show="show">
            <div class="bg-agro-white rounded-2xl shadow-2xl max-w-md w-full animate-scale-in overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-agro-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold font-poppins">Suppression multiple</h3>
                        <button wire:click="$set('showBulkModal', false)" 
                                class="text-agro-white hover:text-agro-beige transition-colors duration-300">
                            <!-- SVG Close -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                        <!-- SVG Trash -->
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <p class="text-agro-gray mb-2 font-inter text-lg">
                        Êtes-vous sûr de vouloir supprimer ces tags ?
                    </p>
                    <p class="text-2xl font-bold text-red-600 mb-8 font-poppins">{{ count($selectedTags) }} tags</p>
                    <div class="flex gap-4 justify-center">
                        <button wire:click="$set('showBulkModal', false)" 
                                class="px-8 py-3 border-2 border-primary-300 text-agro-gray rounded-xl hover:bg-primary-50 transition-all duration-300 font-poppins font-semibold">
                            Annuler
                        </button>
                        <button wire:click="bulkDelete" 
                                class="px-8 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-agro-white rounded-xl transition-all duration-300 font-poppins font-semibold transform hover:scale-105">
                            Supprimer tout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function tagManager() {
            return {
                // Fonctions utilitaires
                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                type: 'success',
                                message: 'Couleur copiée !',
                                icon: 'copy'
                            }
                        }));
                    });
                }
            }
        }
    </script>
</div>