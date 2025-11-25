<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')

    <title>{{ config('app.name', '🌿🌿✨Agrospace🌿🌿✨ - Connectons les acteurs du monde agropastoral') }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-agro-white text-agro-gray" x-data="{ mobileMenuOpen: false }">

    <!-- Toast Container -->
    <div x-data="toastManager()" x-init="init()" class="fixed top-4 right-4 z-50 space-y-2">
        <template x-for="(toast, index) in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="transform translate-x-full opacity-0"
                x-transition:enter-end="transform translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="transform translate-x-0 opacity-100"
                x-transition:leave-end="transform translate-x-full opacity-0"
                class="relative flex items-center w-full max-w-sm p-4 rounded-xl shadow-lg border"
                :class="{
                    'bg-green-50 border-green-200 text-green-800': toast.type === 'success',
                    'bg-red-50 border-red-200 text-red-800': toast.type === 'error',
                    'bg-blue-50 border-blue-200 text-blue-800': toast.type === 'info',
                    'bg-yellow-50 border-yellow-200 text-yellow-800': toast.type === 'warning',
                    'bg-purple-50 border-purple-200 text-purple-800': toast.type === 'question'
                }">
                <!-- Icon -->
                <div class="flex-shrink-0">
                    <svg x-show="toast.type === 'success'" class="w-6 h-6 text-green-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg x-show="toast.type === 'error'" class="w-6 h-6 text-red-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg x-show="toast.type === 'info'" class="w-6 h-6 text-blue-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg x-show="toast.type === 'warning'" class="w-6 h-6 text-yellow-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <svg x-show="toast.type === 'question'" class="w-6 h-6 text-purple-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <!-- Message -->
                <div class="ml-3 flex-1">
                    <p x-text="toast.message" class="text-sm font-medium"></p>
                </div>

                <!-- Close Button -->
                <button @click="removeToast(toast.id)"
                    class="ml-4 flex-shrink-0 p-1 rounded-full hover:bg-white hover:bg-opacity-20 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Progress Bar -->
                <div x-show="toast.autoClose"
                    class="absolute bottom-0 left-0 h-1 bg-current rounded-b-xl transition-all duration-100"
                    :style="`width: ${toast.progress}%`"
                    :class="{
                        'bg-green-500': toast.type === 'success',
                        'bg-red-500': toast.type === 'error',
                        'bg-blue-500': toast.type === 'info',
                        'bg-yellow-500': toast.type === 'warning',
                        'bg-purple-500': toast.type === 'question'
                    }">
                </div>
            </div>
        </template>
    </div>
    <main>
        {{ $slot }}
    </main>

    {{-- Scroll to top button --}}
    <button x-data="{ showButton: false }" x-init="window.addEventListener('scroll', () => { showButton = window.pageYOffset > 300 })" x-show="showButton" x-cloak
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-8 right-8 bg-base text-white w-12 h-12 rounded-full shadow-2xl hover:bg-green-800 transition-all hover:scale-110 flex items-center justify-center z-40"
        aria-label="Retour en haut de la page" title="Retour en haut">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        function toastManager() {
            return {
                toasts: [],
                init() {
                    // Vérifier s'il y a un toast dans la session Laravel
                    @if (session('toast'))
                        this.show({
                            type: '{{ session('toast.type') }}',
                            message: '{{ session('toast.message') }}',
                            duration: 5000
                        });
                    @endif
                },
                show(toast) {
                    const id = Date.now() + Math.random();
                    const newToast = {
                        id,
                        type: toast.type || 'info',
                        message: toast.message,
                        duration: toast.duration || 5000,
                        autoClose: toast.autoClose !== false,
                        visible: true,
                        progress: 100
                    };

                    this.toasts.push(newToast);

                    // Auto-close si activé
                    if (newToast.autoClose) {
                        const startTime = Date.now();
                        const interval = setInterval(() => {
                            const elapsed = Date.now() - startTime;
                            newToast.progress = 100 - (elapsed / newToast.duration) * 100;

                            if (elapsed >= newToast.duration) {
                                clearInterval(interval);
                                this.removeToast(id);
                            }
                        }, 50);
                    }

                    // Supprimer automatiquement après un certain temps
                    setTimeout(() => {
                        if (this.toasts.find(t => t.id === id)) {
                            this.removeToast(id);
                        }
                    }, newToast.duration);
                },
                removeToast(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) {
                        toast.visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 200); // Correspond à la durée de l'animation de sortie
                    }
                },
                // Méthodes pratiques pour différents types
                success(message, duration = 5000) {
                    this.show({
                        type: 'success',
                        message,
                        duration
                    });
                },
                error(message, duration = 5000) {
                    this.show({
                        type: 'error',
                        message,
                        duration
                    });
                },
                info(message, duration = 5000) {
                    this.show({
                        type: 'info',
                        message,
                        duration
                    });
                },
                warning(message, duration = 5000) {
                    this.show({
                        type: 'warning',
                        message,
                        duration
                    });
                }
            }
        }

        // Exposer globalement pour utilisation depuis d'autres composants
        window.toast = {
            show: (toast) => Alpine.$data(document.querySelector('[x-data="toastManager()"]')).show(toast),
            success: (message, duration) => Alpine.$data(document.querySelector('[x-data="toastManager()"]')).success(
                message, duration),
            error: (message, duration) => Alpine.$data(document.querySelector('[x-data="toastManager()"]')).error(
                message, duration),
            info: (message, duration) => Alpine.$data(document.querySelector('[x-data="toastManager()"]')).info(message,
                duration),
            warning: (message, duration) => Alpine.$data(document.querySelector('[x-data="toastManager()"]')).warning(
                message, duration)
        };
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('toast'))
                const toast = @json(session('toast'));

                function showToast() {
                    if (typeof Swal === 'undefined') {
                        setTimeout(showToast, 100);
                        return;
                    }
                    Swal.fire({
                        icon: toast.type,
                        title: toast.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                showToast();
            @endif
        });

        // Écouteur pour les notifications toast
        window.addEventListener('show-toast', event => {
            Swal.fire({
                icon: event.detail[0].type || 'info',
                title: event.detail[0].message || 'Opération effectuée 1',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });

        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:success', (event) => {
                Swal.fire({
                    title: event.title,
                    text: event.text,
                    icon: event.icon,
                    confirmButtonColor: '#1B5E20',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'rounded-lg'
                    }
                });
            });
        });
    </script>

    @stack('scripts')

    @livewireScripts
</body>

</html>
