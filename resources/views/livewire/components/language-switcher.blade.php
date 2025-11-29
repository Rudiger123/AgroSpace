<div>
    {{-- Version compacte pour mobile / navbar réduite --}}
    <div x-data="{ open: @entangle('isOpen') }" @click.away="open = false" class="relative inline-block">

        {{-- Bouton compact avec juste le drapeau --}}
        <button @click="open = !open" type="button"
            class="group relative p-2 bg-white hover:bg-gray-50 border-2 border-gray-200 hover:border-indigo-300 rounded-full shadow-sm hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">

            {{-- Drapeau --}}
            <span class="text-2xl transform group-hover:scale-110 transition-transform duration-200 block">
                {{ $currentLanguage['flag'] }}
            </span>

            {{-- Badge indicateur (optionnel) --}}
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
        </button>

        {{-- Mini Dropdown --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-150 transform"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100 transform"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mt-2 w-48 origin-top-right z-50" style="display: none;">

            <div class="bg-white rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 overflow-hidden">
                @foreach ($languages as $code => $language)
                    <button wire:click="changeLanguage('{{ $code }}')"
                        class="w-full flex items-center space-x-3 px-4 py-3 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 transition-all
                           {{ $currentLocale === $code ? 'bg-indigo-50' : '' }}"
                        {{ $currentLocale === $code ? 'disabled' : '' }}>

                        <span class="text-2xl">{{ $language['flag'] }}</span>
                        <span class="text-sm font-medium text-gray-700 flex-1 text-left">
                            {{ $language['native'] }}
                        </span>

                        @if ($currentLocale === $code)
                            <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    

    {{-- Styles personnalisés --}}
    <style>
        /* Animation ripple pour l'effet Material Design */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.4);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Scrollbar personnalisée */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #6366f1, #a855f7);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #4f46e5, #9333ea);
        }

        /* Animation pulse lente pour le logo */
        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>

    {{-- Scripts Livewire pour les notifications --}}
    @script
        <script>
            // Notification quand la langue change
            $wire.on('language-updated', (event) => {
                const data = event[0];

                // Toast notification élégante
                Swal.fire({
                    icon: 'success',
                    title: `${data.flag} ${data.name}`,
                    text: data.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    color: '#fff',
                    iconColor: '#fff',
                    customClass: {
                        popup: 'colored-toast'
                    }
                });
            });

            // Écouter les changements de langue pour d'autres composants
            $wire.on('language-changed', (event) => {
                console.log('🌍 Langue changée vers:', event.locale);

                // Vous pouvez ajouter d'autres actions ici
                // Par exemple, recharger certains composants, analytics, etc.
            });
        </script>
    @endscript

    {{-- Style pour les toasts SweetAlert2 --}}
    <style>
        .colored-toast.swal2-icon-success {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .colored-toast .swal2-title {
            color: white !important;
            font-weight: bold !important;
        }

        .colored-toast .swal2-close {
            color: white !important;
        }

        .colored-toast .swal2-html-container {
            color: white !important;
        }
    </style>
</div>
