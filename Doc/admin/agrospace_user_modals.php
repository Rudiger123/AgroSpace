{{-- resources/views/livewire/admin/modals/create-edit-user-modal.blade.php --}}
<div x-data="{ show: @entangle('show') }" 
     x-show="show" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="$wire.close()"></div>
    
    {{-- Modal --}}
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-6 py-5 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">
                                {{ $userId ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur' }}
                            </h3>
                            <p class="text-sm text-green-100">{{ $userId ? 'Mettez à jour les informations' : 'Créez un nouveau compte utilisateur' }}</p>
                        </div>
                    </div>
                    <button @click="$wire.close()" class="text-white hover:bg-white/20 rounded-lg p-2 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <form wire:submit="save" class="p-6 space-y-6">
                
                {{-- Avatar Upload --}}
                <div class="flex flex-col items-center">
                    <div class="relative group">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-24 h-24 rounded-full ring-4 ring-green-100 object-cover" alt="Avatar">
                        @elseif($currentAvatar)
                            <img src="{{ $currentAvatar }}" class="w-24 h-24 rounded-full ring-4 ring-green-100 object-cover" alt="Avatar">
                        @else
                            <div class="w-24 h-24 rounded-full ring-4 ring-green-100 bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <label class="absolute bottom-0 right-0 bg-green-600 hover:bg-green-700 text-white rounded-full p-2 cursor-pointer shadow-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                        </label>
                    </div>
                    @error('avatar') 
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Grid 2 colonnes --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    {{-- Nom complet --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            wire:model="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="Ex: Jean Kouam"
                        >
                        @error('name') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Adresse email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            wire:model="email"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="email@example.com"
                        >
                        @error('email') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    {{-- Téléphone --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Téléphone <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            wire:model="phone"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="+237 690 123 456"
                        >
                        @error('phone') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    {{-- Rôle --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Rôle <span class="text-red-500">*</span>
                        </label>
                        <select 
                            wire:model="role"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                        >
                            <option value="">Sélectionner un rôle</option>
                            <option value="producer">👨‍🌾 Producteur</option>
                            <option value="consumer">🛒 Consommateur</option>
                            <option value="admin">👨‍💼 Administrateur</option>
                        </select>
                        @error('role') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    {{-- Région --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Région <span class="text-red-500">*</span>
                        </label>
                        <select 
                            wire:model="region"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                        >
                            <option value="">Sélectionner une région</option>
                            @foreach(['Adamaoua', 'Centre', 'Est', 'Extrême-Nord', 'Littoral', 'Nord', 'Nord-Ouest', 'Ouest', 'Sud', 'Sud-Ouest'] as $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                        @error('region') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    {{-- Ville --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Ville <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            wire:model="city"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="Ex: Douala"
                        >
                        @error('city') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                {{-- Biographie --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Biographie
                    </label>
                    <textarea 
                        wire:model="bio"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition resize-none"
                        placeholder="Décrivez l'activité de l'utilisateur..."
                    ></textarea>
                    @error('bio') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Statut --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Statut du compte
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative flex items-center justify-center px-4 py-3 border-2 rounded-lg cursor-pointer transition hover:border-green-500"
                               :class="$wire.status === 'active' ? 'border-green-500 bg-green-50' : 'border-gray-300'">
                            <input type="radio" wire:model="status" value="active" class="sr-only">
                            <span class="text-sm font-medium" :class="$wire.status === 'active' ? 'text-green-700' : 'text-gray-700'">
                                ✓ Actif
                            </span>
                        </label>
                        
                        <label class="relative flex items-center justify-center px-4 py-3 border-2 rounded-lg cursor-pointer transition hover:border-orange-500"
                               :class="$wire.status === 'suspended' ? 'border-orange-500 bg-orange-50' : 'border-gray-300'">
                            <input type="radio" wire:model="status" value="suspended" class="sr-only">
                            <span class="text-sm font-medium" :class="$wire.status === 'suspended' ? 'text-orange-700' : 'text-gray-700'">
                                ⏸ Suspendu
                            </span>
                        </label>
                        
                        <label class="relative flex items-center justify-center px-4 py-3 border-2 rounded-lg cursor-pointer transition hover:border-red-500"
                               :class="$wire.status === 'banned' ? 'border-red-500 bg-red-50' : 'border-gray-300'">
                            <input type="radio" wire:model="status" value="banned" class="sr-only">
                            <span class="text-sm font-medium" :class="$wire.status === 'banned' ? 'text-red-700' : 'text-gray-700'">
                                ⛔ Banni
                            </span>
                        </label>
                    </div>
                    @error('status') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Mot de passe (création uniquement) --}}
                @if(!$userId)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            wire:model="password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="••••••••"
                        >
                        @error('password') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmer le mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="password" 
                            wire:model="password_confirmation"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"
                            placeholder="••••••••"
                        >
                    </div>
                </div>
                @endif

                {{-- Vérification email --}}
                <div class="flex items-center space-x-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <input 
                        type="checkbox" 
                        wire:model="emailVerified"
                        id="emailVerified"
                        class="w-5 h-5 text-green-600 rounded focus:ring-green-500"
                    >
                    <label for="emailVerified" class="text-sm font-medium text-blue-900 cursor-pointer">
                        Marquer l'email comme vérifié
                    </label>
                </div>

                {{-- Footer Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <button 
                        type="button"
                        @click="$wire.close()"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition"
                    >
                        Annuler
                    </button>
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl font-semibold hover:shadow-lg transition flex items-center gap-2"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>
                            {{ $userId ? 'Mettre à jour' : 'Créer l\'utilisateur' }}
                        </span>
                        <span wire:loading>
                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>