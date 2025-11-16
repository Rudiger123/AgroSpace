<div>
    <div class="p-6 bg-agro-beige min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="bg-agro-white rounded-xl shadow-lg p-6 mb-6 border border-primary-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-agro-green font-poppins">Gestion des Catégories</h1>
                        <p class="text-agro-gray mt-2 font-inter">Gérez vos catégories de produits agricoles</p>
                    </div>
                    <button wire:click="create"
                        class="mt-4 md:mt-0 bg-agro-green hover:bg-primary-700 text-agro-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-primary-300 font-poppins flex items-center">
                        <!-- SVG Plus -->
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nouvelle Catégorie
                    </button>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-agro-white rounded-xl shadow-lg p-6 mb-6 border border-primary-100">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" wire:model.debounce.300ms="search"
                                placeholder="Rechercher une catégorie..."
                                class="w-full pl-10 pr-4 py-3 border border-primary-200 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter">
                            <!-- SVG Search -->
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-primary-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <select wire:model="sortField"
                            class="px-4 py-3 border border-primary-200 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent font-inter">
                            <option value="name">Nom</option>
                            <option value="created_at">Date de création</option>
                            <option value="is_active">Statut</option>
                        </select>
                        <button wire:click="sortBy('{{ $sortField }}')"
                            class="px-4 py-3 bg-primary-100 hover:bg-primary-200 rounded-lg transition-colors duration-300">
                            <!-- SVG Sort -->
                            <svg class="w-4 h-4 text-agro-green" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <div
                        class="bg-agro-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-primary-100 overflow-hidden">
                        <div class="h-2" style="background-color: {{ $category->color }}"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    @if ($category->icon)
                                        <!-- SVG Icon dynamique - vous devrez adapter selon vos icônes -->
                                        <div class="text-2xl mr-3" style="color: {{ $category->color }}">
                                            {!! $category->icon !!}
                                        </div>
                                    @else
                                        <!-- SVG Leaf par défaut -->
                                        <svg class="w-6 h-6 mr-3" style="color: {{ $category->color }}" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    @endif
                                    <h3 class="text-xl font-bold text-agro-gray font-poppins">{{ $category->name }}</h3>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button wire:click="toggleStatus({{ $category->id }})"
                                        class="w-8 h-8 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-gray-300' }} text-agro-white flex items-center justify-center transition-all duration-300 hover:scale-110">
                                        <!-- SVG Check or X -->
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if ($category->is_active)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            @endif
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            @if ($category->description)
                                <p class="text-agro-gray text-sm mb-4 font-inter line-clamp-2">
                                    {{ $category->description }}</p>
                            @endif

                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs text-primary-500 font-medium font-inter">{{ $category->created_at->diffForHumans() }}</span>
                                <div class="flex gap-2">
                                    <button wire:click="edit({{ $category->id }})"
                                        class="p-2 text-primary-600 hover:bg-primary-100 rounded-lg transition-colors duration-300">
                                        <!-- SVG Edit -->
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $category->id }})"
                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-300">
                                        <!-- SVG Trash -->
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $categories->links() }}
            </div>
        </div>

        <!-- Create/Edit Modal -->
        @if ($showModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 animate-fade-in"
                x-data="{ show: false }" x-init="setTimeout(() => show = true, 10)" x-show="show">
                <div class="bg-agro-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-in"
                    @click.away="show = false; $wire.closeModal()">
                    <div class="p-6 border-b border-primary-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-agro-green font-poppins">
                                {{ $categoryId ? 'Modifier la Catégorie' : 'Nouvelle Catégorie' }}
                            </h2>
                            <button wire:click="closeModal"
                                class="text-primary-400 hover:text-primary-600 transition-colors duration-300">
                                <!-- SVG Close -->
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form wire:submit.prevent="save" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Nom *</label>
                                <input type="text" wire:model="name"
                                    class="w-full px-4 py-3 border border-primary-200 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter">
                                @error('name')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Slug *</label>
                                <input type="text" wire:model="slug"
                                    class="w-full px-4 py-3 border border-primary-200 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter">
                                @error('slug')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div x-data="{ showPicker: false }" class="relative">

                                <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Icône</label>
                            
                                <!-- Input -->
                                <input type="text"
                                       wire:model="icon"
                                       placeholder="Clique pour choisir un emoji"
                                       @click="showPicker = !showPicker"
                                       class="w-full px-4 py-3 border border-primary-200 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter cursor-pointer">
                            
                                @error('icon')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            
                                <!-- Picker -->
                                <div x-show="showPicker"
                                     @click.away="showPicker = false"
                                     x-init="
                                        const picker = new EmojiMart.Picker({
                                            skinTonePosition: 'none',
                                            previewPosition: 'none',
                                            onEmojiSelect: (emoji) => {
                                                $wire.set('icon', emoji.native);
                                                showPicker = false;
                                            },
                                        });
                                        $el.appendChild(picker);
                                     "
                                     class="absolute z-50 bg-white border rounded-2xl shadow-xl mt-2">
                                </div>
                            
                                <p class="text-xs text-gray-500 mt-1">Clique pour sélectionner un emoji</p>
                            </div>
                            

                            <div>
                                <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Couleur
                                    *</label>
                                <div class="flex gap-2">
                                    <input type="color" wire:model="color"
                                        class="w-16 h-12 border border-primary-200 rounded-lg cursor-pointer">
                                    <input type="text" wire:model="color"
                                        class="flex-1 px-4 py-3 border border-primary-200 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter">
                                </div>
                                @error('color')
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-agro-gray mb-2 font-inter">Description</label>
                            <textarea wire:model="description" rows="4"
                                class="w-full px-4 py-3 border border-primary-200 rounded-lg focus:ring-2 focus:ring-agro-green focus:border-transparent transition-all duration-300 font-inter"></textarea>
                            @error('description')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" wire:model="is_active" id="is_active"
                                class="w-4 h-4 text-agro-green border-primary-200 rounded focus:ring-agro-green">
                            <label for="is_active" class="ml-2 text-sm font-medium text-agro-gray font-inter">
                                Catégorie active
                            </label>
                        </div>

                        <div class="flex justify-end gap-4 pt-6">
                            <button type="button" wire:click="closeModal"
                                class="px-6 py-3 border border-primary-300 text-primary-700 rounded-lg hover:bg-primary-50 transition-all duration-300 font-poppins">
                                Annuler
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-agro-green hover:bg-primary-700 text-agro-white rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-primary-300 font-poppins">
                                {{ $categoryId ? 'Mettre à jour' : 'Créer' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Delete Modal -->
        @if ($showDeleteModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 animate-fade-in"
                x-data="{ show: false }" x-init="setTimeout(() => show = true, 10)" x-show="show">
                <div class="bg-agro-white rounded-2xl shadow-2xl max-w-md w-full animate-scale-in"
                    @click.away="show = false; $wire.closeDeleteModal()">
                    <div class="p-6">
                        <div class="text-center">
                            <div
                                class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                                <!-- SVG Warning -->
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-agro-gray mb-2 font-poppins">Confirmer la suppression
                            </h3>
                            <p class="text-agro-gray mb-6 font-inter">Êtes-vous sûr de vouloir supprimer cette
                                catégorie ? Cette action est irréversible.</p>

                            <div class="flex gap-4 justify-center">
                                <button wire:click="closeDeleteModal"
                                    class="px-6 py-3 border border-primary-300 text-primary-700 rounded-lg hover:bg-primary-50 transition-all duration-300 font-poppins">
                                    Annuler
                                </button>
                                <button wire:click="delete"
                                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-agro-white rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-300 font-poppins">
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @push('scripts')
        <script>
            /* Ajouter des animations pour les cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.bg-agro-white');
            cards.forEach((card) => {
                card.classList.add('animate-fade-in');
            });
        });*/

            // Ajouter des animations supplémentaires
            document.addEventListener('DOMContentLoaded', function() {
                // Animation pour les cartes
                const cards = document.querySelectorAll('.bg-agro-white');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                    card.classList.add('animate-slide-up');
                });
            });

            // Fonction pour copier la couleur
            function copyColor(color) {
                navigator.clipboard.writeText(color).then(() => {
                    // Afficher une notification
                    showNotification('Couleur copiée !', 'success');
                });
            }

            // Fonction pour afficher des notifications
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg text-agro-white z-50 animate-slide-up ${
        type === 'success' ? 'bg-agro-green' : 
        type === 'error' ? 'bg-red-600' : 'bg-primary-600'
    }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        </script>
    @endpush
</div>
