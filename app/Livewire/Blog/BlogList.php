<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.main')]
class BlogList extends Component
{
    use WithPagination;

    // Filtres et recherche
    public $search = '';
    public $category = '';
    public $tag = '';
    public $sortBy = 'published_at';
    public $sortDirection = 'desc';
    public $perPage = 12;

    // Affichage
    public $viewMode = 'grid'; // grid, list
    public $featuredPost = null;

    public function mount()
    {
        // Récupérer l'article en vedette (le plus récent ou le plus populaire)
        $this->featuredPost = Post::published()
            ->with(['author', 'category'])
            ->orderBy('views_count', 'desc')
            ->orderBy('published_at', 'desc')
            ->first();
    }

    #[On('search-updated')]
    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    #[On('filter-updated')]
    public function updateFilter($type, $value)
    {
        if ($type === 'category') {
            $this->category = $value;
        } elseif ($type === 'tag') {
            $this->tag = $value;
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'category', 'tag']);
        $this->resetPage();
    }

    public function setSort($field, $direction)
    {
        $this->sortBy = $field;
        $this->sortDirection = $direction;
        $this->resetPage();
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'grid' ? 'list' : 'grid';
    }

    public function getPostsProperty()
    {
        $query = Post::published()
            ->with(['author', 'category', 'tags'])
            ->search($this->search);

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->tag) {
            $query->whereHas('tags', function ($q) {
                $q->where('tags.id', $this->tag);
            });
        }

        // Trier selon les préférences
        switch ($this->sortBy) {
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            case 'likes':
                $query->orderBy('likes_count', 'desc');
                break;
            case 'recent':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }

        return $query->paginate($this->perPage);
    }

    public function getCategoriesProperty()
    {
        return Category::where("is_active", true)
            //->withCount(['posts' => function ($query) {$query->published();}])
            //->ordered()
            ->get();
    }

    public function getPopularTagsProperty()
    {
        return Tag::active()
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->orderBy('posts_count', 'desc')
            ->limit(20)
            ->get();
    }

    public function getRecentPostsProperty()
    {
        return Post::published()
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function getPopularPostsProperty()
    {
        return Post::published()
            ->with('category')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.blog.blog-list', [
            'posts' => $this->posts,
            'categories' => $this->categories,
            'popularTags' => $this->popularTags,
            'recentPosts' => $this->recentPosts,
            'popularPosts' => $this->popularPosts,
        ])
        ->layout('layouts.main', [
            'title' => 'Blog - AgroSpace',
            'description' => 'Découvrez les actualités et innovations du monde agropastoral',
        ]);
    }
}
