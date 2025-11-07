<div x-data="{ activeTab: @entangle('activeTab') }" x-cloak>
    <div class="min-h-screen p-6">
        <!-- Header -->
        <div class="max-w-7xl mx-auto mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center space-x-3">
                        <span class="bg-primary-500 text-white p-2 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                        <span>Mon Profil</span>
                    </h1>
                    <p class="text-gray-500 mt-1">Gérez vos informations personnelles et vos préférences</p>
                </div>
                <a href="{{ route('dashboard') }}" wire:navigate
                    class="flex items-center space-x-2 text-gray-600 hover:text-primary-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Retour au dashboard</span>
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar avec navigation -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 glass-effect sticky top-6">

                        <!-- Photo de profil -->
                        <div class="text-center mb-6 relative" x-data="{ uploading: false }">
                            <div class="relative inline-block">
                                @if ($avatar)
                                    <img src="{{ Storage::url($avatar) }}" alt="Avatar"
                                        class="w-24 h-24 rounded-full object-cover mx-auto ring-4 ring-primary-100">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-3xl font-bold mx-auto ring-4 ring-primary-100">
                                        {{ substr($name, 0, 1) }}
                                    </div>
                                @endif

                                <label for="avatar-upload"
                                    class="absolute bottom-0 right-0 bg-primary-500 text-white p-2 rounded-full cursor-pointer hover:bg-primary-600 transition shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </label>
                                <input type="file" id="avatar-upload" wire:model="newAvatar"
                                    @change="uploading = true" accept="image/*" class="hidden">
                            </div>

                            <div x-show="uploading" class="mt-3">
                                <div class="flex items-center justify-center space-x-2">
                                    <div
                                        class="animate-spin rounded-full h-4 w-4 border-2 border-primary-500 border-t-transparent">
                                    </div>
                                    <span class="text-sm text-gray-600">Upload...</span>
                                </div>
                            </div>

                            @if ($newAvatar)
                                <button wire:click="updateAvatar"
                                    class="mt-3 bg-primary-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-primary-600 transition">
                                    Enregistrer la photo
                                </button>
                            @endif
                        </div>

                        <div class="text-center mb-6 border-b pb-4">
                            <h3 class="font-bold text-lg text-gray-800">{{ $name }}</h3>
                            <p class="text-sm text-gray-500">{{ $email }}</p>
                            <span
                                class="inline-block mt-2 px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-semibold">
                                {{ ucfirst(auth()->user()->role->name) }}
                            </span>
                        </div>

                        <!-- Navigation tabs -->
                        <nav class="space-y-2">
                            <button @click="activeTab = 'informations'"
                                :class="activeTab === 'informations' ? 'bg-primary-500 text-white' :
                                    'text-gray-600 hover:bg-gray-100'"
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">Informations</span>
                            </button>

                            <button @click="activeTab = 'statistiques'"
                                :class="activeTab === 'statistiques' ? 'bg-primary-500 text-white' :
                                    'text-gray-600 hover:bg-gray-100'"
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                <span class="font-medium">Statistiques</span>
                            </button>

                            <button @click="activeTab = 'securite'"
                                :class="activeTab === 'securite' ? 'bg-primary-500 text-white' :
                                    'text-gray-600 hover:bg-gray-100'"
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                <span class="font-medium">Sécurité</span>
                            </button>

                            <button @click="activeTab = 'activite'"
                                :class="activeTab === 'activite' ? 'bg-primary-500 text-white' :
                                    'text-gray-600 hover:bg-gray-100'"
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="font-medium">Activité</span>
                            </button>

                            <button @click="activeTab = 'danger'"
                                :class="activeTab === 'danger' ? 'bg-red-500 text-white' : 'text-red-600 hover:bg-red-50'"
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                                <span class="font-medium">Zone dangereuse</span>
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="lg:col-span-3">

                    <!-- Tab: Informations -->
                    <div x-show="activeTab === 'informations'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">

                        <div class="bg-white rounded-2xl shadow-lg p-8 glass-effect">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Informations personnelles</h2>
                                    <p class="text-sm text-gray-500">Gérez vos informations de profil</p>
                                </div>
                                @if (!$isEditing)
                                    <button wire:click="toggleEdit"
                                        class="flex items-center space-x-2 bg-primary-500 text-white px-4 py-2 rounded-xl hover:bg-primary-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        <span>Modifier</span>
                                    </button>
                                @endif
                            </div>

                            <form wire:submit.prevent="updateProfile" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <!-- Nom complet -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nom complet <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text" wire:model.defer="name"
                                                :disabled="!{{ $isEditing ? 'true' : 'false' }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('name')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Téléphone -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Téléphone
                                        </label>
                                        <div class="relative">
                                            <input type="tel" wire:model.defer="phone"
                                                :disabled="!{{ $isEditing ? 'true' : 'false' }}"
                                                placeholder="+237 6 90 12 34 56"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('phone')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Localisation -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Localisation
                                        </label>
                                        <div class="relative">
                                            <input type="text" wire:model.defer="location"
                                                :disabled="!{{ $isEditing ? 'true' : 'false' }}"
                                                placeholder="Douala, Littoral"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition disabled:bg-gray-100 disabled:cursor-not-allowed">
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('location')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email (lecture seule, modification via modal séparée) -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Email
                                        </label>
                                        <div class="relative">
                                            <input type="email" value="{{ $email }}" disabled
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-100 cursor-not-allowed">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                <button type="button" @click="$wire.set('activeTab', 'securite')"
                                                    class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                                    Modifier
                                                </button>
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Pour modifier votre email, rendez-vous
                                            dans l'onglet Sécurité</p>
                                    </div>
                                </div>

                                <!-- Bio -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Biographie
                                    </label>
                                    <textarea wire:model.defer="bio" :disabled="!{{ $isEditing ? 'true' : 'false' }}" rows="4"
                                        placeholder="Parlez-nous de vous..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition disabled:bg-gray-100 disabled:cursor-not-allowed"></textarea>
                                    @error('bio')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">Maximum 500 caractères</p>
                                </div>

                                @if ($isEditing)
                                    <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                                        <button type="button" wire:click="toggleEdit"
                                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition">
                                            Annuler
                                        </button>
                                        <button type="submit"
                                            class="px-6 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition flex items-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Enregistrer les modifications</span>
                                        </button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Tab: Statistiques -->
                    <div x-show="activeTab === 'statistiques'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">

                        <div class="bg-white rounded-2xl shadow-lg p-8 glass-effect">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Mes statistiques</h2>

                            @if (auth()->user()->isProducer())
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div
                                        class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl p-6 text-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="bg-white/20 p-3 rounded-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-3xl font-bold">{{ $stats['total_offers'] ?? 0 }}</span>
                                        </div>
                                        <p class="text-white/90">Offres totales</p>
                                        <p class="text-xs text-white/70 mt-1">{{ $stats['active_offers'] ?? 0 }}
                                            actives</p>
                                    </div>

                                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="bg-white/20 p-3 rounded-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <span
                                                class="text-3xl font-bold">{{ $stats['conversion_rate'] ?? 0 }}%</span>
                                        </div>
                                        <p class="text-white/90">Taux de conversion</p>
                                        <p class="text-xs text-white/70 mt-1">{{ $stats['completed_offers'] ?? 0 }}
                                            finalisées</p>
                                    </div>

                                    <div
                                        class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-6 text-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="bg-white/20 p-3 rounded-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-3xl font-bold">{{ $stats['total_views'] ?? 0 }}</span>
                                        </div>
                                        <p class="text-white/90">Vues totales</p>
                                        <p class="text-xs text-white/70 mt-1">{{ $stats['total_contacts'] ?? 0 }}
                                            contacts</p>
                                    </div>
                                </div>
                            @elseif(auth()->user()->isConsumer())
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div
                                        class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="bg-white/20 p-3 rounded-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-3xl font-bold">{{ $stats['total_demands'] ?? 0 }}</span>
                                        </div>
                                        <p class="text-white/90">Demandes totales</p>
                                        <p class="text-xs text-white/70 mt-1">{{ $stats['active_demands'] ?? 0 }}
                                            actives</p>
                                    </div>

                                    <div
                                        class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="bg-white/20 p-3 rounded-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <span
                                                class="text-3xl font-bold">{{ $stats['fulfillment_rate'] ?? 0 }}%</span>
                                        </div>
                                        <p class="text-white/90">Taux de satisfaction</p>
                                        <p class="text-xs text-white/70 mt-1">{{ $stats['fulfilled_demands'] ?? 0 }}
                                            satisfaites</p>
                                    </div>

                                    <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl p-6 text-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="bg-white/20 p-3 rounded-lg">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                            </div>
                                            <span
                                                class="text-3xl font-bold">{{ $stats['matching_rate'] ?? 0 }}%</span>
                                        </div>
                                        <p class="text-white/90">Taux de matching</p>
                                        <p class="text-xs text-white/70 mt-1">Correspondances trouvées</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tab: Sécurité -->
                    <div x-show="activeTab === 'securite'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">

                        <!-- Changement de mot de passe -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 glass-effect">
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center space-x-2">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                    </path>
                                </svg>
                                <span>Modifier le mot de passe</span>
                            </h3>

                            <form wire:submit.prevent="updatePassword" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Mot de passe actuel <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" wire:model.defer="current_password"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-12">
                                        <button type="button" @click="show = !show"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg x-show="!show" class="w-5 h-5 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <svg x-show="show" class="w-5 h-5 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nouveau mot de passe <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative" x-data="{ show: false }">
                                        <input :type="show ? 'text' : 'password'" wire:model.defer="new_password"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 pr-12">
                                        <button type="button" @click="show = !show"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg x-show="!show" class="w-5 h-5 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <svg x-show="show" class="w-5 h-5 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" wire:model.defer="new_password_confirmation"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                </div>

                                <button type="submit"
                                    class="w-full bg-primary-500 text-white py-3 rounded-xl hover:bg-primary-600 transition font-medium">
                                    Mettre à jour le mot de passe
                                </button>
                            </form>
                        </div>

                        <!-- Changement d'email -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 glass-effect">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center space-x-2">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Modifier l'adresse email</span>
                            </h3>
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-yellow-700 font-medium">Attention</p>
                                        <p class="text-sm text-yellow-600">La modification de votre email vous
                                            déconnectera. Vous devrez vérifier votre nouveau email avant de vous
                                            reconnecter.</p>
                                    </div>
                                </div>
                            </div>

                            <form wire:submit.prevent="updateEmail" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Email actuel
                                    </label>
                                    <input type="email" value="{{ $email }}" disabled
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-100 cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nouvel email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" wire:model.defer="new_email"
                                        placeholder="nouveau@email.com"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    @error('new_email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Confirmer avec votre mot de passe <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" wire:model.defer="email_password"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    @error('email_password')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="w-full bg-primary-500 text-white py-3 rounded-xl hover:bg-primary-600 transition font-medium">
                                    Modifier l'email
                                </button>
                            </form>
                        </div>

                        <!-- Authentification à deux facteurs (2FA) -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 glass-effect">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 flex items-center space-x-2">
                                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                        <span>Authentification à deux facteurs</span>
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">Sécurisez votre compte avec une couche
                                        supplémentaire de protection</p>
                                </div>
                                <div class="flex items-center">
                                    @if ($twoFactorEnabled)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Activée
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Désactivée
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if (!$twoFactorEnabled)
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-blue-400 mr-3" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm text-blue-700">L'authentification à deux facteurs ajoute
                                                une couche de sécurité supplémentaire en demandant un code à chaque
                                                connexion.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Formulaire activation 2FA -->
                                <form wire:submit.prevent="enable2FA" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirmer avec votre mot de passe <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" wire:model.defer="twofa_password"
                                            placeholder="Entrez votre mot de passe"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        @error('twofa_password')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-primary-500 text-white py-3 rounded-xl hover:bg-primary-600 transition font-medium flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        <span>Activer l'authentification à deux facteurs</span>
                                    </button>
                                </form>
                            @else
                                <!-- QR Code et codes de récupération -->
                                @if ($qrCode)
                                    <div class="space-y-6">
                                        <div class="bg-gray-50 rounded-xl p-6 text-center">
                                            <p class="text-sm text-gray-700 mb-4">Scannez ce QR code avec votre
                                                application d'authentification (Google Authenticator, Authy, etc.)</p>
                                            <div class="inline-block bg-white p-4 rounded-lg shadow-sm">
                                                {!! $qrCodeSvg !!}
                                            </div>
                                        </div>

                                        <!-- Codes de récupération -->
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                                            <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                                    </path>
                                                </svg>
                                                Codes de récupération
                                            </h4>
                                            <p class="text-sm text-gray-700 mb-4">Conservez ces codes en lieu sûr. Ils
                                                vous permettront de vous connecter si vous perdez l'accès à votre
                                                application d'authentification.</p>

                                            <div class="grid grid-cols-2 gap-2 mb-4">
                                                @foreach ($recoveryCodes as $code)
                                                    <div
                                                        class="bg-white px-4 py-2 rounded-lg font-mono text-sm text-gray-800 border">
                                                        {{ $code }}
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Boutons d'export -->
                                            <div class="flex flex-wrap gap-2">
                                                <button wire:click="exportRecoveryCodes('csv')"
                                                    class="flex items-center space-x-2 bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                                                        </path>
                                                    </svg>
                                                    <span>CSV</span>
                                                </button>
                                                <button wire:click="exportRecoveryCodes('md')"
                                                    class="flex items-center space-x-2 bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                                                        </path>
                                                    </svg>
                                                    <span>Markdown</span>
                                                </button>
                                                <button wire:click="exportRecoveryCodes('pdf')"
                                                    class="flex items-center space-x-2 bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                                                        </path>
                                                    </svg>
                                                    <span>PDF</span>
                                                </button>
                                                <button wire:click="exportRecoveryCodes('xlsx')"
                                                    class="flex items-center space-x-2 bg-white border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10">
                                                        </path>
                                                    </svg>
                                                    <span>Excel</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Bouton désactivation -->
                                <button wire:click="disable2FA"
                                    class="w-full bg-red-500 text-white py-3 rounded-xl hover:bg-red-600 transition font-medium mt-6">
                                    Désactiver l'authentification à deux facteurs
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Tab: Activité -->
                    <div x-show="activeTab === 'activite'" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0">

                        <div class="bg-white rounded-2xl shadow-lg p-8 glass-effect">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6">Historique d'activité</h2>

                            <!-- Statistiques de connexion -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-6 text-white">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="bg-white/20 p-3 rounded-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                                </path>
                                            </svg>
                                        </div>
                                        <span
                                            class="text-3xl font-bold">{{ $activityStats['total_logins'] ?? 0 }}</span>
                                    </div>
                                    <p class="text-white/90">Connexions ce mois</p>
                                    <p class="text-xs text-white/70 mt-1">30 derniers jours</p>
                                </div>

                                <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl p-6 text-white">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="bg-white/20 p-3 rounded-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-lg font-bold">
                                            @if (isset($activityStats['last_login']))
                                                {{ $activityStats['last_login']->diffForHumans() }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-white/90">Dernière connexion</p>
                                    <p class="text-xs text-white/70 mt-1">
                                        @if (isset($activityStats['last_login']))
                                            {{ $activityStats['last_login']->format('d/m/Y H:i') }}
                                        @endif
                                    </p>
                                </div>

                                <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl p-6 text-white">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="bg-white/20 p-3 rounded-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="text-3xl font-bold">
                                            @if (isset($activityStats['logins_by_day']))
                                                {{ count($activityStats['logins_by_day']) }}
                                            @else
                                                0
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-white/90">Jours actifs</p>
                                    <p class="text-xs text-white/70 mt-1">Ce mois</p>
                                </div>
                            </div>

                            <!-- Graphique d'activité -->
                            @if (isset($activityStats['logins_by_day']) && count($activityStats['logins_by_day']) > 0)
                                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                                    <h3 class="font-bold text-gray-800 mb-4">Activité des 30 derniers jours</h3>
                                    <div class="flex items-end justify-between h-48 space-x-1">
                                        @php
                                            $maxLogins = max($activityStats['logins_by_day']);
                                        @endphp
                                        @foreach (array_slice($activityStats['logins_by_day'], -30, 30, true) as $date => $count)
                                            <div class="flex-1 flex flex-col items-center space-y-2">
                                                <div class="w-full bg-primary-500 rounded-t hover:bg-primary-600 transition cursor-pointer relative group"
                                                    style="height: {{ $maxLogins > 0 ? ($count / $maxLogins) * 100 : 0 }}%">
                                                    <div
                                                        class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap z-10">
                                                        {{ $count }} connexion{{ $count > 1 ? 's' : '' }}
                                                        <br>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                                @if ($loop->index % 5 == 0)
                                                    <span
                                                        class="text-xs text-gray-500 transform -rotate-45 origin-top-left">
                                                        {{ \Carbon\Carbon::parse($date)->format('d/m') }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Timeline des activités récentes -->
                            <div>
                                <h3 class="font-bold text-gray-800 mb-4">Activités récentes</h3>
                                <div class="space-y-4">
                                    @forelse(auth()->user()->activityLogs()->latest()->take(10)->get() as $log)
                                        <div
                                            class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                            <div class="flex-shrink-0">
                                                @switch($log->type)
                                                    @case('login')
                                                        <div class="bg-green-100 p-2 rounded-lg">
                                                            <svg class="w-5 h-5 text-green-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @break

                                                    @case('profile_update')
                                                        <div class="bg-blue-100 p-2 rounded-lg">
                                                            <svg class="w-5 h-5 text-blue-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @break

                                                    @case('password_change')
                                                        <div class="bg-amber-100 p-2 rounded-lg">
                                                            <svg class="w-5 h-5 text-amber-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @break

                                                    @case('2fa_enabled')
                                                        <div class="bg-purple-100 p-2 rounded-lg">
                                                            <svg class="w-5 h-5 text-purple-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @break

                                                    @default
                                                        <div class="bg-gray-100 p-2 rounded-lg">
                                                            <svg class="w-5 h-5 text-gray-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                @endswitch
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-800">{{ $log->description }}
                                                </p>
                                                <div class="flex items-center space-x-4 mt-1">
                                                    <p class="text-xs text-gray-500">
                                                        {{ $log->created_at->diffForHumans() }}</p>
                                                    @if ($log->ip_address)
                                                        <span class="text-xs text-gray-400">• IP:
                                                            {{ $log->ip_address }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                            <div class="text-center py-8 text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <p>Aucune activité enregistrée</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Zone dangereuse -->
                        <div x-show="activeTab === 'danger'" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0">

                            <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-red-200">
                                <div class="flex items-center space-x-3 mb-6">
                                    <div class="bg-red-100 p-3 rounded-xl">
                                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-red-600">Zone dangereuse</h2>
                                        <p class="text-sm text-gray-600">Ces actions sont irréversibles</p>
                                    </div>
                                </div>

                                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <h3 class="text-sm font-medium text-red-800">Attention</h3>
                                            <p class="text-sm text-red-700 mt-1">
                                                La suppression de votre compte entraînera la perte définitive de :
                                            </p>
                                            <ul class="list-disc list-inside text-sm text-red-600 mt-2 space-y-1">
                                                <li>Toutes vos informations personnelles</li>
                                                <li>Vos offres et demandes publiées</li>
                                                <li>Votre historique d'activité</li>
                                                <li>Vos messages et conversations</li>
                                                <li>Vos statistiques</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-2 border-red-200 rounded-xl p-6">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4">Supprimer mon compte</h3>
                                    <p class="text-sm text-gray-600 mb-6">
                                        Une fois votre compte supprimé, toutes vos données seront définitivement effacées.
                                        Cette action est irréversible.
                                    </p>

                                    <form wire:submit.prevent="confirmDelete" class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Confirmez avec votre mot de passe <span class="text-red-500">*</span>
                                            </label>
                                            <input type="password" wire:model.defer="delete_password"
                                                placeholder="Entrez votre mot de passe pour confirmer"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                            @error('delete_password')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="w-full bg-red-600 text-white py-3 rounded-xl hover:bg-red-700 transition font-medium flex items-center justify-center space-x-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            <span>Supprimer définitivement mon compte</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Toast notifications -->
        @push('scripts')
            <script>
                // Écouter l'événement profile-updated pour rafraîchir globalement
                Livewire.on('profile-updated', () => {
                    // Rafraîchir les données du profil dans toute l'application
                    location.reload();
                });
            </script>
        @endpush
    </div>
    </div>
