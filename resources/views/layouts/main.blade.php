<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <main>
        {{ $slot }}
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            @if (session('toast'))
                Swal.fire({
                    icon: "{{ session('toast.type') }}",
                    title: "{{ session('toast.message') }}",
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });

        // Écouteur pour les notifications toast
        window.addEventListener('show-toast', event => {
            const {
                type,
                message
            } = event.detail;

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

            Toast.fire({
                icon: type || 'info',
                title: message || 'Opération effectuée'
            });
        });
    </script>

    @stack('scripts')

    @livewireScripts
</body>

</html>
