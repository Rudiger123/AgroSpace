<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Comment;
use App\Models\View;
use App\Models\Reaction;
use App\Models\Share;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

// Note: Assurez-vous d'avoir les modèles View, Reaction et Share configurés.
// Pour cet exemple, nous supposons qu'ils existent et gèrent le polymorphisme.

#[Layout('layouts.app')]
#[Title('Blog Analytics')]
class BlogAnalytics extends Component
{
    public $dateFrom;
    public $dateTo;
    public $selectedPost = null;
    public $selectedAuthor = null;
    public $statusFilter = 'all'; // Statut de commentaire
     
    public $stats = [];
    public $chartData = [
        'labels' => [], // Dates for X-axis
        'views' => [],  // Views data
        'comments' => [] // Comments data
    ];
    public $topPosts = [];
    public $reactionBreakdown = [
        'labels' => [],
        'values' => []
    ];
    public $sharesPlatform = [
        'labels' => [],
        'values' => []
    ];

    protected $queryString = ['dateFrom', 'dateTo', 'selectedPost', 'selectedAuthor', 'statusFilter'];

    public function mount()
    {
        // Initialisation par défaut sur les 30 derniers jours
        if (empty($this->dateFrom)) {
            $this->dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
        }
        if (empty($this->dateTo)) {
            $this->dateTo = Carbon::now()->format('Y-m-d');
        }
        $this->loadStats();
    }

    public function render()
    {
        return view('livewire.blog.blog-analytics', [
            'posts' => Post::select('id', 'title')->get(),
            // Assurez-vous que le modèle User existe et a des posts
            'authors' => \App\Models\User::whereHas('posts')->select('id', 'name')->get() 
        ]);
    }

