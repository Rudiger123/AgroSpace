<div x-data.ignore="{ show : false }" x-cloak>

    <style>
        [x-cloak] {
            display: none;
        }
    </style>

    <button @click="show = true"
        class="px-4 py-2 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] 
          transition-all duration-200 transform hover:scale-105 shadow-soft hover:shadow-medium
          flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
            </path>
        </svg>
        <span>Modifier le profil</span>
    </button>

    {{-- resources/views/livewire/edit-profile-modal.blade.php --}}
    <div>
        <!-- Modal Overlay -->
        <div x-show="show" @click="show = !show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50"
            style="display: none;"></div>

        <!-- Modal Content -->
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"
            class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-strong max-w-2xl w-full overflow-hidden">
                    <!-- Header -->
                    <div
                        class="bg-gradient-to-r from-[#2E7D32] to-[#1B5E20] px-6 py-5 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white font-poppins">Modifier le profil</h2>
                                <p class="text-white/80 text-sm">Mettez à jour vos informations personnelles</p>
                            </div>
                        </div>
                        <button @click="show = !show" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Message Flash de Succès --}}
                    @if (session()->has('message'))
                        <x-flash-message>
                            {{ session('message') }}
                        </x-flash-message>
                    @endif

                    <!-- Form Content -->
                    <form wire:submit.prevent="save" class="p-6 space-y-6">

                        <!-- Photo Upload avec Aperçu -->
                        <div>
                            <label class="block text-sm font-medium text-[#37474F] mb-3">Photo de profil</label>

                            <div class="flex items-center space-x-6">
                                <!-- Aperçu actuel -->
                                <div class="relative">
                                    @if ($avatar)
                                        <img src="{{ $avatar->temporaryUrl() }}" alt="Preview"
                                            class="w-24 h-24 rounded-xl object-cover ring-4 ring-[#2E7D32]/20">
                                    @elseif ($currentAvatar)
                                        <img src="{{ Storage::url($currentAvatar) }}" alt="Current"
                                            class="w-24 h-24 rounded-xl object-cover ring-4 ring-[#2E7D32]/20">
                                    @else
                                        <div class="w-24 h-24 rounded-xl bg-[#F9F6EE] flex items-center justify-center">
                                            <svg class="w-12 h-12 text-[#37474F]/30" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Badge loading upload -->
                                    <div wire:loading wire:target="photo"
                                        class="absolute inset-0 bg-black/50 rounded-xl flex items-center justify-center">
                                        <svg class="animate-spin h-8 w-8 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Boutons d'upload -->
                                <div class="flex-1">
                                    <label class="cursor-pointer">
                                        <div
                                            class="px-4 py-2 bg-[#F9F6EE] border-2 border-dashed border-[#E0E0E0] rounded-lg hover:border-[#2E7D32] transition-colors text-center">
                                            <svg class="w-8 h-8 text-[#37474F]/40 mx-auto mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            <p class="text-sm text-[#37474F]">
                                                <span class="font-medium text-[#2E7D32]">Cliquez pour télécharger</span>
                                                <span class="text-[#37474F]/60"> ou glissez-déposez</span>
                                            </p>
                                            <p class="text-xs text-[#37474F]/60 mt-1">PNG, JPG jusqu'à 2MB</p>
                                        </div>
                                        <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                                    </label>
                                    @error('avatar')
                                        <p class="text-red-500 text-xs mt-2 flex items-center">
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
                        </div>

                        <!-- Grille de champs -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-[#37474F] mb-2">
                                    Nom complet <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="name" wire:model.live.debounce.300ms="name"
                                        class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                        @error('name') border-red-500 @else border-[#E0E0E0] @enderror"
                                        placeholder="Votre nom complet">
                                    <svg class="w-5 h-5 text-[#37474F]/40 absolute left-3 top-1/2 transform -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                @error('name')
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

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-[#37474F] mb-2">
                                    Adresse email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email" id="email" wire:model.live.debounce.300ms="email"
                                        class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all
                                        @error('email') border-red-500 @else border-[#E0E0E0] @enderror"
                                        placeholder="votre@email.com">
                                    <svg class="w-5 h-5 text-[#37474F]/40 absolute left-3 top-1/2 transform -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                        </path>
                                    </svg>
                                </div>
                                @error('email')
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
                            <!-- phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-[#37474F] mb-2">
                                    téléphone
                                </label>
                                <div class="relative">
                                    <input type="tel" id="activity" wire:model.live.debounce.300ms="phone"
                                        class="w-full pl-10 pr-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all"
                                        placeholder="+237 6XXXXXXX">
                                    <svg class="w-5 h-5 text-[#37474F]/40 absolute left-3 top-1/2 transform -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                            </div>


                            <!-- Localisation -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-[#37474F] mb-2">
                                    Localisation
                                </label>
                                <div class="relative">
                                    <input type="text" id="location" wire:model.live.debounce.300ms="location"
                                        class="w-full pl-10 pr-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all"
                                        placeholder="Ville, Pays">
                                    <svg class="w-5 h-5 text-[#37474F]/40 absolute left-3 top-1/2 transform -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- activity -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-[#37474F] mb-2">
                                    Activité principale
                                </label>
                                <div class="relative">
                                    <input type="text" id="activity" wire:model.live.debounce.300ms="activity"
                                        class="w-full pl-10 pr-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all"
                                        placeholder="Eleveur/ vendeur / commerçant">
                                    <svg class="w-5 h-5 text-[#37474F]/40 absolute left-3 top-1/2 transform -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <!-- biographie -->
                            <div class="col-span-1">
                                <label for="phone" class="block text-sm font-medium text-[#37474F] mb-2">
                                    Biographie
                                </label>
                                <div class="relative">
                                    <textarea id="bio" wire:model.live.debounce.300ms="bio"
                                        class="w-full pl-10 pr-4 py-3 border border-[#E0E0E0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#2E7D32] focus:border-transparent transition-all"
                                        placeholder="Je suis agriculteur dans la ville... depuis..."></textarea>
                                    <svg class="w-5 h-5 text-[#37474F]/40 absolute left-3 top-1/2 transform -translate-y-1/2"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Barre de progression de sauvegarde -->
                        <div wire:loading wire:target="save"
                            class="relative h-1 bg-[#F9F6EE] rounded-full overflow-hidden">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-[#2E7D32] to-[#4CAF50] animate-progress">
                            </div>
                        </div>

                        <!-- Footer Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-[#E0E0E0]">
                            <button type="button" @click="show = !show"
                                class="px-6 py-2.5 border border-[#E0E0E0] rounded-lg font-medium text-[#37474F] hover:bg-[#F9F6EE] transition-all duration-200">
                                Annuler
                            </button>

                            <button type="submit" wire:loading.attr="disabled" wire:target="save"
                                class="px-6 py-2.5 bg-[#2E7D32] text-white rounded-lg font-medium hover:bg-[#1B5E20] 
                                   transition-all duration-200 transform hover:scale-105 shadow-soft hover:shadow-medium
                                   disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none
                                   flex items-center space-x-2">
                                <svg wire:loading.remove wire:target="save" class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>

                                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>

                                <span wire:loading.remove wire:target="save">Enregistrer</span>
                                <span wire:loading wire:target="save">Enregistrement...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
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
    </style>
</div>
