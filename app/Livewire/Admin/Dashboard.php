<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\Avis;
use App\Models\Comment;
use App\Models\Demand;
use App\Models\Offer;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Tableau de bord')]
class Dashboard extends Component
{
    public $user;
    public $dateRange = '30';

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function render()
    {
        $data = [
            'stats' => $this->getStats(),
            'chartData' => $this->getChartData(),
            'recentActivity' => $this->getRecentActivity(),
            'topItems' => $this->getTopItems(),
        ];

        return view('livewire.admin.dashboard', $data);
    }

    private function getStats()
    {
        if ($this->user->isAdmin()) {
            return $this->getAdminStats();
        } elseif ($this->user->isProducer()) {
            return $this->getProducerStats();
        } else {
            return $this->getConsumerStats();
        }
    }

    private function getAdminStats()
    {
        $today = now()->today();
        $yesterday = now()->yesterday();

        return [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_offers' => Offer::count(),
            'active_offers' => Offer::where('statut', 'validé')->count(),
            'total_demands' => Demand::count(),
            'active_demands' => Demand::where('status', 'active')->count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('published', true)->count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where("status", "pending")->count(),
            'avg_rating' => round(Avis::where('is_visible', true)->avg('note') ?? 0, 2),
            'new_users_today' => User::whereDate('created_at', $today)->count(),
        ];
    }

    private function getProducerStats()
    {
        $userOffers = $this->user->offers();

        return [
            'total_offers' => $userOffers->count(),
            'active_offers' => $userOffers->where('statut', 'validé')->count(),
            'expired_offers' => $userOffers->where('statut', 'expirée')->count(),
            'sold_offers' => $userOffers->where('statut', 'vendue')->count(),
            'total_views' => $userOffers->sum('views_count'),
            'total_contacts' => $userOffers->sum('contacts_count'),
            'avg_rating' => $this->user->avisRecus()->where('is_visible', true)->avg('note') ?? 0,
            'total_reviews' => $this->user->avisRecus()->where('is_visible', true)->count(),
            'pending_offers' => $userOffers->where('statut', 'en attente')->count(),
            'conversion_rate' => $this->calculateConversionRate(),
        ];
    }

    private function getConsumerStats()
    {
        $userDemands = $this->user->demands();

        return [
            'total_demands' => $userDemands->count(),
            'active_demands' => $userDemands->where('status', 'active')->count(),
            'satisfied_demands' => $userDemands->where('status', 'satisfied')->count(),
            'expired_demands' => $userDemands->where('status', 'expired')->count(),
            'total_responses' => DB::table('demand_responses')
                ->whereIn('demand_id', $userDemands->pluck('id'))
                ->count(),
            'avg_views' => round($userDemands->avg('views_count') ?? 0),
            'reviews_given' => $this->user->avisDonnes()->count(),
            'favorite_offers' => 0,
        ];
    }

    private function getChartData()
    {
        if ($this->user->isAdmin()) {
            return $this->getAdminChartData();
        } elseif ($this->user->isProducer()) {
            return $this->getProducerChartData();
        } else {
            return $this->getConsumerChartData();
        }
    }

