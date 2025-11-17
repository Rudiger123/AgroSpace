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

#[Layout('layouts.app')]
#[Title('Blog Analytics')]
class BlogAnalytics extends Component
{
    public $dateFrom;
    public $dateTo;
    public $selectedPost = null;
    public $selectedAuthor = null;
    public $statusFilter = 'all';
     
    public $stats = [];
    public $chartData = [];
    public $topPosts = [];
    public $reactionBreakdown = [];
    public $sharesPlatform = [];

    protected $queryString = ['dateFrom', 'dateTo', 'selectedPost', 'selectedAuthor', 'statusFilter'];

    public function mount()
    {
        $this->dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->dateTo = Carbon::now()->format('Y-m-d');
        $this->loadStats();
    }

    public function render()
    {
        return view('livewire.blog.blog-analytics', [
            'posts' => Post::select('id', 'title')->get(),
            'authors' => \App\Models\User::whereHas('posts')->select('id', 'name')->get()
        ]);
    }

    public function loadStats()
    {
        $cacheKey = "blog_analytics_{$this->dateFrom}_{$this->dateTo}_{$this->selectedPost}_{$this->selectedAuthor}_{$this->statusFilter}";
        
        $data = Cache::remember($cacheKey, 60, function () {
            $from = Carbon::parse($this->dateFrom)->startOfDay();
            $to = Carbon::parse($this->dateTo)->endOfDay();

            // Base queries
            $postsQuery = Post::whereBetween('created_at', [$from, $to]);
            $commentsQuery = Comment::whereBetween('created_at', [$from, $to]);
            $viewsQuery = View::whereBetween('created_at', [$from, $to]);
            $reactionsQuery = Reaction::whereBetween('created_at', [$from, $to]);
            $sharesQuery = Share::whereBetween('created_at', [$from, $to]);

            // Apply filters
            if ($this->selectedPost) {
                $commentsQuery->where('post_id', $this->selectedPost);
                $viewsQuery->where('viewable_id', $this->selectedPost)->where('viewable_type', Post::class);
                $reactionsQuery->where('reactable_id', $this->selectedPost)->where('reactable_type', Post::class);
                $sharesQuery->where('shareable_id', $this->selectedPost)->where('shareable_type', Post::class);
            }

            if ($this->selectedAuthor) {
                $postIds = Post::where('user_id', $this->selectedAuthor)->pluck('id');
                $commentsQuery->whereIn('post_id', $postIds);
            }

            if ($this->statusFilter !== 'all') {
                $commentsQuery->where('status', $this->statusFilter);
            }

            // Aggregate stats
            $stats = [
                'total_posts' => $postsQuery->count(),
                'total_comments' => $commentsQuery->count(),
                'pending_comments' => Comment::whereBetween('created_at', [$from, $to])->pending()->count(),
                'total_views' => $viewsQuery->count(),
                'total_reactions' => $reactionsQuery->count(),
                'total_shares' => $sharesQuery->count(),
            ];

            // Daily views for chart
            $viewsDaily = View::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->whereBetween('created_at', [$from, $to])
                ->where('viewable_type', Post::class)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $chartData = [
                'dates' => $viewsDaily->pluck('date')->map(fn($d) => Carbon::parse($d)->format('d/m'))->toArray(),
                'views' => $viewsDaily->pluck('count')->toArray(),
            ];

            // Top 5 posts
            $topPosts = Post::withCount(['views', 'comments', 'reactions'])
                ->whereBetween('created_at', [$from, $to])
                //->orderBy('views_count', 'desc')
                ->take(5)
                ->get()
                ->map(function ($post) {
                    return [
                        'title' => $post->title,
                        'views' => $post->views_count,
                        'comments' => $post->comments_count,
                        'reactions' => $post->reactions_count,
                    ];
                });

            // Reactions breakdown
            $reactionBreakdown = Reaction::selectRaw('type, COUNT(*) as count')
                ->whereBetween('created_at', [$from, $to])
                ->where('reactable_type', Post::class)
                ->groupBy('type')
                ->get()
                ->mapWithKeys(fn($r) => [$r->type => $r->count]);

            // Shares by platform
            $sharesPlatform = Share::selectRaw('platform, COUNT(*) as count')
                ->whereBetween('created_at', [$from, $to])
                ->groupBy('platform')
                ->get()
                ->mapWithKeys(fn($s) => [$s->platform => $s->count]);

            return [
                'stats' => $stats,
                'chartData' => $chartData,
                'topPosts' => $topPosts,
                'reactionBreakdown' => $reactionBreakdown,
                'sharesPlatform' => $sharesPlatform,
            ];
        });

        $this->stats = $data['stats'];
        $this->chartData = $data['chartData'];
        $this->topPosts = $data['topPosts'];
        $this->reactionBreakdown = $data['reactionBreakdown'];
        $this->sharesPlatform = $data['sharesPlatform'];
    }

    public function refreshStats()
    {
        Cache::forget("blog_analytics_{$this->dateFrom}_{$this->dateTo}_{$this->selectedPost}_{$this->selectedAuthor}_{$this->statusFilter}");
        $this->loadStats();
        $this->dispatchBrowserEvent('stats-refreshed');
    }

    public function exportCsv()
    {
        return 'export csv';
        // return redirect()->route('admin.analytics.export', [
        //     'from' => $this->dateFrom,
        //     'to' => $this->dateTo,
        //     'post' => $this->selectedPost,
        //     'author' => $this->selectedAuthor,
        //     'status' => $this->statusFilter,
        // ]);
    }

    public function updatedDateFrom()
    {
        $this->loadStats();
    }

    public function updatedDateTo()
    {
        $this->loadStats();
    }

    public function updatedSelectedPost()
    {
        $this->loadStats();
    }

    public function updatedSelectedAuthor()
    {
        $this->loadStats();
    }

    public function updatedStatusFilter()
    {
        $this->loadStats();
    }
}
