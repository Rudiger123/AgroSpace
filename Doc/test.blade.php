<!-- Modal Créer/Éditer Article -->
<div x-show="$wire.showCreateModal || $wire.showEditModal" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-cloak
    class="fixed inset-0 bg-gradient-to-br from-black/60 via-black/50 to-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 overflow-y-auto">

    <div x-show="$wire.showCreateModal || $wire.showEditModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95 -translate-y-4"
        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
        class="bg-white rounded-3xl shadow-2xl max-w-6xl w-full max-h-[95vh] overflow-hidden my-8 border border-gray-100"
        @click.away="$wire.closeModals()">

        <!-- Modal Header avec Design Moderne -->
        <div class="relative overflow-hidden">
            <!-- Gradient Background avec Pattern -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-green-500 to-yellow-500">
                <div class="absolute inset-0 opacity-20"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                </div>
            </div>

            <div class="relative px-8 py-8">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-5">
                        <!-- Icon avec Animation -->
                        <div
                            class="bg-white/20 backdrop-blur-md rounded-2xl p-4 shadow-2xl border border-white/30 transform hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div class="pt-1">
                            <h3 class="text-3xl font-black text-white mb-2 tracking-tight"
                                x-text="$wire.showCreateModal ? '✨ Créer un Nouvel Article' : '✏️ Modifier l\'Article'">
                            </h3>
                            <p class="text-green-100 text-base font-medium max-w-md leading-relaxed">
                                {{ $showEditModal ? 'Mettez à jour les informations de votre article pour tenir votre communauté informée' : 'Partagez vos connaissances et inspirez la communauté AgroSpace' }}
                            </p>
                            <!-- Progress Steps -->
                            <div class="flex items-center space-x-3 mt-4">
                                <div
                                    class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    <span class="text-white text-xs font-semibold">En cours d'édition</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button wire:click="closeModals"
                        class="text-white/90 hover:text-white hover:bg-white/20 backdrop-blur-sm rounded-xl p-3 transition-all duration-200 transform hover:scale-110 hover:rotate-90 group">
                        <svg class="w-6 h-6 transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Decorative Wave -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg class="w-full h-6 text-white" preserveAspectRatio="none" viewBox="0 0 1200 120"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                        fill="currentColor"></path>
                </svg>
            </div>
        </div>

        <form wire:submit="save" @submit.prevent>
            <!-- Body avec Scrollbar Personnalisée -->
            <div class="overflow-y-auto max-h-[calc(95vh-250px)] px-8 py-8 space-y-8 custom-scrollbar">

                <!-- Section 1: Informations Principales -->
                <div
                    class="bg-gradient-to-br from-green-50 via-white to-yellow-50 rounded-2xl p-8 border-2 border-green-100 shadow-lg">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-3 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Informations Principales</h4>
                            <p class="text-sm text-gray-600">Les détails essentiels de votre article</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Titre -->
                        <div class="group">
                            <label for="title"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                                <span>Titre de l'Article</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model.live="title" id="title" wire:blur="generateSlug"
                                    class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-base bg-white hover:border-green-300 group-hover:shadow-lg placeholder-gray-400"
                                    placeholder="Ex: Les meilleures techniques de culture du maïs">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </div>
                                <!-- Character Counter -->
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xs text-gray-400"
                                    x-data="{ length: $wire.entangle('title').length }">
                                    <span x-text="length"></span>/100
                                </div>
                            </div>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="group">
                            <label for="slug"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                                <span>URL (Slug)</span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model="slug" id="slug"
                                    class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-base bg-white hover:border-green-300 group-hover:shadow-lg placeholder-gray-400"
                                    placeholder="les-meilleures-techniques-culture-mais">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Généré automatiquement à partir du titre</span>
                            </p>
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Classification -->
                <div
                    class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 rounded-2xl p-8 border-2 border-blue-100 shadow-lg">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Classification</h4>
                            <p class="text-sm text-gray-600">Catégorie et tags pour organiser votre contenu</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Catégorie -->
                        <div class="group">
                            <label for="category_id"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                <span>Catégorie</span>
                            </label>
                            <div class="relative">
                                <select wire:model="category_id" id="category_id"
                                    class="w-full pl-12 pr-10 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-base bg-white hover:border-blue-300 group-hover:shadow-lg appearance-none cursor-pointer">
                                    <option value="">🗂️ Sélectionner une catégorie</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->icon ?? '📁' }}
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="group">
                            <label for="tags"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span>Tags</span>
                            </label>
                            <div class="relative">
                                <select wire:model="tags" id="tags" multiple
                                    class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-base bg-white hover:border-blue-300 group-hover:shadow-lg">
                                    @foreach ($allTags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->icon ?? '🏷️' }}
                                            {{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute left-4 top-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs tags</span>
                            </p>
                            @error('tags')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Image de Couverture -->
                <div
                    class="bg-gradient-to-br from-purple-50 via-white to-pink-50 rounded-2xl p-8 border-2 border-purple-100 shadow-lg">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-3 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Image de Couverture</h4>
                            <p class="text-sm text-gray-600">Choisissez une image attractive pour votre article</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if ($existing_image)
                            <div class="relative group inline-block">
                                <img src="{{ Storage::url($existing_image) }}" alt="Image actuelle"
                                    class="w-40 h-40 rounded-2xl object-cover shadow-2xl border-4 border-white ring-2 ring-purple-200 transform transition-transform group-hover:scale-105">
                                <button type="button" wire:click="$set('existing_image', '')"
                                    class="absolute -top-3 -right-3 w-10 h-10 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 opacity-0 group-hover:opacity-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <div
                                    class="absolute inset-0 bg-black/50 backdrop-blur-sm rounded-2xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-white font-semibold text-sm">Supprimer</p>
                                </div>
                            </div>
                        @endif

                        <div
                            class="border-2 border-dashed border-purple-300 rounded-2xl p-8 hover:border-purple-500 transition-all duration-300 bg-white/50 hover:bg-white/80 cursor-pointer group">
                            <label for="featured_image" class="cursor-pointer block">
                                <div class="flex flex-col items-center space-y-4">
                                    <div
                                        class="w-20 h-20 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-base font-bold text-gray-900 mb-1">Cliquez pour télécharger ou
                                            glissez-déposez</p>
                                        <p class="text-sm text-gray-500">PNG, JPG, GIF jusqu'à 2MB</p>
                                    </div>
                                    <input type="file" wire:model="featured_image" id="featured_image"
                                        accept="image/*" class="hidden">
                                </div>
                            </label>
                        </div>
                        @error('featured_image')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section 4: Résumé -->
                <div
                    class="bg-gradient-to-br from-yellow-50 via-white to-orange-50 rounded-2xl p-8 border-2 border-yellow-100 shadow-lg">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl p-3 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Résumé</h4>
                            <p class="text-sm text-gray-600">Un aperçu concis de votre article</p>
                        </div>
                    </div>

                    <div class="group">
                        <label for="excerpt"
                            class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <span>Description Courte</span>
                        </label>
                        <div class="relative">
                            <textarea wire:model="excerpt" id="excerpt" rows="4"
                                class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-yellow-100 focus:border-yellow-500 transition-all duration-300 text-base resize-none bg-white hover:border-yellow-300 group-hover:shadow-lg placeholder-gray-400"
                                placeholder="Rédigez un résumé captivant de votre article (optionnel, généré automatiquement si vide)..."></textarea>
                            <div class="absolute bottom-4 right-4 text-xs text-gray-400 bg-white px-2 py-1 rounded-lg"
                                x-data="{ length: $wire.entangle('excerpt').length }">
                                <span x-text="length"></span>/200
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>Sera généré automatiquement depuis le contenu si laissé vide</span>
                        </p>
                        @error('excerpt')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section 5: Contenu Principal -->
                <div
                    class="bg-gradient-to-br from-gray-50 via-white to-slate-50 rounded-2xl p-8 border-2 border-gray-200 shadow-lg">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl p-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">Contenu de l'Article</h4>
                                <p class="text-sm text-gray-600">Rédigez le corps de votre article</p>
                            </div>
                        </div>
                        <!-- Toolbar Preview -->
                        <div class="flex items-center space-x-2 bg-gray-100 rounded-lg px-4 py-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                </path>
                            </svg>
                            <span class="text-xs font-medium text-gray-600">Markdown supporté</span>
                        </div>
                    </div>

                    <div class="group">
                        <label for="content"
                            class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>Texte Principal</span>
                            <span class="text-red-500">*</span>
                        </label>
                        <div wire:ignore>
                            <textarea wire:model="content" id="content" rows="16"
                                class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-100 focus:border-gray-500 transition-all duration-300 text-base resize-none bg-white hover:border-gray-300 group-hover:shadow-lg placeholder-gray-400 font-mono"
                                placeholder="Rédigez votre article ici...

# Titre Principal
## Sous-titre

Votre contenu en **gras** ou *italique*

- Liste à puces
- Élément 2

1. Liste numérotée
2. Élément 2"></textarea>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <p class="text-xs text-gray-500 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Utilisez le format Markdown pour le formatage</span>
                            </p>
                            <div class="text-xs text-gray-400" x-data="{ length: $wire.entangle('content').length }">
                                <span x-text="length"></span> caractères
                            </div>
                        </div>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Section 6: Options de Publication -->
                <div
                    class="bg-gradient-to-br from-teal-50 via-white to-cyan-50 rounded-2xl p-8 border-2 border-teal-100 shadow-lg">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl p-3 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Options de Publication</h4>
                            <p class="text-sm text-gray-600">Planifiez la publication de votre article</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Toggle Publier -->
                        <div
                            class="bg-white rounded-xl p-6 border-2 border-teal-100 hover:border-teal-300 transition-all">
                            <label class="flex items-center justify-between cursor-pointer group">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-teal-100 to-cyan-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-base font-bold text-gray-900">Publier maintenant</p>
                                        <p class="text-xs text-gray-500">L'article sera visible immédiatement</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" wire:model="published" class="peer sr-only"
                                        name="is_published" id="is_published">
                                    <div
                                        class="w-14 h-7 rounded-full bg-gray-300 peer-checked:bg-gradient-to-r peer-checked:from-teal-500 peer-checked:to-cyan-500 transition-all shadow-inner">
                                    </div>
                                    <div
                                        class="absolute top-0.5 left-0.5 h-6 w-6 bg-white rounded-full shadow-lg transition-all peer-checked:translate-x-7 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-gray-400 peer-checked:text-teal-500 hidden peer-checked:block"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Date de publication -->
                        <div class="group">
                            <label for="published_at"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Date et Heure de Publication</span>
                            </label>
                            <div class="relative">
                                <input type="datetime-local" wire:model="published_at" id="published_at"
                                    class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-300 text-base bg-white hover:border-teal-300 group-hover:shadow-lg">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-teal-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Laissez vide pour publication immédiate</span>
                            </p>
                            @error('published_at')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 7: SEO (Optimisation) -->
                <div
                    class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 rounded-2xl p-8 border-2 border-indigo-100 shadow-lg">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-3 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900">Optimisation SEO</h4>
                            <p class="text-sm text-gray-600">Améliorez votre visibilité sur les moteurs de recherche
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Meta Title -->
                        <div class="group">
                            <label for="meta_title"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                    </path>
                                </svg>
                                <span>Meta Title</span>
                            </label>
                            <div class="relative">
                                <input type="text" wire:model="meta_title" id="meta_title"
                                    class="w-full pl-12 pr-20 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-300 text-base bg-white hover:border-indigo-300 group-hover:shadow-lg placeholder-gray-400"
                                    placeholder="Titre optimisé pour les moteurs de recherche">
                                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-xs"
                                    x-data="{ length: $wire.entangle('meta_title').length }">
                                    <span :class="length > 60 ? 'text-green-600' : 'text-gray-400'"
                                        x-text="length"></span>
                                    <span class="text-gray-400">/60</span>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Idéalement entre 50-60 caractères</span>
                            </p>
                            @error('meta_title')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="group">
                            <label for="meta_description"
                                class="flex items-center space-x-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <span>Meta Description</span>
                            </label>
                            <div class="relative">
                                <textarea wire:model="meta_description" id="meta_description" rows="3"
                                    class="w-full px-6 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-300 text-base resize-none bg-white hover:border-indigo-300 group-hover:shadow-lg placeholder-gray-400"
                                    placeholder="Description concise pour les résultats de recherche (150-160 caractères recommandés)"></textarea>
                                <div class="absolute bottom-4 right-4 text-xs bg-white px-2 py-1 rounded-lg"
                                    x-data="{ length: $wire.entangle('meta_description').length }">
                                    <span :class="length >= 150 && length <= 160 ? 'text-green-600' : 'text-gray-400'"
                                        x-text="length"></span>
                                    <span class="text-gray-400">/160</span>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Optimal entre 150-160 caractères pour un affichage complet</span>
                            </p>
                            @error('meta_description')
                                <p class="mt-2 text-sm text-red-600 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Sticky avec Actions -->
            <div
                class="sticky bottom-0 bg-gradient-to-r from-white via-gray-50 to-white border-t-2 border-gray-200 px-8 py-6 rounded-b-3xl shadow-2xl backdrop-blur-lg">
                <div class="flex items-center justify-between">
                    <!-- Info Section -->
                    <div class="flex items-center space-x-4">
                        <div
                            class="hidden md:flex items-center space-x-3 bg-blue-50 px-4 py-3 rounded-xl border border-blue-200">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-blue-900">Sauvegarde automatique</p>
                                <p class="text-xs text-blue-600">Vos modifications sont enregistrées</p>
                            </div>
                        </div>

                        <!-- Preview Button -->
                        <button type="button"
                            class="hidden md:flex items-center space-x-2 px-5 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all font-semibold group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <span>Aperçu</span>
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3">
                        <button type="button" wire:click="closeModals"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all font-semibold flex items-center space-x-2 group">
                            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Annuler</span>
                        </button>

                        <button type="submit" wire:loading.attr="disabled"
                            class="relative px-8 py-4 bg-gradient-to-r from-green-500 via-green-600 to-green-700 text-white rounded-xl hover:from-green-600 hover:via-green-700 hover:to-green-800 transition-all font-bold shadow-xl hover:shadow-2xl disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 active:scale-95 flex items-center space-x-3 overflow-hidden group">
                            <!-- Animated Background -->
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-green-400 to-yellow-400 opacity-0 group-hover:opacity-20 transition-opacity">
                            </div>

                            <!-- Icon and Text -->
                            <div class="relative flex items-center space-x-3">
                                <svg wire:loading.remove wire:target="save"
                                    class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <svg wire:loading wire:target="save" class="w-6 h-6 animate-spin" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>

                                <span wire:loading.remove wire:target="save" class="text-lg">
                                    <span
                                        x-text="$wire.showCreateModal ? '✨ Créer l\'Article' : '💾 Mettre à Jour'"></span>
                                </span>
                                <span wire:loading wire:target="save" class="text-lg">
                                    Enregistrement en cours...
                                </span>
                            </div>

                            <!-- Shine Effect -->
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-30 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000">
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Progress Indicator -->
                <div class="mt-4 hidden md:block">
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                        <span>Complétion du formulaire</span>
                        <span>75%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500 shadow-lg"
                            style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Custom Scrollbar Styles -->
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #22c55e, #16a34a);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #16a34a, #15803d);
    }

    /* Animation pour le champ de saisie */
    @keyframes pulse-border {

        0%,
        100% {
            border-color: rgba(34, 197, 94, 0.3);
        }

        50% {
            border-color: rgba(34, 197, 94, 0.6);
        }
    }

    input:focus,
    textarea:focus,
    select:focus {
        animation: pulse-border 2s ease-in-out infinite;
    }

    /* Animation pour les icônes */
    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .group:hover svg {
        animation: float 2s ease-in-out infinite;
    }

    /* Gradient Animation */
    @keyframes gradient-shift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* File Upload Hover Effect */
    input[type="file"]:hover {
        cursor: pointer;
    }

    /* Smooth transitions for all interactive elements */
    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<!-- Alpine.js Data for Character Counters -->
<script>
    document.addEventListener('alpine:init', () => {
        // Vous pouvez ajouter des fonctions Alpine.js personnalisées ici si nécessaire
    });
</script>
