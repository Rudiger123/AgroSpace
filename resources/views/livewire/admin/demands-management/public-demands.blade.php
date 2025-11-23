<div>
    <div class="min-h-screen bg-gradient-to-br from-primary-50 via-white to-earth-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Demandes Disponibles</h1>
                <p class="mt-2 text-sm text-gray-600">Parcourez les demandes et proposez vos produits ou services</p>
            </div>
    
            <!-- Stats Bar -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-primary-100 text-sm mb-1">Demandes actives</p>
                            <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>
    
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-sm mb-1">Urgence haute</p>
                            <p class="text-3xl font-bold">{{ $stats['high_urgency'] }}</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
    
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm mb-1">Nouvelles aujourd'hui</p>
                            <p class="text-3xl font-bold">{{ $stats['new_today'] }}</p>
                        </div>
                        <div class="bg-white/20 rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Filters & Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" 
                                   wire:model.live.debounce.300ms="search"
                                   placeholder="Rechercher une demande..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                    </div>
                    
                    <div>
                        <select wire:model.live="categoryFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Toutes catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div>
                        <select wire:model.live="regionFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Toutes régions</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div>
                        <select wire:model.live="urgencyFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Urgence</option>
                            <option value="high">🔴 Haute</option>
                            <option value="medium">🟡 Moyenne</option>
                            <option value="low">🟢 Basse</option>
                        </select>
                    </div>
    
                    <div>
                        <select wire:model.live="sortBy" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="latest">Plus récentes</option>
                            <option value="urgent">Plus urgentes</option>
                            <option value="popular">Plus consultées</option>
                            <option value="expiring">Expire bientôt</option>
                        </select>
                    </div>
                </div>
            </div>
    
            <!-- Demands Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($demands as $demand)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 overflow-hidden group">
                        <!-- Header with Category Icon -->
                        <div class="bg-gradient-to-r from-primary-50 to-earth-50 p-4 border-b">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-4xl">{{ $demand->category->icon }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $demand->urgency_badge_color }}">
                                    @if($demand->urgency === 'high') 🔴 Urgente
                                    @elseif($demand->urgency === 'medium') 🟡 Moyenne
                                    @else 🟢 Normal
                                    @endif
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg line-clamp-2 mb-1">{{ $demand->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $demand->category->name }}</p>
                        </div>
    
                        <!-- Content -->
                        <div class="p-4">
                            <p class="text-gray-700 text-sm mb-4 line-clamp-3">{{ $demand->description }}</p>
    
                            <!-- Info Tags -->
                            <div class="space-y-2 mb-4">
                                @if($demand->quantity)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span class="font-medium">Quantité:</span>
                                        <span class="ml-1">{{ $demand->quantity }}</span>
                                    </div>
                                @endif
    
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">Lieu:</span>
                                    <span class="ml-1">{{ $demand->city }}, {{ $demand->region }}</span>
                                </div>
    
                                @if($demand->budget)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">Budget:</span>
                                        <span class="ml-1">{{ number_format($demand->budget, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                @endif
    
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">Expire:</span>
                                    <span class="ml-1">{{ $demand->validity_date->diffForHumans() }}</span>
                                </div>
                            </div>
    
                            <!-- Stats -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4 pb-4 border-b">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $demand->views_count }} vues
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                    </svg>
                                    {{ $demand->contacts_received }} réponses
                                </span>
                            </div>
    
                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <button wire:click="viewDetails({{ $demand->id }})"
                                        class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition text-sm">
                                    Voir détails
                                </button>
                                <button wire:click="openResponseModal({{ $demand->id }})"
                                        class="flex-1 px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 transition text-sm">
                                    Répondre
                                </button>
                            </div>
                        </div>
    
                        <!-- Demandeur Info -->
                        <div class="bg-gray-50 px-4 py-3 border-t flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($demand->user->name) }}&background=random" 
                                 class="w-8 h-8 rounded-full"
                                 alt="{{ $demand->user->name }}">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $demand->user->name }}</p>
                                <p class="text-xs text-gray-500">Publié {{ $demand->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune demande trouvée</h3>
                            <p class="text-gray-600">Essayez de modifier vos critères de recherche</p>
                        </div>
                    </div>
                @endforelse
            </div>
    
            <!-- Pagination -->
            <div class="mt-6">
                {{ $demands->links() }}
            </div>
        </div>
    
        <!-- Response Modal -->
        @if($showResponseModal && $selectedDemand)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showResponseModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" 
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
    
                    <div x-show="show" 
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl">
                        
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Répondre à la demande</h3>
                            <button wire:click="$set('showResponseModal', false)" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
    
                        <!-- Demand Info -->
                        <div class="bg-gradient-to-r from-primary-50 to-earth-50 rounded-xl p-4 mb-6">
                            <div class="flex items-start space-x-3">
                                <span class="text-3xl">{{ $selectedDemand->category->icon }}</span>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 mb-1">{{ $selectedDemand->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $selectedDemand->category->name }} • {{ $selectedDemand->city }}, {{ $selectedDemand->region }}</p>
                                    @if($selectedDemand->quantity)
                                        <p class="text-sm text-gray-700 mt-2"><strong>Quantité:</strong> {{ $selectedDemand->quantity }}</p>
                                    @endif
                                    @if($selectedDemand->budget)
                                        <p class="text-sm text-gray-700 mt-1"><strong>Budget max:</strong> {{ number_format($selectedDemand->budget, 0, ',', ' ') }} FCFA</p>
                                    @endif
                                </div>
                            </div>
                        </div>
    
                        <form wire:submit.prevent="submitResponse" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Votre proposition *</label>
                                <textarea wire:model="message"
                                          rows="5"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                          placeholder="Décrivez votre offre, vos conditions de livraison, etc. (minimum 20 caractères)"></textarea>
                                @error('message') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
    
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix proposé (FCFA)</label>
                                    <input type="number" 
                                           wire:model="proposed_price"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="Votre prix">
                                    @error('proposed_price') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
    
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone de contact</label>
                                    <input type="text" 
                                           wire:model="contact_phone"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                           placeholder="+237 6XX XX XX XX">
                                    @error('contact_phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
    
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email de contact</label>
                                <input type="email" 
                                       wire:model="contact_email"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                       placeholder="votre@email.com">
                                @error('contact_email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>
    
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-blue-800">
                                        Vos coordonnées seront partagées avec le demandeur. Assurez-vous qu'elles sont correctes.
                                    </p>
                                </div>
                            </div>
    
                            <div class="flex justify-end space-x-3 pt-4 border-t">
                                <button type="button" 
                                        wire:click="$set('showResponseModal', false)"
                                        class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                    Annuler
                                </button>
                                <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 shadow-lg transition">
                                    Envoyer ma proposition
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    
        <!-- Details Modal -->
        @if($showDetailsModal && $selectedDemand)
            <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: @entangle('showDetailsModal') }">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div x-show="show" 
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
    
                    <div x-show="show" 
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl max-h-[90vh] overflow-y-auto">
                        
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Détails de la demande</h3>
                            <button wire:click="$set('showDetailsModal', false)" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
    
                        <div class="space-y-6">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-primary-50 to-earth-50 rounded-xl p-6">
                                <div class="flex items-start space-x-4">
                                    <span class="text-5xl">{{ $selectedDemand->category->icon }}</span>
                                    <div class="flex-1">
                                        <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $selectedDemand->title }}</h4>
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $selectedDemand->urgency_badge_color }}">
                                                @if($selectedDemand->urgency === 'high') 🔴 Urgence haute
                                                @elseif($selectedDemand->urgency === 'medium') 🟡 Urgence moyenne
                                                @else 🟢 Urgence basse
                                                @endif
                                            </span>
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">
                                                👁️ {{ $selectedDemand->views_count }} vues
                                            </span>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">{{ $selectedDemand->description }}</p>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Catégorie</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->category->icon }} {{ $selectedDemand->category->name }}</p>
                                </div>
    
                                @if($selectedDemand->quantity)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Quantité</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->quantity }}</p>
                                </div>
                                @endif
    
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Localisation</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->city }}, {{ $selectedDemand->region }}</p>
                                </div>
    
                                @if($selectedDemand->budget)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Budget maximum</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ number_format($selectedDemand->budget, 0, ',', ' ') }} FCFA</p>
                                </div>
                                @endif
    
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Valide jusqu'au</span>
                                    </div>
                                    <p class="text-gray-900 font-semibold">{{ $selectedDemand->validity_date->format('d/m/Y') }} ({{ $selectedDemand->validity_date->diffForHumans() }})</p>
                                </div>
    
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center text-gray-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">Demandeur</span>
                                    </div>
                                    <div class="flex items-center space-x-2 mt-2">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedDemand->user->name) }}&background=random" 
                                             class="w-8 h-8 rounded-full"
                                             alt="{{ $selectedDemand->user->name }}">
                                        <span class="text-gray-900 font-semibold">{{ $selectedDemand->user->name }}</span>
                                    </div>
                                </div>
                            </div>
    
                            <!-- Action Button -->
                            <div class="bg-primary-50 border border-primary-200 rounded-xl p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div>
                                        <h5 class="font-bold text-gray-900 mb-1">Vous pouvez répondre à cette demande</h5>
                                        <p class="text-sm text-gray-600">Proposez vos produits ou services à {{ $selectedDemand->user->name }}</p>
                                    </div>
                                    <button wire:click="openResponseModal({{ $selectedDemand->id }})"
                                            class="px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 text-white font-semibold rounded-lg hover:from-primary-700 hover:to-primary-800 shadow-lg transition whitespace-nowrap">
                                        💬 Répondre maintenant
                                    </button>
                                </div>
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
                    title: data.type === 'success' ? 'Succès !' : data.type === 'error' ? 'Erreur !' : 'Information',
                    text: data.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });
            });
        });
    </script>
    @endpush
</div>
