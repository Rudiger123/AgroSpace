<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Agrospace' }}</title>

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

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideIn {
            animation: slideIn 0.4s ease-out;
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        .glass-effect-1 {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-base-50 via-white to-earth-50 font-sans">

    <div class="" x-data="dashboard()" wire:ignore.self x-cloak>
          <!-- Sidebar -->
    <x-admin.sidebar></x-admin.sidebar>

    <!-- Main Content -->
    <div class="lg:ml-72 transition-all duration-300">

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"></div>

        <!-- Header -->
        <x-admin.header></x-admin.header>

        <!-- Dashboard Content -->
        <main class="p-4 sm:p-6 space-y-4 sm:space-y-6">
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

    <script>
        function dashboard() {
            return {
                sidebarOpen: window.innerWidth >= 1024,
                currentPage: window.location.pathname,
                hoveredBar: null,
                notifications: [{
                        id: 1,
                        title: 'Nouvelle inscription',
                        message: 'Marie Fotso vient de s\'inscrire comme productrice',
                        time: 'Il y a 5 minutes',
                        color: 'bg-base-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>',
                        read: false
                    },
                    {
                        id: 2,
                        title: 'Nouvelle offre',
                        message: 'Kouam Jean a publié "1 tonne de Maïs Bio"',
                        time: 'Il y a 12 minutes',
                        color: 'bg-blue-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path></svg>',
                        read: false
                    },
                    {
                        id: 3,
                        title: 'Message important',
                        message: 'Vous avez reçu un message de Paul Ngono',
                        time: 'Il y a 1 heure',
                        color: 'bg-earth-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path></svg>',
                        read: false
                    },
                    {
                        id: 4,
                        title: 'Demande satisfaite',
                        message: 'La demande "50 poulets de chair" a été pourvue',
                        time: 'Il y a 2 heures',
                        color: 'bg-green-500',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                        read: true
                    }
                ],
                menuItems: [{
                        name: 'Dashboard',
                        href: '/dashboard',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>'
                    },
                    {
                        name: 'Utilisateurs',
                        href: '/users',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                        badge: '247'
                    },
                    {
                        name: 'Offres',
                        href: '/offers',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                        badge: '156'
                    },
                    {
                        name: 'Demandes',
                        href: '#',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>',
                        badge: '89'
                    },
                    {
                        name: 'Messages',
                        href: '#',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>',
                        badge: '12'
                    },
                    {
                        name: 'Blog',
                        href: '#',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>'
                    },
                    {
                        name: 'Carte',
                        href: '#',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>'
                    },
                    {
                        name: 'Statistiques',
                        href: '#',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>'
                    },
                    {
                        name: 'Paramètres',
                        href: '#',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 001.066 1.066c.756.426.756 2.924 0 3.35a1.724 1.724 0 00-1.066 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.066-1.066c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-1.066z"></path></svg>'
                    },
                ],
                stats: [{
                        label: 'Utilisateurs actifs',
                        value: '2,847',
                        change: '+12%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                        bgColor: 'bg-base-100',
                        iconColor: 'text-base-600',
                        description: '247 nouveaux ce mois'
                    },
                    {
                        label: 'Offres publiées',
                        value: '1,562',
                        change: '+8%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                        bgColor: 'bg-blue-100',
                        iconColor: 'text-blue-600',
                        description: '156 cette semaine'
                    },
                    {
                        label: 'Demandes actives',
                        value: '892',
                        change: '+15%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>',
                        bgColor: 'bg-earth-100',
                        iconColor: 'text-earth-600',
                        description: '89 aujourd\'hui'
                    },
                    {
                        label: 'Taux de conversion',
                        value: '68%',
                        change: '+5%',
                        trend: 'up',
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
                        bgColor: 'bg-purple-100',
                        iconColor: 'text-purple-600',
                        description: 'Demandes satisfaites'
                    }
                ],
                activityData: [{
                        month: 'Mai',
                        offres: 95,
                        demandes: 78
                    },
                    {
                        month: 'Juin',
                        offres: 110,
                        demandes: 85
                    },
                    {
                        month: 'Juil',
                        offres: 88,
                        demandes: 92
                    },
                    {
                        month: 'Août',
                        offres: 125,
                        demandes: 105
                    },
                    {
                        month: 'Sept',
                        offres: 105,
                        demandes: 88
                    },
                    {
                        month: 'Oct',
                        offres: 132,
                        demandes: 115
                    }
                ],
                categories: [{
                        name: 'Céréales & Grains',
                        count: 342,
                        percentage: 85,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>'
                    },
                    {
                        name: 'Légumes & Fruits',
                        count: 298,
                        percentage: 74,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    },
                    {
                        name: 'Élevage & Volaille',
                        count: 267,
                        percentage: 66,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>'
                    },
                    {
                        name: 'Produits Transformés',
                        count: 189,
                        percentage: 47,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'
                    },
                    {
                        name: 'Services Agricoles',
                        count: 156,
                        percentage: 39,
                        icon: '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>'
                    }
                ],
                recentActivities: [{
                        title: 'Nouvelle offre publiée',
                        description: 'Kouam Jean a publié "1 tonne de Maïs Bio - Douala"',
                        time: 'Il y a 5 minutes',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path></svg>',
                        color: 'bg-base-500',
                        badge: {
                            text: 'Offre',
                            color: 'bg-base-100 text-base-700'
                        }
                    },
                    {
                        title: 'Nouveau producteur inscrit',
                        description: 'Marie Fotso a rejoint Agrospace depuis Bafoussam',
                        time: 'Il y a 12 minutes',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>',
                        color: 'bg-blue-500',
                        badge: {
                            text: 'Nouveau',
                            color: 'bg-blue-100 text-blue-700'
                        }
                    },
                    {
                        title: 'Demande satisfaite',
                        description: 'La demande "50 poulets de chair" a été pourvue',
                        time: 'Il y a 1 heure',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                        color: 'bg-green-500',
                        badge: {
                            text: 'Succès',
                            color: 'bg-green-100 text-green-700'
                        }
                    },
                    {
                        title: 'Article publié',
                        description: 'Nouvel article: "Les techniques modernes de culture du cacao"',
                        time: 'Il y a 2 heures',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path></svg>',
                        color: 'bg-purple-500',
                        badge: {
                            text: 'Blog',
                            color: 'bg-purple-100 text-purple-700'
                        }
                    },
                    {
                        title: 'Message reçu',
                        description: 'Un consommateur s\'intéresse à votre offre de bananes plantain',
                        time: 'Il y a 3 heures',
                        icon: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>',
                        color: 'bg-earth-500',
                        badge: {
                            text: 'Message',
                            color: 'bg-earth-100 text-earth-700'
                        }
                    }
                ],
                topProducers: [{
                        name: 'Kouam Jean',
                        location: 'Douala, Littoral',
                        offres: 47,
                        color: '22c55e'
                    },
                    {
                        name: 'Marie Fotso',
                        location: 'Bafoussam, Ouest',
                        offres: 38,
                        color: '3b82f6'
                    },
                    {
                        name: 'Paul Ngono',
                        location: 'Yaoundé, Centre',
                        offres: 35,
                        color: 'f59e0b'
                    },
                    {
                        name: 'Fatima Hassan',
                        location: 'Garoua, Nord',
                        offres: 29,
                        color: 'ef4444'
                    },
                    {
                        name: 'Ibrahim Mahamat',
                        location: 'Maroua, Extrême-Nord',
                        offres: 24,
                        color: '8b5cf6'
                    }
                ]
            }
        }
    </script>

    @livewireScripts
    @stack('scripts')

</body>

</html>