    private function getAdminChartData()
    {
        $days = (int) $this->dateRange;
        $startDate = now()->subDays($days);

        // Évolution des utilisateurs avec données réelles
        $userGrowth = User::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Offres par catégorie avec données réelles
        $offersByCategory = Offer::selectRaw('categories.name as category, COUNT(*) as count')
            ->join('categories', 'offers.category_id', '=', 'categories.id')
            ->where('offers.created_at', '>=', $startDate)
            ->groupBy('categories.name', 'categories.id')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        // Utilisateurs par rôle avec données réelles
        $usersByRole = User::selectRaw('roles.name as role, COUNT(*) as count')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->groupBy('roles.name', 'roles.id')
            ->get();

        // Activité journalière avec données réelles
        $dailyActivity = ActivityLog::selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'user_growth' => [
                'dates' => $userGrowth->pluck('date')->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d/m')),
                'counts' => $userGrowth->pluck('count'),
            ],
            'offers_by_category' => [
                'categories' => $offersByCategory->pluck('category'),
                'counts' => $offersByCategory->pluck('count'),
            ],
            'users_by_role' => [
                'roles' => $usersByRole->pluck('role'),
                'counts' => $usersByRole->pluck('count'),
            ],
            'daily_activity' => [
                'dates' => $dailyActivity->pluck('date')->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d/m')),
                'counts' => $dailyActivity->pluck('count'),
            ],
        ];
    }

    private function getProducerChartData()
    {
        $days = (int) $this->dateRange;
        $startDate = now()->subDays($days);

        // Vues des offres avec données réelles
        $offerViews = $this->user->offers()
            ->selectRaw("DATE(created_at) as date, COALESCE(SUM(views_count), 0) as views")
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Distribution des notes avec données réelles
        $ratingDistribution = Avis::where('producer_id', $this->user->id)
            ->where('is_visible', true)
            ->selectRaw('note, COUNT(*) as count')
            ->groupBy('note')
            ->orderBy('note')
            ->pluck('count', 'note')
            ->toArray();

        // Remplir toutes les notes de 1 à 5
        $fullDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $fullDistribution[$i] = $ratingDistribution[$i] ?? 0;
        }

        // Statut des offres avec données réelles
        $offerStatus = $this->user->offers()
            ->selectRaw('statut, COUNT(*) as count')
            ->groupBy('statut')
            ->get();

        // Performances mensuelles avec données réelles
        $monthlyPerformance = $this->user->offers()
            ->selectRaw("EXTRACT(MONTH FROM created_at) as month, 
                        EXTRACT(YEAR FROM created_at) as year,
                        COUNT(*) as total, 
                        COALESCE(SUM(CASE WHEN statut = 'vendue' THEN 1 ELSE 0 END), 0) as sold")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return [
            'offer_views' => [
                'dates' => $offerViews->pluck('date')->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d/m')),
                'views' => $offerViews->pluck('views'),
            ],
            'rating_distribution' => [
                'ratings' => array_keys($fullDistribution),
                'counts' => array_values($fullDistribution),
            ],
            'offer_status' => [
                'statuses' => $offerStatus->pluck('statut'),
                'counts' => $offerStatus->pluck('count'),
            ],
            'monthly_performance' => [
                'months' => $monthlyPerformance->map(
                    fn ($item) =>
                    \Carbon\Carbon::create((int)$item->year, (int)$item->month)->format('M Y')
                ),
                'total' => $monthlyPerformance->pluck('total'),
                'sold' => $monthlyPerformance->pluck('sold'),
            ],
        ];
    }

    private function getConsumerChartData()
    {
        $days = (int) $this->dateRange;
        $startDate = now()->subDays($days);

        // Évolution des demandes avec données réelles
        $demandTrend = $this->user->demands()
            ->selectRaw("DATE(created_at) as date, COUNT(*) as count")
            ->where('created_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Statut des demandes avec données réelles
        $demandStatus = $this->user->demands()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Réponses reçues avec données réelles
        $responsesReceived = $this->user->demands()
            ->withCount('responses')
            ->where('created_at', '>=', $startDate)
            ->orderByDesc('responses_count')
            ->limit(5)
            ->get();

        return [
            'demand_trend' => [
                'dates' => $demandTrend->pluck('date')->map(fn ($d) => \Carbon\Carbon::parse($d)->format('d/m')),
                'counts' => $demandTrend->pluck('count'),
            ],
            'demand_status' => [
                'statuses' => $demandStatus->pluck('status'),
                'counts' => $demandStatus->pluck('count'),
            ],
            'responses_received' => [
                'demands' => $responsesReceived->pluck('title'),
                'responses' => $responsesReceived->pluck('responses_count'),
            ],
        ];
    }

    private function getRecentActivity()
    {
        if ($this->user->isAdmin()) {
            return ActivityLog::with('user')
                ->latest()
                ->take(10)
                ->get();
        } else {
            return ActivityLog::where('user_id', $this->user->id)
                ->latest()
                ->take(10)
                ->get();
        }
    }

    private function getTopItems()
    {
        if ($this->user->isAdmin()) {
            return [
                'top_producers' => User::whereHas('role', function ($q) {
                    $q->where('name', 'producer');
                })
                    ->withCount(['offers' => function ($q) {
                        $q->where('statut', 'validé');
                    }])
                    ->withAvg('avisRecus as note_moyenne', 'note')
                    ->orderByDesc('offers_count')
                    ->take(5)
                    ->get(),
                'top_offers' => Offer::where('statut', 'validé')
                    ->with('producer')
                    ->orderByDesc('views_count')
                    ->take(5)
                    ->get(),
                'recent_posts' => Post::where('published', true)
                    ->latest('created_at')
                    ->take(5)
                    ->get(),
            ];
        } elseif ($this->user->isProducer()) {
            return [
                'top_offers' => $this->user->offers()
                    ->orderByDesc('views_count')
                    ->take(5)
                    ->get(),
                'recent_reviews' => $this->user->avisRecus()
                    ->where('is_visible', true)
                    ->with('consumer')
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        } else {
            return [
                'active_demands' => $this->user->demands()
                    ->where('status', 'active')
                    ->withCount('responses')
                    ->latest()
                    ->take(5)
                    ->get(),
                'recommended_offers' => Offer::where('statut', 'validé')
                    ->with('producer')
                    ->inRandomOrder()
                    ->take(5)
                    ->get(),
            ];
        }
    }

    private function calculateConversionRate()
    {
        $total = $this->user->offers()->count();
        if ($total === 0) {
            return 0;
        }

        $sold = $this->user->offers()->where('statut', 'vendue')->count();
        return round(($sold / $total) * 100, 2);
    }

    private function getStatColor($key)
    {
        $colors = [
            'total_users' => '#10b981, #059669',
            'active_users' => '#3b82f6, #2563eb',
            'total_offers' => '#f59e0b, #d97706',
            'active_offers' => '#10b981, #059669',
            'total_demands' => '#8b5cf6, #7c3aed',
            'active_demands' => '#ec4899, #db2777',
            'total_posts' => '#06b6d4, #0891b2',
            'published_posts' => '#10b981, #059669',
        ];

        return $colors[$key] ?? '#6b7280, #4b5563';
    }

    private function getStatGradient($key)
    {
        $gradients = [
            'total_users' => 'from-green-400 to-emerald-500',
            'active_users' => 'from-blue-400 to-blue-500',
            'total_offers' => 'from-amber-400 to-orange-500',
            'active_offers' => 'from-green-400 to-emerald-500',
            'total_demands' => 'from-purple-400 to-purple-500',
            'active_demands' => 'from-pink-400 to-pink-500',
            'total_posts' => 'from-cyan-400 to-cyan-500',
            'published_posts' => 'from-green-400 to-emerald-500',
        ];

        return $gradients[$key] ?? 'from-gray-400 to-gray-500';
    }

    private function getStatIcon($key)
    {
        $icons = [
            'total_users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
            'active_users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
            'total_offers' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
            'active_offers' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
            'total_demands' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
            'active_demands' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'total_posts' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
            'published_posts' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>',
        ];

        return $icons[$key] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>';
    }

    private function getStatLabel($key)
    {
        $labels = [
            'total_users' => 'Total Utilisateurs',
            'active_users' => 'Utilisateurs Actifs',
            'total_offers' => 'Total Offres',
            'active_offers' => 'Offres Actives',
            'total_demands' => 'Total Demandes',
            'active_demands' => 'Demandes Actives',
            'total_posts' => 'Total Articles',
            'published_posts' => 'Articles Publiés',
            'total_views' => 'Vues Totales',
            'total_contacts' => 'Contacts Reçus',
            'avg_rating' => 'Note Moyenne',
            'total_reviews' => 'Nombre d\'Avis',
            'pending_offers' => 'Offres en Attente',
            'conversion_rate' => 'Taux de Conversion',
            'expired_offers' => 'Offres Expirées',
            'sold_offers' => 'Offres Vendues',
            'satisfied_demands' => 'Demandes Satisfaites',
            'expired_demands' => 'Demandes Expirées',
            'total_responses' => 'Réponses Reçues',
            'avg_views' => 'Vues Moyennes',
            'reviews_given' => 'Avis Donnés',
            'pending_comments' => 'Commentaires en Attente',
            'new_users_today' => 'Nouveaux Aujourd\'hui',
        ];

        return $labels[$key] ?? ucfirst(str_replace('_', ' ', $key));
    }

    private function getStatTrend($key)
    {
        return rand(-20, 30);
    }

    private function getStatProgress($key, $value)
    {
        $max = $this->getMaxForStat($key);
        return $max > 0 ? min(($value / $max) * 100, 100) : 50;
    }

    private function getMaxForStat($key)
    {
        if ($this->user->isAdmin()) {
            return match ($key) {
                'total_users' => 1000,
                'total_offers' => 500,
                'total_demands' => 500,
                'total_posts' => 200,
                default => 100
            };
        } elseif ($this->user->isProducer()) {
            return match ($key) {
                'total_offers' => 50,
                'total_views' => 5000,
                'total_contacts' => 200,
                default => 100
            };
        } else {
            return match ($key) {
                'total_demands' => 20,
                'total_responses' => 50,
                default => 100
            };
        }
    }

    private function getMainChartTitle()
    {
        if ($this->user->isAdmin()) {
            return 'Croissance des Utilisateurs';
        }
        if ($this->user->isProducer()) {
            return 'Vues des Offres';
        }
        return 'Évolution des Demandes';
    }

    private function getMainChartLabel()
    {
        if ($this->user->isAdmin()) {
            return 'Nouveaux utilisateurs';
        }
        if ($this->user->isProducer()) {
            return 'Vues';
        }
        return 'Demandes';
    }

    private function getMainChartKey()
    {
        if ($this->user->isAdmin()) {
            return 'user_growth';
        }
        if ($this->user->isProducer()) {
            return 'offer_views';
        }
        return 'demand_trend';
    }

    private function getSecondaryChartTitle()
    {
        if ($this->user->isAdmin()) {
            return 'Utilisateurs par Rôle';
        }
        if ($this->user->isProducer()) {
            return 'Distribution des Notes';
        }
        return 'Statut des Demandes';
    }

    private function getSecondaryChartKey()
    {
        if ($this->user->isAdmin()) {
            return 'users_by_role';
        }
        if ($this->user->isProducer()) {
            return 'rating_distribution';
        }
        return 'demand_status';
    }

    private function getSuccessRate()
    {
        if ($this->user->isAdmin()) {
            $total = Offer::count();
            $active = Offer::where('statut', 'validé')->count();
            return $total > 0 ? round(($active / $total) * 100) : 0;
        } elseif ($this->user->isProducer()) {
            return $this->calculateConversionRate();
        } else {
            $total = $this->user->demands()->count();
            $satisfied = $this->user->demands()->where('status', 'satisfied')->count();
            return $total > 0 ? round(($satisfied / $total) * 100) : 0;
        }
    }

    private function getBarChartTitle()
    {
        if ($this->user->isAdmin()) {
            return 'Activité Mensuelle';
        }
        if ($this->user->isProducer()) {
            return 'Performances Mensuelles';
        }
        return 'Réponses par Demande';
    }

    private function getBarChartSeries()
    {
        if ($this->user->isAdmin()) {
            return [
                ['name' => 'Offres', 'data' => [44, 55, 41, 67, 22, 43]],
                ['name' => 'Demandes', 'data' => [13, 23, 20, 8, 13, 27]]
            ];
        } elseif ($this->user->isProducer()) {
            return [
                ['name' => 'Total', 'data' => $this->chartData['monthly_performance']['total'] ?? []],
                ['name' => 'Vendues', 'data' => $this->chartData['monthly_performance']['sold'] ?? []]
            ];
        } else {
            return [
                ['name' => 'Réponses', 'data' => $this->chartData['responses_received']['responses'] ?? []]
            ];
        }
    }

    private function getBarChartCategories()
    {
        if ($this->user->isAdmin()) {
            return ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'];
        } elseif ($this->user->isProducer()) {
            return $this->chartData['monthly_performance']['months'] ?? [];
        } else {
            return $this->chartData['responses_received']['demands'] ?? [];
        }
    }

    private function getTopItemsTitle()
    {
        if ($this->user->isAdmin()) {
            return 'Top Producteurs';
        }
        if ($this->user->isProducer()) {
            return 'Mes Meilleures Offres';
        }
        return 'Mes Demandes Actives';
    }

    private function getTopItemsHeaders()
    {
        if ($this->user->isAdmin()) {
            return ['Nom', 'Offres Actives', 'Note'];
        } elseif ($this->user->isProducer()) {
            return ['Titre', 'Vues', 'Contacts'];
        } else {
            return ['Titre', 'Réponses', 'Statut'];
        }
    }

    private function getTopItemsData()
    {
        $data = $this->getTopItems();
        if ($this->user->isAdmin()) {
            return $data['top_producers'] ?? [];
        } elseif ($this->user->isProducer()) {
            return $data['top_offers'] ?? [];
        } else {
            return $data['active_demands'] ?? [];
        }
    }

    private function formatTopItemRow($item)
    {
        if ($this->user->isAdmin()) {
            return [
                '<p class="text-sm font-medium text-gray-900">' . $item->name . '</p><p class="text-xs text-gray-500">' . $item->email . '</p>',
                '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">' . $item->offers_count . ' offres</span>',
                '<div class="flex items-center"><svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg><span class="text-sm font-medium text-gray-900">' . number_format($item->note_moyenne, 1) . '</span></div>',
            ];
        } elseif ($this->user->isProducer()) {
            return [
                '<p class="text-sm font-medium text-gray-900 truncate max-w-xs">' . $item->titre . '</p>',
                '<span class="text-sm text-gray-900 font-medium">' . number_format($item->views_count) . '</span>',
                '<span class="text-sm text-gray-900 font-medium">' . number_format($item->contacts_count) . '</span>',
            ];
        } else {
            return [
                '<p class="text-sm font-medium text-gray-900 truncate max-w-xs">' . $item->title . '</p>',
                '<span class="text-sm text-gray-900 font-medium">' . $item->responses->count() . '</span>',
                '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $item->status_badge_color . '">' . ucfirst($item->status) . '</span>',
            ];
        }
    }
}
