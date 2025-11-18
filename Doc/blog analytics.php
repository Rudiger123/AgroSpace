--- FILE: app/Http/Livewire/Admin/BlogAnalytics.php ---
<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use App\Models\Comment;
use App\Models\View;
use App\Models\Reaction;
use App\Models\Share;
use Carbon\Carbon;

class BlogAnalytics extends Component
{
    public $dateFrom;
    public $dateTo;
    public $postId;
    public $authorId;

    public $stats = [];
    public $chartData = [];

    protected $listeners = ['refreshStats' => 'refreshStats'];

    public function mount()
    {
        $this->dateFrom = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->dateTo = Carbon::now()->format('Y-m-d');
        $this->loadStats($this->dateFrom, $this->dateTo);
    }

    public function render()
    {
        return view('livewire.admin.blog-analytics', [
            'posts' => Post::pluck('title', 'id'),
            'authors' => \App\Models\User::whereHas('posts')->pluck('name', 'id'),
        ]);
    }

    public function loadStats($from, $to)
    {
        $cacheKey = "blog_stats_{$from}_{$to}_{$this->postId}_{$this->authorId}";

        $this->stats = cache()->remember($cacheKey, 60, function () use ($from, $to) {
            $postQuery = Post::query();
            $commentQuery = Comment::query();
            $viewQuery = View::where('viewable_type', 'App\Models\Post');
            $reactionQuery = Reaction::where('reactable_type', 'App\Models\Post');
            $shareQuery = Share::where('shareable_type', 'App\Models\Post');

            if ($this->postId) {
                $postQuery->where('id', $this->postId);
                $commentQuery->where('post_id', $this->postId);
                $viewQuery->where('viewable_id', $this->postId);
                $reactionQuery->where('reactable_id', $this->postId);
                $shareQuery->where('shareable_id', $this->postId);
            }

            if ($this->authorId) {
                $postQuery->where('author_id', $this->authorId);
                $commentQuery->whereHas('post', fn($q) => $q->where('author_id', $this->authorId));
                $viewQuery->whereHasMorph('viewable', 'App\Models\Post', fn($q) => $q->where('author_id', $this->authorId));
                $reactionQuery->whereHasMorph('reactable', 'App\Models\Post', fn($q) => $q->where('author_id', $this->authorId));
                $shareQuery->whereHasMorph('shareable', 'App\Models\Post', fn($q) => $q->where('author_id', $this->authorId));
            }

            $viewsDaily = $viewQuery->clone()
                ->whereBetween('created_at', [$from, $to])
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');

            $likesPerPost = $reactionQuery->clone()
                ->where('type', 'like')
                ->selectRaw('reactable_id, COUNT(*) as total')
                ->groupBy('reactable_id')
                ->with('reactable')
                ->get()
                ->mapWithKeys(fn($item) => [$item->reactable->title => $item->total]);

            $reactionsBreakdown = $reactionQuery->clone()
                ->selectRaw('type, COUNT(*) as total')
                ->groupBy('type')
                ->pluck('total', 'type');

            $sharesPerPlatform = $shareQuery->clone()
                ->selectRaw('platform, COUNT(*) as total')
                ->groupBy('platform')
                ->pluck('total', 'platform');

            $topPostsByViews = Post::withCount('views as views_count')
                ->orderByDesc('views_count')
                ->limit(5)
                ->pluck('views_count', 'title');

            $topPostsByComments = Post::withCount('comments as comments_count')
                ->orderByDesc('comments_count')
                ->limit(5)
                ->pluck('comments_count', 'title');

            $topPostsByReactions = Post::withCount('reactions as reactions_count')
                ->orderByDesc('reactions_count')
                ->limit(5)
                ->pluck('reactions_count', 'title');

            return [
                'posts_count' => $postQuery->count(),
                'comments_count' => $commentQuery->count(),
                'pending_comments' => $commentQuery->clone()->where('status', 'pending')->count(),
                'total_likes' => $reactionQuery->clone()->where('type', 'like')->count(),
                'views_daily' => $viewsDaily,
                'likes_per_post' => $likesPerPost,
                'reactions_breakdown' => $reactionsBreakdown,
                'shares_per_platform' => $sharesPerPlatform,
                'top_posts_views' => $topPostsByViews,
                'top_posts_comments' => $topPostsByComments,
                'top_posts_reactions' => $topPostsByReactions,
            ];
        });

        $this->chartData = [
            'viewsDaily' => $this->stats['views_daily'],
            'likesPerPost' => $this->stats['likes_per_post'],
            'reactionsBreakdown' => $this->stats['reactions_breakdown'],
            'sharesPerPlatform' => $this->stats['shares_per_platform'],
            'topPostsViews' => $this->stats['top_posts_views'],
            'topPostsComments' => $this->stats['top_posts_comments'],
            'topPostsReactions' => $this->stats['top_posts_reactions'],
        ];
    }

