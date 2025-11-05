<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.admin')] class extends Component {
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-8 pt-8">
        <!-- Carte avec animation de compteur -->
        <div x-data="{
            count: 0,
            target: 1234,
            animate() {
                const increment = this.target / 50;
                const interval = setInterval(() => {
                    if (this.count < this.target) {
                        this.count = Math.min(this.count + increment, this.target);
                    } else {
                        clearInterval(interval);
                    }
                }, 20);
            }
        }" x-init="animate()"
            class="bg-gradient-to-br from-[#2E7D32] to-[#1B5E20] rounded-xl shadow-medium p-6 text-white 
               transform transition-all duration-300 hover:scale-105 hover:shadow-strong cursor-pointer
               relative overflow-hidden group">
            <!-- Effet de brillance au survol -->
            <div
                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent 
                    translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000">
            </div>

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="px-2 py-1 bg-white/20 rounded-full text-xs font-medium backdrop-blur-sm">
                        +12%
                    </span>
                </div>

                <p class="text-white/80 text-sm mb-1 font-medium">Total des Offres</p>
                <p class="text-4xl font-bold font-poppins" x-text="Math.round(count).toLocaleString()">0</p>

                <!-- Mini graphique sparkline -->
                <div class="mt-4 flex items-end space-x-1 h-8">
                    <div class="w-1 bg-white/40 rounded-t" style="height: 60%"></div>
                    <div class="w-1 bg-white/40 rounded-t" style="height: 80%"></div>
                    <div class="w-1 bg-white/40 rounded-t" style="height: 50%"></div>
                    <div class="w-1 bg-white/60 rounded-t" style="height: 90%"></div>
                    <div class="w-1 bg-white/80 rounded-t" style="height: 100%"></div>
                </div>
            </div>
        </div>

        <x-card title="Total des Offres" subtitle="Ce mois" variant="success" :icon="'<svg>...</svg>'" color="#4CAF50">
            <p class="text-3xl font-bold text-[#2E7D32]">1,234</p>
        </x-card>
    </div>

    <div class="bg-white rounded-xl shadow-soft p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-semibold text-[#37474F] font-poppins">Activité sur 7 jours</h3>
                <p class="text-sm text-[#37474F]/60 mt-1">Vue d'ensemble des interactions</p>
            </div>

            <!-- Sélecteur de période avec Alpine.js -->
            <div x-data="{ period: '7days' }" class="flex items-center space-x-2">
                <button @click="period = '7days'"
                    :class="period === '7days' ? 'bg-[#2E7D32] text-white' : 'bg-gray-100 text-[#37474F]'"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                    7 jours
                </button>
                <button @click="period = '30days'"
                    :class="period === '30days' ? 'bg-[#2E7D32] text-white' : 'bg-gray-100 text-[#37474F]'"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 hover:scale-105">
                    30 jours
                </button>
            </div>
        </div>

        <!-- Graphique avec tooltip interactif -->
        <div class="space-y-3" x-data="{
            hoveredBar: null,
            data: [
                { day: 'Lun', value: 65, label: '156 actions' },
                { day: 'Mar', value: 78, label: '189 actions' },
                { day: 'Mer', value: 90, label: '217 actions' },
                { day: 'Jeu', value: 58, label: '140 actions' },
                { day: 'Ven', value: 82, label: '198 actions' },
                { day: 'Sam', value: 95, label: '229 actions' },
                { day: 'Dim', value: 70, label: '169 actions' }
            ]
        }">
            <template x-for="(item, index) in data" :key="index">
                <div @mouseenter="hoveredBar = index" @mouseleave="hoveredBar = null" class="relative">
                    <div class="flex items-center space-x-3">
                        <span class="text-sm font-medium text-[#37474F] w-12" x-text="item.day"></span>

                        <div class="flex-1 h-10 bg-[#F9F6EE] rounded-lg overflow-hidden relative group">
                            <!-- Barre de progression avec dégradé -->
                            <div class="h-full bg-gradient-to-r from-[#2E7D32] to-[#4CAF50] rounded-lg 
                                   transition-all duration-500 ease-out flex items-center justify-end px-3
                                   group-hover:from-[#1B5E20] group-hover:to-[#2E7D32]"
                                :style="`width: ${item.value}%`" x-init="setTimeout(() => $el.style.width = `${item.value}%`, 100)">
                                <span class="text-xs font-bold text-white" x-text="item.value + '%'"></span>
                            </div>

                            <!-- Tooltip au survol -->
                            <div x-show="hoveredBar === index" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="absolute -top-12 left-1/2 transform -translate-x-1/2 
                                   bg-[#37474F] text-white px-3 py-2 rounded-lg text-xs font-medium
                                   whitespace-nowrap shadow-strong z-10"
                                x-text="item.label">
                                <!-- Flèche du tooltip -->
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full">
                                    <div class="border-4 border-transparent border-t-[#37474F]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
