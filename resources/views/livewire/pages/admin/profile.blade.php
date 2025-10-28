<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
    use WithFileUploads;

    public $role;
    public $name;
    public $email;
    public $bio;
    public $location;
    public $activity;
    public $avatar;
    public $created;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->bio = $user->bio;
        $this->location = $user->location;
        $this->activity = $user->activity;
        $this->avatar = $user->avatar;
        $this->role = $user->role->name;
        $this->email = $user->email;
        $this->created = $user->created_at;
    }
};
?>
<div>
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm mb-6">
            <a href="/dashboard" class="text-[#37474F]/60 hover:text-[#2E7D32] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 text-[#37474F]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-[#2E7D32] font-medium">Mon Profil</span>
        </nav>

        <!-- Header de profil avec bannière -->
        <div class="relative mb-8">
            <!-- Bannière -->
            <div
                class="h-48 bg-gradient-to-r from-[#2E7D32] via-[#388E3C] to-[#1B5E20] rounded-t-2xl relative overflow-hidden">
                <!-- Pattern décoratif -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                </div>
            </div>

            <!-- Carte profil -->
            <div class="max-w-5xl mx-auto px-6">
                <div class="bg-white rounded-2xl shadow-strong -mt-24 relative p-6">
                    <div class="flex items-start justify-between">
                        <!-- Photo et infos -->
                        <div class="flex items-start space-x-6">
                            <!-- Photo avec badge statut -->
                            <div class="relative">
                                <img src="{{ Storage::url($avatar) }}" alt="Profile"
                                    class="w-32 h-32 rounded-2xl ring-4 ring-white shadow-medium">
                                <!-- Badge statut en ligne -->
                                <div
                                    class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-white rounded-full">
                                </div>
                            </div>

                            <div class="pt-4">
                                <h1 class="text-3xl font-bold text-[#37474F] font-poppins"> {{ $name }} </h1>
                                <p class="text-[#37474F]/60 mt-1"> {{ $email }} </p>

                                <div class="flex items-center space-x-4 mt-4">
                                    <!-- Badge rôle -->
                                    <span
                                        class="px-3 py-1 bg-[#2E7D32]/10 text-[#2E7D32] rounded-lg text-sm font-medium flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                        <span>{{ $role }}</span>
                                    </span>

                                    <!-- Membre depuis -->
                                    <span class="text-sm text-[#37474F]/60 flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>Membre depuis {{ $created->format('d/m/Y') }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons actions -->
                        <div class="flex items-center space-x-3">
                            @livewire('admin.forms.edit-profile-modal')

                            <button class="p-2 rounded-lg hover:bg-[#F9F6EE] transition-colors">
                                <svg class="w-6 h-6 text-[#37474F]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="max-w-5xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne gauche - Stats -->
                <div class="space-y-6">
                    <!-- Statistiques personnelles -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-[#37474F] font-poppins mb-4">Statistiques</h3>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-[#37474F]/60">Offres publiées</span>
                                <span class="text-lg font-bold text-[#2E7D32]">24</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-[#37474F]/60">Projets créés</span>
                                <span class="text-lg font-bold text-[#2E7D32]">12</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-[#37474F]/60">Événements</span>
                                <span class="text-lg font-bold text-[#2E7D32]">8</span>
                            </div>
                        </div>

                        <!-- Graphique mini -->
                        <div class="mt-6 pt-6 border-t border-[#E0E0E0]">
                            <p class="text-xs text-[#37474F]/60 mb-3">Activité (30 derniers jours)</p>
                            <div class="flex items-end justify-between h-16 space-x-1">
                                <div class="flex-1 bg-[#2E7D32]/20 rounded-t hover:bg-[#2E7D32]/40 transition-colors"
                                    style="height: 40%"></div>
                                <div class="flex-1 bg-[#2E7D32]/20 rounded-t hover:bg-[#2E7D32]/40 transition-colors"
                                    style="height: 60%"></div>
                                <div class="flex-1 bg-[#2E7D32]/20 rounded-t hover:bg-[#2E7D32]/40 transition-colors"
                                    style="height: 80%"></div>
                                <div class="flex-1 bg-[#2E7D32]/20 rounded-t hover:bg-[#2E7D32]/40 transition-colors"
                                    style="height: 50%"></div>
                                <div class="flex-1 bg-[#2E7D32] rounded-t hover:bg-[#1B5E20] transition-colors"
                                    style="height: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="bg-white rounded-xl shadow-soft p-6">
                        <h3 class="text-lg font-semibold text-[#37474F] font-poppins mb-4">Actions rapides</h3>

                        <div class="space-y-2">
                            <button
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#F9F6EE] transition-colors text-left">
                                <div class="w-8 h-8 bg-[#2E7D32]/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-[#2E7D32]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-[#37474F]">Créer une offre</span>
                            </button>

                            <button
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#F9F6EE] transition-colors text-left">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-[#37474F]">Planifier un événement</span>
                            </button>

                            <button
                                class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-[#F9F6EE] transition-colors text-left">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-[#37474F]">Générer un rapport</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite - Informations détaillées -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Tabs navigation -->
                    <div x-data.ignore="{ activeTab: 'overview' }"
                        class="bg-white rounded-xl shadow-soft overflow-hidden">
                        <!-- Tabs header -->
                        <div class="flex border-b border-[#E0E0E0]">
                            <button @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ? 'border-b-2 border-[#2E7D32] text-[#2E7D32]' :
                                    'text-[#37474F]/60 hover:text-[#37474F]'"
                                class="flex-1 px-6 py-4 font-medium transition-colors relative">
                                Aperçu
                            </button>
                            <button @click="activeTab = 'activity'"
                                :class="activeTab === 'activity' ? 'border-b-2 border-[#2E7D32] text-[#2E7D32]' :
                                    'text-[#37474F]/60 hover:text-[#37474F]'"
                                class="flex-1 px-6 py-4 font-medium transition-colors">
                                Activité
                            </button>
                            <button @click="activeTab = 'security'"
                                :class="activeTab === 'security' ? 'border-b-2 border-[#2E7D32] text-[#2E7D32]' :
                                    'text-[#37474F]/60 hover:text-[#37474F]'"
                                class="flex-1 px-6 py-4 font-medium transition-colors">
                                Sécurité
                            </button>
                        </div>

                        <!-- Tabs content -->
                        <div class="p-6">
                            <!-- Overview -->
                            <div x-show="activeTab === 'overview'" x-transition>
                                <h3 class="text-lg font-semibold text-[#37474F] font-poppins mb-4">Informations du
                                    compte</h3>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between py-3 border-b border-[#E0E0E0]">
                                        <span class="text-sm text-[#37474F]/60">Nom complet</span>
                                        <span class="text-sm font-medium text-[#37474F]"> {{ $name }} </span>
                                    </div>
                                    <div class="flex items-center justify-between py-3 border-b border-[#E0E0E0]">
                                        <span class="text-sm text-[#37474F]/60">Email</span>
                                        <span class="text-sm font-medium text-[#37474F]"> {{ $email }} </span>
                                    </div>
                                    <div class="flex items-center justify-between py-3 border-b border-[#E0E0E0]">
                                        <span class="text-sm text-[#37474F]/60">Téléphone</span>
                                        <span class="text-sm font-medium text-[#37474F]">+237 6 XX XX XX XX</span>
                                    </div>
                                    <div class="flex items-center justify-between py-3 border-b border-[#E0E0E0]">
                                        <span class="text-sm text-[#37474F]/60">Localisation</span>
                                        <span class="text-sm font-medium text-[#37474F]"> {{ $location }} </span>
                                    </div>
                                    <div class="flex items-center justify-between py-3">
                                        <span class="text-sm text-[#37474F]/60">Date d'inscription</span>
                                        <span class="text-sm font-medium text-[#37474F]"> {{ $created }} </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity -->
                            <div x-show="activeTab === 'activity'" x-transition>
                                <h3 class="text-lg font-semibold text-[#37474F] font-poppins mb-4">Activité récente
                                </h3>

                                <div class="space-y-4">
                                    <div
                                        class="flex items-start space-x-3 p-3 rounded-lg hover:bg-[#F9F6EE] transition-colors">
                                        <div
                                            class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-[#37474F]">Offre publiée</p>
                                            <p class="text-xs text-[#37474F]/60 mt-1">Il y a 2 heures</p>
                                        </div>
                                    </div>

                                    <div
                                        class="flex items-start space-x-3 p-3 rounded-lg hover:bg-[#F9F6EE] transition-colors">
                                        <div
                                            class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-[#37474F]">Profil mis à jour</p>
                                            <p class="text-xs text-[#37474F]/60 mt-1">Il y a 1 jour</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security -->
                            <div x-show="activeTab === 'security'" x-transition>
                                <h3 class="text-lg font-semibold text-[#37474F] font-poppins mb-4">Paramètres de
                                    sécurité</h3>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-[#F9F6EE] rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-[#37474F]">Authentification à deux
                                                facteurs</p>
                                            <p class="text-xs text-[#37474F]/60 mt-1">Activée(recommandé)</p>
                                        </div>
                                        <div class="w-10 h-6 bg-[#2E7D32] rounded-full relative cursor-pointer">
                                            <div class="absolute right-1 top-1 w-4 h-4 bg-white rounded-full">
                                            </div>
                                        </div>
                                    </div>

                                    @livewire('auth.two-factor-settings')

                                    <button
                                        class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg hover:bg-[#F9F6EE] transition-colors text-left">
                                        <p class="text-sm font-medium text-[#37474F]">Changer le mot de passe</p>
                                        <p class="text-xs text-[#37474F]/60 mt-1">Dernière modification il y a 30
                                            jours</p>
                                    </button>

                                    @livewire('pages.admin.profile.changepasswordmodal')

                                    <button
                                        class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg hover:bg-[#F9F6EE] transition-colors text-left">
                                        <p class="text-sm font-medium text-[#5e4950]">Supprimer mon compte</p>
                                    </button>
                                    @livewire('pages.admin.profile.delete-account-modal')

                                    <button
                                        class="w-full px-4 py-3 border border-[#E0E0E0] rounded-lg hover:bg-[#F9F6EE] transition-colors text-left">
                                        <p class="text-sm font-medium text-[#37474F]">Sessions actives</p>
                                        <p class="text-xs text-[#37474F]/60 mt-1">2 appareils connectés</p>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