    public function exportCsv()
    {
        $csv = "Statistiques du blog du {$this->dateFrom} au {$this->dateTo}\n";
        $csv .= "Articles,Commentaires,Commentaires en attente,J'aime\n";
        $csv .= "{$this->stats['posts_count']},{$this->stats['comments_count']},{$this->stats['pending_comments']},{$this->stats['total_likes']}\n";

        return response()->stream(
            function () use ($csv) { echo $csv; },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="blog_analytics.csv"',
            ]
        );
    }

    public function refreshStats()
    {
        cache()->forget("blog_stats_{$this->dateFrom}_{$this->dateTo}_{$this->postId}_{$this->authorId}");
        $this->loadStats($this->dateFrom, $this->dateTo);
    }

    public function updatedDateFrom($value)
    {
        $this->loadStats($this->dateFrom, $this->dateTo);
    }

    public function updatedDateTo($value)
    {
        $this->loadStats($this->dateFrom, $this->dateTo);
    }

    public function updatedPostId($value)
    {
        $this->loadStats($this->dateFrom, $this->dateTo);
    }

    public function updatedAuthorId($value)
    {
        $this->loadStats($this->dateFrom, $this->dateTo);
    }
}
--- FILE: resources/views/livewire/admin/blog-analytics.blade.php ---
<div>
    <div class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700">Du</label>
            <input type="date" wire:model="dateFrom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Au</label>
            <input type="date" wire:model="dateTo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Article</label>
            <select wire:model="postId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Tous</option>
                @foreach($posts as $id => $title)
                    <option value="{{ $id }}">{{ $title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Auteur</label>
            <select wire:model="authorId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Tous</option>
                @foreach($authors as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button wire:click="refreshStats" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 4l16 16"/></svg>
                Rafraîchir
            </button>
        </div>
        <div>
            <button wire:click="exportCsv" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V7a2 2 0 012-2h5l2 2h5a2 2 0 012 2v9a2 2 0 01-2 2z"/></svg>
                Exporter CSV
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow flex items-center">
            <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <div>
                <div class="text-sm text-gray-500">Articles</div>
                <div class="text-xl font-semibold">{{ $stats['posts_count'] ?? 0 }}</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex items-center">
            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <div>
                <div class="text-sm text-gray-500">Commentaires</div>
                <div class="text-xl font-semibold">{{ $stats['comments_count'] ?? 0 }}</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex items-center">
            <svg class="w-8 h-8 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <div class="text-sm text-gray-500">En attente</div>
                <div class="text-xl font-semibold">{{ $stats['pending_comments'] ?? 0 }}</div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow flex items-center">
            <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <div>
                <div class="text-sm text-gray-500">Total J'aime</div>
                <div class="text-xl font-semibold">{{ $stats['total_likes'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Vues par jour</h3>
            <canvas id="viewsDailyChart" width="400" height="200"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Réactions</h3>
            <canvas id="reactionsChart" width="400" height="200"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Partages par plateforme</h3>
            <canvas id="sharesChart" width="400" height="200"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-2">Top 5 articles par vues</h3>
            <canvas id="topPostsViewsChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script type="application/json" id="stats-data">{!! json_encode($chartData) !!}</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const data = JSON.parse(document.getElementById('stats-data').textContent);
        const viewsDailyLabels = Object.keys(data.viewsDaily || {});
        const viewsDailyValues = Object.values(data.viewsDaily || {});

        new Chart(document.getElementById('viewsDailyChart'), {
            type: 'line',
            data: {
                labels: viewsDailyLabels.map(d => new Date(d).toLocaleDateString('fr-FR')),
                datasets: [{
                    label: 'Vues',
                    data: viewsDailyValues,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.2)',
                    tension: 0.3
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('reactionsChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(data.reactionsBreakdown || {}),
                datasets: [{
                    data: Object.values(data.reactionsBreakdown || {}),
                    backgroundColor: ['#16a34a','#2563eb','#f59e0b','#ef4444']
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        new Chart(document.getElementById('sharesChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(data.sharesPerPlatform || {}),
                datasets: [{
                    label: 'Partages',
                    data: Object.values(data.sharesPerPlatform || {}),
                    backgroundColor: '#16a34a'
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('topPostsViewsChart'), {
            type: 'bar',
            data: {
                labels: Object.keys(data.topPostsViews || {}),
                datasets: [{
                    label: 'Vues',
                    data: Object.values(data.topPostsViews || {}),
                    backgroundColor: '#16a34a'
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    </script>
</div>
--- FILE: app/Http/Livewire/Admin/CommentManagement.php ---
<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Comment;

class CommentManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $postId = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selected = [];
    public $perPage = 15;

    protected $queryString = ['search', 'status', 'postId', 'sortField', 'sortDirection', 'perPage'];

    public function mount()
    {
        $this->fill(request()->only(['search', 'status', 'postId', 'sortField', 'sortDirection', 'perPage']));
    }

    public function render()
    {
        $comments = Comment::with(['post', 'user'])
            ->search($this->search)
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->postId, fn($q) => $q->where('post_id', $this->postId))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.comment-management', [
            'comments' => $comments,
            'posts' => \App\Models\Post::pluck('title', 'id'),
        ]);
    }

    public function approve($id)
    {
        Comment::findOrFail($id)->update(['status' => 'approved']);
        $this->emit('toast', 'Commentaire approuvé.');
    }

    public function reject($id)
    {
        Comment::findOrFail($id)->update(['status' => 'rejected']);
        $this->emit('toast', 'Commentaire rejeté.');
    }

    public function markSpam($id)
    {
        Comment::findOrFail($id)->update(['status' => 'spam']);
        $this->emit('toast', 'Commentaire marqué comme spam.');
    }

    public function delete($id)
    {
        Comment::findOrFail($id)->delete();
        $this->emit('toast', 'Commentaire supprimé.');
    }

    public function bulkDelete()
    {
        Comment::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->emit('toast', 'Commentaires supprimés.');
    }

    public function openDetails($id)
    {
        $this->emit('openCommentDrawer', $id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
--- FILE: resources/views/livewire/admin/comment-management.blade.php ---
<div>
    <div class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700">Recherche</label>
            <input type="text" wire:model.debounce.300ms="search" placeholder="Rechercher..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Statut</label>
            <select wire:model="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Tous</option>
                <option value="pending">En attente</option>
                <option value="approved">Approuvé</option>
                <option value="rejected">Rejeté</option>
                <option value="spam">Spam</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Article</label>
            <select wire:model="postId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Tous</option>
                @foreach($posts as $id => $title)
                    <option value="{{ $id }}">{{ $title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Par page</label>
            <select wire:model="perPage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>
        <div>
            <button wire:click="bulkDelete" onclick="confirm('Supprimer la sélection ?') || event.stopImmediatePropagation()" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Supprimer la sélection
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">
                        <input type="checkbox" wire:model="selected" value="{{ $comment->id ?? '' }}" class="mr-2">
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Commentaire</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Article</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Auteur</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Statut</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Likes</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Reports</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">IP</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Date</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr class="border-t">
                        <td class="px-4 py-2"><input type="checkbox" wire:model="selected" value="{{ $comment->id }}"></td>
                        <td class="px-4 py-2 text-sm">{{ \Str::limit($comment->content, 50) }}</td>
                        <td class="px-4 py-2 text-sm">{{ $comment->post->title }}</td>
                        <td class="px-4 py-2 text-sm">{{ $comment->user->name ?? 'Anonyme' }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                @if($comment->status === 'approved') bg-green-100 text-green-800
                                @elseif($comment->status === 'rejected') bg-red-100 text-red-800
                                @elseif($comment->status === 'spam') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm">{{ $comment->likes_count ?? 0 }}</td>
                        <td class="px-4 py-2 text-sm">{{ $comment->reports_count ?? 0 }}</td>
                        <td class="px-4 py-2 text-sm">{{ $comment->ip_address }}</td>
                        <td class="px-4 py-2 text-sm">{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 text-sm flex gap-2">
                            <button wire:click="openDetails({{ $comment->id }})" class="text-blue-600 hover:underline">Détails</button>
                            <button wire:click="approve({{ $comment->id }})" class="text-green-600 hover:underline">Approuver</button>
                            <button wire:click="reject({{ $comment->id }})" class="text-yellow-600 hover:underline">Rejeter</button>
                            <button wire:click="markSpam({{ $comment->id }})" class="text-orange-600 hover:underline">Spam</button>
                            <button wire:click="delete({{ $comment->id }})" onclick="confirm('Supprimer ?') || event.stopImmediatePropagation()" class="text-red-600 hover:underline">Supprimer</button>
                        </td>
                    </tr>
                @endempty
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $comments->links() }}
    </div>
</div>
--- FILE: app/Http/Livewire/Admin/CommentDrawer.php ---
<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Comment;

class CommentDrawer extends Component
{
    public $commentId;
    public $comment;
    public $replyContent = '';
    public $history = [];

    protected $listeners = ['openCommentDrawer' => 'open'];

    public function open($id)
    {
        $this->commentId = $id;
        $this->comment = Comment::with(['post', 'user', 'replies.user', 'parent'])->findOrFail($id);
        $this->history = []; // todo: audit log if available
    }

    public function close()
    {
        $this->reset(['commentId', 'comment', 'replyContent', 'history']);
    }

    public function reply()
    {
        Comment::create([
            'post_id' => $this->comment->post_id,
            'user_id' => auth()->id(),
            'parent_id' => $this->comment->id,
            'content' => $this->replyContent,
            'status' => 'approved',
            'ip_address' => request()->ip(),
        ]);
        $this->replyContent = '';
        $this->comment = Comment::with(['post', 'user', 'replies.user', 'parent'])->findOrFail($this->commentId);
        $this->emit('toast', 'Réponse ajoutée.');
    }

    public function render()
    {
        return view('livewire.admin.comment-drawer');
    }
}
--- FILE: resources/views/livewire/admin/comment-drawer.blade.php ---
<div x-data="{ open: @entangle('commentId').defer }" x-show="open" x-cloak class="fixed inset-0 z-50 overflow-hidden">
    <div class="absolute inset-0 bg-gray-500 bg-opacity-75" x-on:click="close()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-xl bg-white shadow-xl flex flex-col">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Détails du commentaire</h2>
            <button x-on:click="close()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-4">
            @if($comment)
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Article</div>
                    <div class="font-medium">{{ $comment->post->title }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Auteur</div>
                    <div class="font-medium">{{ $comment->user->name ?? 'Anonyme' }} ({{ $comment->ip_address }})</div>
                </div>
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Commentaire</div>
                    <div class="prose prose-sm">{{ $comment->content }}</div>
                </div>
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Statut</div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                        @if($comment->status === 'approved') bg-green-100 text-green-800
                        @elseif($comment->status === 'rejected') bg-red-100 text-red-800
                        @elseif($comment->status === 'spam') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($comment->status) }}
                    </span>
                </div>
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Réponses</div>
                    @foreach($comment->replies as $reply)
                        <div class="mt-2 p-2 bg-gray-50 rounded">
                            <div class="text-xs text-gray-500">{{ $reply->user->name ?? 'Anonyme' }} - {{ $reply->created_at->format('d/m/Y H:i') }}</div>
                            <div class="text-sm">{{ $reply->content }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-4">
                    <textarea wire:model="replyContent" rows="3" placeholder="Répondre..." class="w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    <button wire:click="reply" class="mt-2 inline-flex items-center px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700">Répondre</button>
                </div>
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Historique</div>
                    <div class="text-sm text-gray-600">Aucun historique disponible.</div>
                </div>
            @endif
        </div>
    </div>
</div>
--- FILE: app/Models/Comment.php ---
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'parent_id', 'content', 'status', 'ip_address'];

    const STATUSES = ['pending', 'approved', 'rejected', 'spam'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByPost($query, $postId)
    {
        return $query->where('post_id', $postId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('content', 'like', "%{$term}%")
              ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$term}%"))
              ->orWhereHas('post', fn($q) => $q->where('title', 'like', "%{$term}%"));
        });
    }
}
--- FILE: app/Models/View.php ---
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = ['viewable_type', 'viewable_id', 'user_id', 'ip_address', 'user_agent', 'session_id', 'created_at'];

    public $timestamps = false;

    protected $casts = ['created_at' => 'datetime'];

    public function viewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
--- FILE: app/Models/Reaction.php ---
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = ['user_id', 'reactable_type', 'reactable_id', 'type'];

    public function reactable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
--- FILE: app/Models/Share.php ---
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $fillable = ['shareable_type', 'shareable_id', 'user_id', 'platform', 'ip_address', 'user_agent', 'created_at'];

    public $timestamps = false;

    protected $casts = ['created_at' => 'datetime'];

    public function shareable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
--- FILE: database/factories/CommentFactory.php ---
<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'post_id' => Post::inRandomOrder()->first()->id ?? Post::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? null,
            'parent_id' => null,
            'content' => $this->faker->sentence(12),
            'status' => $this->faker->randomElement(Comment::STATUSES),
            'ip_address' => $this->faker->ipv4(),
            'created_at' => $this->faker->dateTimeBetween('-30 days'),
            'updated_at' => now(),
        ];
    }
}
--- FILE: database/seeders/CommentSeeder.php ---
<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::factory()->count(200)->create();
    }
}
--- FILE: routes/web.php ---
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\BlogAnalytics;
use App\Http\Livewire\Admin\CommentManagement;

Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::get('/blog/analytics', BlogAnalytics::class)->name('admin.blog.analytics');
    Route::get('/comments', CommentManagement::class)->name('admin.comments.index');
});
--- FILE: app/Http/Controllers/Admin/ExportController.php ---
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportBlogAnalyticsCsv($data)
    {
        // delegated to Livewire component for simplicity
    }
}
--- FILE: database/migrations/2025_11_17_000001_add_indexes_to_comments_table.php ---
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
            $table->index('post_id');
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['post_id']);
        });
    }
};
--- FILE: tests/Feature/AdminBlogAnalyticsTest.php ---
<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class AdminBlogAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_analytics_page_returns_200()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create();
        Comment::factory()->count(10)->create();

        $response = $this->actingAs($user)->get('/admin/blog/analytics');

        $response->assertStatus(200);
    }
}
---

Install checklist:
- composer install
- npm install && npm run build
- php artisan migrate
- php artisan db:seed --class=CommentSeeder
- Add Livewire + Alpine via docs if not present
- Register routes file already included
- Run tests: php artisan test
