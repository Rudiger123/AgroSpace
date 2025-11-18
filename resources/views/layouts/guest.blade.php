<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('css')
</head>

<body class="font-inter antialiased bg-agro-white text-agro-gray">
    {{ $slot }}
    @livewireScripts
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('message');
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
            Swal.fire({
                icon: event.detail[0].type || 'info',
                title: event.detail[0].message || 'Opération effectuée 1',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>
</body>

</html>
