<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Agrospace</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-[#F5F5DC] via-[#F5F5DC] to-[#E8E8D0] min-h-screen flex items-center justify-center font-inter">

    {{-- Background Pattern --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-[#2E7D32]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-[#FFB300]/5 rounded-full blur-3xl"></div>
    </div>

    <div 
        class="relative w-full max-w-md px-6"
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 100)"
    >
        {{-- Logo --}}
        <div 
            class="text-center mb-8"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
        >
            <a href="/" class="inline-flex items-center space-x-2 mb-2">
                <div class="w-12 h-12 bg-[#2E7D32] rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-3xl font-bold text-[#2E7D32]" style="font-family: 'Poppins', sans-serif;">
                    Agrospace
                </span>
            </a>
            <h2 class="text-2xl font-bold text-[#37474F] mt-4" style="font-family: 'Poppins', sans-serif;">
                Mot de passe oublié ?
            </h2>
            <p class="text-[#37474F]/70 mt-2">
                Pas de soucis, nous allons vous envoyer un lien de réinitialisation
            </p>
        </div>

        {{-- Reset Card --}}
        <div 
            class="bg-white rounded-2xl shadow-xl p-8"
            x-show="show"
            x-transition:enter="transition ease-out duration-500 delay-150"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
        >
            @livewire('forgot-password-form')
        </div>

        {{-- Footer Links --}}
        <div 
            class="text-center mt-6"
            x-show="show"
            x-transition:enter="transition ease-out duration-500 delay-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        >
            <a href="/login" class="text-sm text-[#2E7D32] font-semibold hover:text-[#1B5E20] transition-colors flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour à la connexion
            </a>
        </div>
    </div>

    @livewireScripts
</body>
</html>