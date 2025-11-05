<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\User;
use App\Models\Offer;
use App\Models\Demand;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public $activityPeriod = '6';
    
    public $stats = [];
    public $activityData = [];
    public $categories = [];
    public $recentActivities = [];
    public $topProducers = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadActivityData();
        $this->loadCategories();
        $this->loadRecentActivities();
        $this->loadTopProducers();
    }


    public function loadStats()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $totalOffers = Offer::count();
        $totalDemands = Demand::count();

        // Calculer les variations (comparé au mois dernier)
        $lastMonthUsers = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $lastMonthOffers = Offer::whereMonth('created_at', now()->subMonth()->month)->count();

        $this->stats = [
            [
                'label' => 'Utilisateurs actifs',
                'value' => number_format($totalUsers),
                'change' => '+12%',
                'trend' => 'up',
                'icon' => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                'bgColor' => 'bg-green-100',
                'description' => '247 nouveaux ce mois'
            ],
            [
                'label' => 'Offres publiées',
                'value' => number_format($totalOffers),
                'change' => '+8%',
                'trend' => 'up',
                'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                'bgColor' => 'bg-blue-100',
                'description' => '156 cette semaine'
            ],
            [
                'label' => 'Demandes actives',
                'value' => number_format($totalDemands),
                'change' => '+15%',
                'trend' => 'up',
                'icon' => '<svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>',
                'bgColor' => 'bg-amber-100',
                'description' => '89 aujourd\'hui'
            ],
            [
                'label' => 'Taux de conversion',
                'value' => '68%',
                'change' => '+5%',
                'trend' => 'up',
                'icon' => '<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>',
                'bgColor' => 'bg-purple-100',
                'description' => 'Demandes satisfaites'
            ]
        ];
    }

    public function loadActivityData()
    {
        // Simuler des données pour les 6 derniers mois
        $this->activityData = [
            ['month' => 'Mai', 'offres' => 95, 'demandes' => 78],
            ['month' => 'Juin', 'offres' => 110, 'demandes' => 85],
            ['month' => 'Juil', 'offres' => 88, 'demandes' => 92],
            ['month' => 'Août', 'offres' => 125, 'demandes' => 105],
            ['month' => 'Sept', 'offres' => 105, 'demandes' => 88],
            ['month' => 'Oct', 'offres' => 132, 'demandes' => 115]
        ];
    }

    public function loadCategories()
    {
        $this->categories = [
            [
                'name' => 'Céréales & Grains',
                'count' => 342,
                'percentage' => 85,
                'icon' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>'
            ],
            [
                'name' => 'Légumes & Fruits',
                'count' => 298,
                'percentage' => 74,
                'icon' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
            ],
            [
                'name' => 'Élevage & Volaille',
                'count' => 267,
                'percentage' => 66,
                'icon' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>'
            ],
            [
                'name' => 'Produits Transformés',
                'count' => 189,
                'percentage' => 47,
                'icon' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>'
            ],
            [
                'name' => 'Services Agricoles',
                'count' => 156,
                'percentage' => 39,
                'icon' => '<svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>'
            ]
        ];
    }

    public function loadRecentActivities()
    {
        $this->recentActivities = [
            [
                'title' => 'Nouvelle offre publiée',
                'description' => 'Kouam Jean a publié "1 tonne de Maïs Bio - Douala"',
                'time' => 'Il y a 5 minutes',
                'icon' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path></svg>',
                'color' => 'bg-green-500',
                'badge' => ['text' => 'Offre', 'color' => 'bg-green-100 text-green-700']
            ],
            [
                'title' => 'Nouveau producteur inscrit',
                'description' => 'Marie Fotso a rejoint Agrospace depuis Bafoussam',
                'time' => 'Il y a 12 minutes',
                'icon' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>',
                'color' => 'bg-blue-500',
                'badge' => ['text' => 'Nouveau', 'color' => 'bg-blue-100 text-blue-700']
            ],
            [
                'title' => 'Demande satisfaite',
                'description' => 'La demande "50 poulets de chair" a été pourvue',
                'time' => 'Il y a 1 heure',
                'icon' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
                'color' => 'bg-green-500',
                'badge' => ['text' => 'Succès', 'color' => 'bg-green-100 text-green-700']
            ],
            [
                'title' => 'Article publié',
                'description' => 'Nouvel article: "Les techniques modernes de culture du cacao"',
                'time' => 'Il y a 2 heures',
                'icon' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path></svg>',
                'color' => 'bg-purple-500',
                'badge' => ['text' => 'Blog', 'color' => 'bg-purple-100 text-purple-700']
            ],
            [
                'title' => 'Message reçu',
                'description' => 'Un consommateur s\'intéresse à votre offre de bananes plantain',
                'time' => 'Il y a 3 heures',
                'icon' => '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"></path></svg>',
                'color' => 'bg-amber-500',
                'badge' => ['text' => 'Message', 'color' => 'bg-amber-100 text-amber-700']
            ]
        ];
    }

    public function loadTopProducers()
    {
        $this->topProducers = [
            ['name' => 'Kouam Jean', 'location' => 'Douala, Littoral', 'offres' => 47, 'color' => '22c55e'],
            ['name' => 'Marie Fotso', 'location' => 'Bafoussam, Ouest', 'offres' => 38, 'color' => '3b82f6'],
            ['name' => 'Paul Ngono', 'location' => 'Yaoundé, Centre', 'offres' => 35, 'color' => 'f59e0b'],
            ['name' => 'Fatima Hassan', 'location' => 'Garoua, Nord', 'offres' => 29, 'color' => 'ef4444'],
            ['name' => 'Ibrahim Mahamat', 'location' => 'Maroua, Extrême-Nord', 'offres' => 24, 'color' => '8b5cf6']
        ];
    }

    public function updatedActivityPeriod()
    {
        $this->loadActivityData();
    }

    public function loadMoreActivities()
    {
        $this->dispatch('notify', type: 'info', message: 'Chargement de plus d\'activités...');
    }

    public function createOffer()
    {
        dump('Hello World');
    }

    public function inviteUsers()
    {
        $this->dispatch('notify', type: 'success', message: 'Fonctionnalité d\'invitation bientôt disponible !');
    }

    public function render()
    {
        return view('livewire.admin.dashboard')->with([
            'header' => 'Bienvenue sur Agrospace',
            'subheader' => 'Gérez votre écosystème agropastoral en toute simplicité'
        ]);
    }
}