<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Offer;
use App\Models\Demand;
use App\Models\Avis;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public $stats = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $this->stats = $this->getAdminStats();
        } elseif ($user->isProducer()) {
            $this->stats = $this->getProducerStats($user);
        } elseif ($user->isConsumer()) {
            $this->stats = $this->getConsumerStats($user);
        }
    }

    private function getAdminStats()
    {
        // Initialiser les tableaux pour 12 mois
        $months = [];
        $offersTrend = array_fill(0, 12, 0);
        $demandsTrend = array_fill(0, 12, 0);
        
        for ($i = 11; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('n'); // Numéro du mois (1-12)
        }

        // Statistiques des offres des 12 derniers mois
        $offersData = Offer::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->pluck('count', 'month')
            ->toArray();

        foreach ($offersData as $month => $count) {
            $index = array_search($month, $months);
            if ($index !== false) {
                $offersTrend[$index] = (int)$count;
            }
        }

        // Statistiques des demandes des 12 derniers mois
        $demandsData = Demand::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->pluck('count', 'month')
            ->toArray();

        foreach ($demandsData as $month => $count) {
            $index = array_search($month, $months);
            if ($index !== false) {
                $demandsTrend[$index] = (int)$count;
            }
        }

        // Répartition par région
        $regionDistribution = Offer::select('region', DB::raw('COUNT(*) as count'))
            ->whereNotNull('region')
            ->groupBy('region')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count')
            ->toArray();

        // Si pas de données, utiliser des valeurs par défaut
        if (empty($regionDistribution)) {
            $regionDistribution = [0];
        }

        // Utilisateurs par rôle
        $usersByRole = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('roles.name', DB::raw('COUNT(*) as count'))
            ->groupBy('roles.name')
            ->pluck('count')
            ->toArray();

        if (empty($usersByRole)) {
            $usersByRole = [0, 0, 0];
        }

        // Activité de connexion des 30 derniers jours
        $loginActivity = [];
        $loginData = ActivityLog::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('type', 'login')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        // Remplir avec des 0 si pas assez de données
        $loginActivity = array_pad($loginData, 30, 0);
        $loginActivity = array_slice($loginActivity, 0, 30);

        return [
            'offers_trend' => $offersTrend,
            'demands_trend' => $demandsTrend,
            'region_distribution' => $regionDistribution,
            'users_by_role' => array_values($usersByRole),
            'login_activity' => $loginActivity,
        ];
    }

    private function getProducerStats(User $user)
    {
        // Données de performance des offres
        $offers = $user->offers()
            ->select('titre', 'views_count', 'contacts_count')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();
        
        $viewsData = $offers->pluck('views_count')->map(fn($v) => (int)($v ?? 0))->toArray();
        $contactsData = $offers->pluck('contacts_count')->map(fn($v) => (int)($v ?? 0))->toArray();
        $offersTitles = $offers->pluck('titre')->map(fn($t) => substr($t, 0, 20))->toArray();

        // Valeurs par défaut si pas de données
        if (empty($viewsData)) {
            $viewsData = [0];
            $contactsData = [0];
            $offersTitles = ['Aucune offre'];
        }

        // Ventes par catégorie
        $salesData = $user->offers()
            ->join('categories', 'offers.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('COUNT(*) as count'))
            ->where('offers.statut', 'vendue')
            ->groupBy('categories.name')
            ->get();

        $salesByCategory = $salesData->pluck('count')->map(fn($v) => (int)$v)->toArray();
        $categories = $salesData->pluck('name')->toArray();

        if (empty($salesByCategory)) {
            $salesByCategory = [0];
            $categories = ['Aucune vente'];
        }

        // Tendances des contacts des 30 derniers jours
        $contactsData = ActivityLog::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('user_id', $user->id)
            ->where('type', 'contact')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $contactsTrend = array_pad($contactsData, 30, 0);
        $contactsTrend = array_slice($contactsTrend, 0, 30);

        return [
            'views_data' => $viewsData,
            'contacts_data' => $contactsData,
            'offers_titles' => $offersTitles,
            'sales_by_category' => $salesByCategory,
            'categories' => $categories,
            'contacts_trend' => $contactsTrend,
        ];
    }

    private function getConsumerStats(User $user)
    {
        // Initialiser les tableaux pour 12 mois
        $months = [];
        $activeDemands = array_fill(0, 12, 0);
        $fulfilledDemands = array_fill(0, 12, 0);
        
        for ($i = 11; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('n');
        }

        // Évolution des demandes actives
        $activeData = $user->demands()
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->pluck('count', 'month')
            ->toArray();

        foreach ($activeData as $month => $count) {
            $index = array_search($month, $months);
            if ($index !== false) {
                $activeDemands[$index] = (int)$count;
            }
        }

        // Évolution des demandes satisfaites
        $fulfilledData = $user->demands()
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->where('status', 'satisfied')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->pluck('count', 'month')
            ->toArray();

        foreach ($fulfilledData as $month => $count) {
            $index = array_search($month, $months);
            if ($index !== false) {
                $fulfilledDemands[$index] = (int)$count;
            }
        }

        // Données budget vs prix
        $demands = $user->demands()
            ->select('id', 'title', 'budget')
            ->orderByDesc('created_at')
            ->limit(7)
            ->get();

        $budgetData = $demands->pluck('budget')->map(fn($v) => (int)($v ?? 0))->toArray();
        $demandsTitles = $demands->pluck('title')->map(fn($t) => substr($t, 0, 20))->toArray();
        
        // Prix moyens proposés (simulation - à adapter selon votre structure)
        $proposedPrices = $budgetData; // Vous devrez adapter ceci selon vos relations

        if (empty($budgetData)) {
            $budgetData = [0];
            $proposedPrices = [0];
            $demandsTitles = ['Aucune demande'];
        }

        // Réponses aux demandes
        $acceptedCount = $user->demands()->where('status', 'accepted')->count();
        $pendingCount = $user->demands()->where('status', 'pending')->count();
        $rejectedCount = $user->demands()->where('status', 'rejected')->count();
        
        $responsesData = [$acceptedCount, $pendingCount, $rejectedCount];

        // Activité de recherche des 30 derniers jours
        $searchData = ActivityLog::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('user_id', $user->id)
            ->where('type', 'search')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $searchActivity = array_pad($searchData, 30, 0);
        $searchActivity = array_slice($searchActivity, 0, 30);

        return [
            'active_demands' => $activeDemands,
            'fulfilled_demands' => $fulfilledDemands,
            'budget_data' => $budgetData,
            'proposed_prices' => $proposedPrices,
            'demands_titles' => $demandsTitles,
            'responses_data' => $responsesData,
            'search_activity' => $searchActivity,
        ];
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}