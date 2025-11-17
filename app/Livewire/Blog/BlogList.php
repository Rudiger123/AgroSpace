<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

/**
 * Composant Livewire - Liste des articles du blog AgroSpace
 *
 * Design moderne avec hero section et filtres dynamiques
 */
#[Layout('layouts.main')]
class BlogList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'agrospace-pagination';

    // Propriétés publiques (synchronisées avec l'URL)
    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'category')]
    public ?string $selectedCategory = 'tous';

    #[Url(as: 'tag')]
    public ?string $selectedTag = null;

    #[Url(as: 'sort')]
    public string $sortBy = 'recent'; // recent, popular, likes

    public int $perPage = 9;

    /**
     * Réinitialiser la pagination lors des changements
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSelectedTag()
    {
        $this->resetPage();
    }

    /**
     * Computed property pour l'article vedette
     */
    #[Computed]
    public function featuredPost()
    {
        return Post::with(['author', 'category', 'tags'])
            ->published()
            ->where('is_featured', true)
            ->latest('published_at')
            ->first()
            ?? Post::with(['author', 'category', 'tags'])
                ->published()
                ->first();
    }

    /**
     * Computed property pour les catégories
     */
    #[Computed]
    public function categories()
    {
        return Category::where('type', 'post')
            ->where('is_active', true)
            ->with(['posts' => function ($query) {
                $query->where('status', 'published')
                      ->where('published_at', '<=', now());
            }])
            ->orderBy('name')
            ->get();
    }

    /**
     * Computed property pour les tags populaires
     */
    #[Computed]
    public function popularTags()
    {
        $popularTags = Tag::withCount(['posts' => function ($query) {
            $query->where('status', 'published')
                  ->where('published_at', '<=', now());
        }])
        // ->having('posts_count', '>', 0)
        ->orderBy('posts_count', 'desc')
        ->limit(15)
        ->get();
        return $popularTags;
    }

    /**
     * Computed property pour les articles récents (sidebar)
     */
    #[Computed]
    public function recentPosts()
    {
        return Post::with('category')
            ->published()
            ->latest('published_at')
            ->limit(5)
            ->get();
    }

    /**
     * Computed property pour les articles
     */
    #[Computed]
    public function posts()
    {
        $query = Post::with(['author', 'category', 'tags'])
            ->published();

        // Recherche
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('excerpt', 'like', "%{$this->search}%")
                  ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        // Filtre par catégorie
        if ($this->selectedCategory && $this->selectedCategory !== 'tous') {
            $query->where('category_id', $this->selectedCategory);
        }

        // Filtre par tag
        if ($this->selectedTag) {
            $query->whereHas('tags', function ($q) {
                $q->where('tags.id', $this->selectedTag);
            });
        }

        // Tri
        switch ($this->sortBy) {
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'likes':
                $query->orderBy('likes_count', 'desc');
                break;
            default:
                $query->latest('published_at');
                break;
        }

        return $query->paginate($this->perPage);
    }

    /**
     * Computed property pour les statistiques
     */
    #[Computed]
    public function stats()
    {
        return [
            'total_posts' => Post::published()->count(),
            'categories_count' => $this->categories->count(),
            'tags_count' => $this->popularTags->count(),
            // Articles
            'total_posts' => Post::where('published', true)->count(),
            'posts_this_month' => Post::where('published', true)
                ->whereMonth('published_at', now()->month)
                ->whereYear('published_at', now()->year)
                ->count(),
            
            // Vues
            'total_views' => Post::sum('views_count'),
            'views_today' => View::whereDate('created_at', today())->count(),
            
            // Commentaires
            'total_comments' => Comment::count(),
            'approved_comments' => Comment::where('status', 'approved')->count(),
            
            // Réactions (Likes)
            'total_likes' => Post::sum('likes_count'),
            
            // Partages
            'total_shares' => Post::sum('shares_count'),
            
            // Tags et Catégories
            'tags_count' => Tag::where('is_active', true)->count(),
            'categories_count' => Category::where('is_active', true)->count(),
            
            // Auteurs actifs (ayant publié au moins 1 article)
            'active_authors' => Post::where('published', true)
                ->distinct('author_id')
                ->count('author_id'),
        ];
    }

    /**
     * Sélectionner une catégorie
     */
    public function selectCategory(string $categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->selectedTag = null;
        $this->resetPage();
    }

    /**
     * Sélectionner un tag
     */
    public function selectTag(int $tagId)
    {
        $this->selectedTag = $tagId;
        $this->resetPage();
    }

    /**
     * Réinitialiser tous les filtres
     */
    public function resetFilters()
    {
        $this->reset(['search', 'selectedCategory', 'selectedTag', 'sortBy']);
        $this->selectedCategory = 'tous';
        $this->resetPage();
    }

    /**
     * Render du composant
     */
    public function render()
    {
        return view('livewire.blog.blog-list', [
            'featuredPost' => $this->featuredPost,
            'posts' => $this->posts,
            'categories' => $this->categories,
            'popularTags' => $this->popularTags,
            'recentPosts' => $this->recentPosts,
            'stats' => $this->stats,
        ]);
    }
}
