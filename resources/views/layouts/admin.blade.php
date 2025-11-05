<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '🌿Agrospace🌿 - Connectons les acteurs du monde agropastoral') }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <!-- Page Specific Styles -->
    @stack('styles')
</head>

<body class="font-inter antialiased bg-agro-white text-agro-gray">

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        @livewire('layout.sidebar')

        {{-- Styles personnalisés --}}
        <style>
            /* Scrollbar personnalisée */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #E0E0E0;
                border-radius: 3px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #2E7D32;
            }
        </style>

        {{-- Contenu principal --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Barre de navigation --}}
            @livewire('layout.menu')

            {{-- Contenu de la page --}}
            <main class="flex-1 overflow-y-auto custom-scrollbar bg-gray-50">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('showAlert', (data) => {
                Swal.fire({
                    title: data[0].title,
                    text: data[0].text,
                    icon: data[0].type,
                    confirmButtonColor: '#2E7D32',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'px-6 py-3 rounded-lg font-medium',
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp animate__faster'
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            @if (session('toast'))
                Swal.fire({
                    icon: "{{ session('toast.type') }}",
                    title: "{{ session('toast.message') }}",
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });


        // Écouteur pour la confirmation de suppression
        window.addEventListener('confirm-logout', event => {
            const {
                title,
                text
            } = event.detail;

            Swal.fire({
                title: title || 'Confirmer la déconnexion',
                text: text || "Êtes-vous sûr de vouloir vous déconnecter ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, deconnexion !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('logout');
                }
            });
        });
    </script>

    <!-- SweetAlert Integration Script -->
    <script>
        // Global SweetAlert Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Listen for Livewire events
        window.addEventListener('alert', event => {
            const data = event.detail[0] || event.detail;
            Toast.fire({
                icon: data.type || 'info',
                title: data.message
            });
        });

        window.addEventListener('confirm-action', event => {
            const data = event.detail[0] || event.detail;
            Swal.fire({
                title: data.title || '{{ __('Êtes-vous sûr ?') }}',
                text: data.text || '{{ __('Cette action est irréversible.') }}',
                icon: data.icon || 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2E7D32',
                cancelButtonColor: '#d33',
                confirmButtonText: data.confirmText || '{{ __('Oui, continuer') }}',
                cancelButtonText: data.cancelText || '{{ __('Annuler') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Emit event back to Livewire
                    Livewire.dispatch(data.callback || 'confirmed');
                }
            });
        });

        // Success notification helper
        window.showSuccess = (message) => {
            Toast.fire({
                icon: 'success',
                title: message
            });
        };

        // Error notification helper
        window.showError = (message) => {
            Toast.fire({
                icon: 'error',
                title: message
            });
        };
    </script>


    @livewireScripts

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>

</html>
