<div class="min-h-screen bg-gray-50 py-8" x-data="{ activeTab: @entangle('activeTab') }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Paramètres</h1>
            <p class="text-gray-600 mt-2">Gérez vos préférences et paramètres de compte</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Navigation latérale -->
            <div class="lg:col-span-1">
                <nav class="space-y-1 bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                    <button @click="activeTab = 'notifications'" 
                            :class="activeTab === 'notifications' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg' 
                                : 'text-gray-700 hover:bg-gray-100'"
                            class="w-full text-left px-4 py-3 rounded-xl font-medium transition-all duration-200 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.93 4.93l9.07 9.07-9.07 9.07L4.93 4.93z"/>
                        </svg>
                        Notifications
                    </button>

                    <button @click="activeTab = 'preferences'" 
                            :class="activeTab === 'preferences' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg' 
                                : 'text-gray-700 hover:bg-gray-100'"
                            class="w-full text-left px-4 py-3 rounded-xl font-medium transition-all duration-200 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Préférences
                    </button>

                </nav>
            </div>

            <!-- Contenu principal -->
            <div class="lg:col-span-3">
                
                <!-- Section Notifications -->
                <div x-show="activeTab === 'notifications'" x-cloak class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.93 4.93l9.07 9.07-9.07 9.07L4.93 4.93z"/>
                            </svg>
                            Paramètres de notifications
                        </h2>

                        <div class="space-y-6">
                            <!-- Canaux de notification -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Canaux de réception</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="flex items-center space-x-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition">
                                        <input type="checkbox" wire:model="email_notifications" class="rounded text-green-600 focus:ring-green-500">
                                        <div>
                                            <span class="font-medium text-gray-700">Email</span>
                                            <p class="text-sm text-gray-500">Recevoir par email</p>
                                        </div>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition">
                                        <input type="checkbox" wire:model="push_notifications" class="rounded text-green-600 focus:ring-green-500">
                                        <div>
                                            <span class="font-medium text-gray-700">Push</span>
                                            <p class="text-sm text-gray-500">Notifications navigateur</p>
                                        </div>
                                    </label>

                                    <label class="flex items-center space-x-3 p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition">
                                        <input type="checkbox" wire:model="sms_notifications" class="rounded text-green-600 focus:ring-green-500">
                                        <div>
                                            <span class="font-medium text-gray-700">SMS</span>
                                            <p class="text-sm text-gray-500">Messages texte</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Types de notifications -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Types de notifications</h3>
                                <div class="space-y-3">
                                    @foreach ([
                                        ['key' => 'notify_new_offers', 'label' => 'Nouvelles offres', 'desc' => 'Nouvelles offres publiées'],
                                        ['key' => 'notify_new_demands', 'label' => 'Nouvelles demandes', 'desc' => 'Nouvelles demandes créées'],
                                        ['key' => 'notify_articles', 'label' => 'Articles', 'desc' => 'Nouveaux articles du blog'],
                                        ['key' => 'notify_chat_messages', 'label' => 'Messages', 'desc' => 'Nouveaux messages de chat'],
                                        ['key' => 'notify_admin_alerts', 'label' => 'Alertes admin', 'desc' => 'Notifications importantes']
                                    ] as $notification)
                                        <label class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition">
                                            <div class="flex items-center space-x-3">
                                                <input type="checkbox" wire:model="{{ $notification['key'] }}" 
                                                       class="rounded text-green-600 focus:ring-green-500">
                                                <div>
                                                    <span class="font-medium text-gray-700">{{ $notification['label'] }}</span>
                                                    <p class="text-sm text-gray-500">{{ $notification['desc'] }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button wire:click="savePreferences" 
                                        wire:loading.attr="disabled"
                                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 disabled:opacity-50 flex items-center gap-2">
                                    <span wire:loading.remove>Sauvegarder</span>
                                    <span wire:loading>
                                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Sauvegarde...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Préférences -->
                <div x-show="activeTab === 'preferences'" x-cloak class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Préférences générales
                        </h2>

                        <form wire:submit="savePreferences" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Langue</label>
                                    <select wire:model="language" 
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                        <option value="fr">Français</option>
                                        <option value="en">English</option>
                                        <option value="es">Español</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Fuseau horaire</label>
                                    <select wire:model="timezone" 
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                        @foreach (timezone_identifiers_list() as $tz)
                                            <option value="{{ $tz }}">{{ $tz }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Devise</label>
                                    <select wire:model="currency" 
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                        <option value="XAF">FCFA (XAF)</option>
                                        <option value="EUR">Euro (EUR)</option>
                                        <option value="USD">Dollar US (USD)</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Thème</label>
                                    <select wire:model="theme" 
                                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                                        <option value="light">Clair</option>
                                        <option value="dark">Sombre</option>
                                        <option value="system">Système</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" wire:model="compact_view" class="rounded text-green-600 focus:ring-green-500">
                                    <span class="font-medium text-gray-700">Vue compacte</span>
                                    <span class="text-sm text-gray-500">Afficher plus d'éléments par page</span>
                                </label>

                                <label class="flex items-center space-x-3">
                                    <input type="checkbox" wire:model="show_tutorials" class="rounded text-green-600 focus:ring-green-500">
                                    <span class="font-medium text-gray-700">Tutoriels</span>
                                    <span class="text-sm text-gray-500">Afficher les guides et astuces</span>
                                </label>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 disabled:opacity-50 flex items-center gap-2">
                                    <span wire:loading.remove>Sauvegarder</span>
                                    <span wire:loading>
                                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Sauvegarde...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>