    public function loadStats()
    {
        // Clé de cache dynamique incluant tous les filtres
        $cacheKey = "blog_analytics_" . implode('_', [
            $this->dateFrom,
            $this->dateTo,
            $this->selectedPost ?? 'all',
            $this->selectedAuthor ?? 'all',
            $this->statusFilter,
        ]);

        $data = Cache::remember($cacheKey, now()->addMinutes(30), function () {
            $start = Carbon::parse($this->dateFrom)->startOfDay();
            $end = Carbon::parse($this->dateTo)->endOfDay();

            // 1. Base Query for Posts (to filter Views, Reactions, Shares)
            $postQuery = Post::query()
                ->when($this->selectedPost, fn($q) => $q->where('id', $this->selectedPost))
                ->when($this->selectedAuthor, fn($q) => $q->where('author_id', $this->selectedAuthor));

            $postIds = $postQuery->pluck('id');

            // 2. Comments Base Query (Filtered by date, post/author, and status)
            $commentsQuery = Comment::query()
                ->whereBetween('created_at', [$start, $end])
                ->whereIn('post_id', $postIds)
                ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter));

            // 3. Main Stats
            $stats = [
                'total_posts' => $postQuery->count(),
                'total_comments' => $commentsQuery->count(),
                'pending_comments' => $commentsQuery->clone()->where('status', 'pending')->count(),
                'total_reactions' => Reaction::whereIn('reactable_id', $postIds)
                    ->where('reactable_type', Post::class)
                    ->whereBetween('created_at', [$start, $end])
                    ->count(),
                'total_views' => View::whereIn('viewable_id', $postIds)
                    ->where('viewable_type', Post::class)
                    ->whereBetween('created_at', [$start, $end])
                    ->count(),
                'total_shares' => Share::whereBetween('created_at', [$start, $end])
                    ->count(),
            ];

            // 4. Chart Data (Views/Comments Over Time)
            $dateRange = collect(Carbon::parse($this->dateFrom)->daysUntil(Carbon::parse($this->dateTo)->addDay()));
            $allDates = $dateRange->map(fn($date) => $date->format('Y-m-d'))->toArray();

            // Fetch views trend
            $viewsData = View::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereIn('viewable_id', $postIds)
                ->where('viewable_type', Post::class)
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->keyBy('date');
            
            // Fetch comments trend
            $commentsData = Comment::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->whereIn('post_id', $postIds)
                ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->keyBy('date');

            $chartViews = [];
            $chartComments = [];
            foreach ($allDates as $date) {
                $chartViews[] = $viewsData->get($date)['count'] ?? 0;
                $chartComments[] = $commentsData->get($date)['count'] ?? 0;
            }


            $chartData = [
                'labels' => $allDates,
                'views' => $chartViews,
                'comments' => $chartComments,
            ];

            // 5. Top Posts by Engagement (Comments and Views)
            $topPosts = Post::select('id', 'title')
                ->withCount([
                    'comments' => fn($q) => $q->whereBetween('created_at', [$start, $end]),
                    'views' => fn($q) => $q->whereBetween('created_at', [$start, $end]),
                ])
                ->whereIn('id', $postIds)
                ->orderByDesc('comments_count')
                ->take(5)
                ->get();


            // 6. Reaction Breakdown (Donut Chart Data)
            $reactionRaw = Reaction::select('type', DB::raw('COUNT(*) as count'))
                ->whereIn('reactable_id', $postIds)
                ->where('reactable_type', Post::class)
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('type')
                ->get();

            $reactionBreakdown = [
                'labels' => $reactionRaw->pluck('type')->toArray(),
                'values' => $reactionRaw->pluck('count')->toArray(),
            ];
            
            // 7. Shares by Platform
            $sharesPlatformRaw = Share::select('platform', DB::raw('COUNT(*) as count'))
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('platform')
                ->get();

            $sharesPlatform = [
                'labels' => $sharesPlatformRaw->pluck('platform')->toArray(),
                'values' => $sharesPlatformRaw->pluck('count')->toArray(),
            ];


            return compact('stats', 'chartData', 'topPosts', 'reactionBreakdown', 'sharesPlatform');
        });

        $this->stats = $data['stats'];
        $this->chartData = $data['chartData'];
        $this->topPosts = $data['topPosts'];
        $this->reactionBreakdown = $data['reactionBreakdown'];
        $this->sharesPlatform = $data['sharesPlatform'];
    }

    public function refreshStats()
    {
        // Oublie la clé de cache pour forcer le recalcul
        Cache::forget("blog_analytics_" . implode('_', [
            $this->dateFrom,
            $this->dateTo,
            $this->selectedPost ?? 'all',
            $this->selectedAuthor ?? 'all',
            $this->statusFilter,
        ]));
        $this->loadStats();
        // Le dispatch va recharger les scripts pour mettre à jour les graphiques
        $this->dispatch('stats-updated', ['statsData' => [
            'chartData' => $this->chartData,
            'reactionBreakdown' => $this->reactionBreakdown,
            'sharesPlatform' => $this->sharesPlatform,
        ]]);
    }

    // Les méthodes updated* déclenchent la mise à jour des stats et des graphiques
    public function updatedDateFrom() { $this->loadStats(); $this->dispatchStatsUpdated(); }
    public function updatedDateTo() { $this->loadStats(); $this->dispatchStatsUpdated(); }
    public function updatedSelectedPost() { $this->loadStats(); $this->dispatchStatsUpdated(); }
    public function updatedSelectedAuthor() { $this->loadStats(); $this->dispatchStatsUpdated(); }
    public function updatedStatusFilter() { $this->loadStats(); $this->dispatchStatsUpdated(); }

    private function dispatchStatsUpdated()
    {
        $this->dispatch('stats-updated', ['statsData' => [
            'chartData' => $this->chartData,
            'reactionBreakdown' => $this->reactionBreakdown,
            'sharesPlatform' => $this->sharesPlatform,
        ]]);
    }

    public function exportCsv()
    {
        // Logique d'exportation simple (peut être améliorée pour inclure plus de données)
        $csv = "Statistiques du blog du {$this->dateFrom} au {$this->dateTo}\n";
        $csv .= "Articles,Commentaires,Commentaires en attente,Vues,J'aime,Partages\n";
        $csv .= "{$this->stats['total_posts']},{$this->stats['total_comments']},{$this->stats['pending_comments']},{$this->stats['total_views']},{$this->stats['total_reactions']},{$this->stats['total_shares']}\n";

        return response()->stream(
            function () use ($csv) { echo $csv; },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="blog_analytics_' . now()->format('Ymd') . '.csv"',
            ]
        );
    }
}