{{-- Exemple : Dropdown avec Alpine.js --}}
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="px-4 py-2 bg-green-500 text-white rounded-lg">
        Menu
    </button>
    
    <div 
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg"
    >
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 1</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 2</a>
    </div>
</div>

{{-- Exemple : Indicateur de chargement --}}
<div x-data="{ loading: false }">
    <button 
        @click="loading = true; setTimeout(() => loading = false, 2000)"
        class="px-4 py-2 bg-blue-500 text-white rounded-lg"
        :disabled="loading"
    >
        <span x-show="!loading">Charger</span>
        <span x-show="loading" class="flex items-center gap-2">
            <svg class="animate-spin h-5 w-5" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Chargement...
        </span>
    </button>
</div>

{{-- Exemple : Modal --}}
<div x-data="{ showModal: false }">
    <button @click="showModal = true" class="px-4 py-2 bg-green-500 text-white rounded-lg">
        Ouvrir Modal
    </button>

    <div 
        x-show="showModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        @click.self="showModal = false"
    >
        <div class="bg-white rounded-lg p-6 max-w-md w-full" @click.stop>
            <h3 class="text-xl font-bold mb-4">Titre du Modal</h3>
            <p class="text-gray-600 mb-4">Contenu du modal...</p>
            <button @click="showModal = false" class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                Fermer
            </button>
        </div>
    </div>
</div>