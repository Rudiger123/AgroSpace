<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    // États du composant
    public $showCreateModal = false;
    public $showEditModal = false;
    public $selectedPost = null;
    public $showDeleteModal = false;
    public $showPreviewModal = false;

    // Champs du formulaire
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $category_id = '';
    public $tags = [];
    public $featured_image = null;
    public $existing_image = '';
    public $published = false;
    public $published_at = '';
    public $meta_title = '';
    public $meta_description = '';

    // Filtres
    public $search = '';
    public $filterCategory = '';
    public $filterStatus = '';
    public $filterAuthor = '';
    public $sortBy = 'published_at';
    public $sortDirection = 'desc';

    protected function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'slug' => 'required|string|unique:posts,slug,' . ($this->selectedPost?->id ?? 'NULL'),
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string|min:10',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
        ];
    }

    protected $messages = [
        'title.required' => 'Le titre est obligatoire.',
        'title.min' => 'Le titre doit contenir au moins 3 caractères.',
        'slug.required' => 'Le slug est obligatoire.',
        'slug.unique' => 'Ce slug est déjà utilisé.',
        'content.required' => 'Le contenu est obligatoire.',
        'content.min' => 'Le contenu doit contenir au moins 10 caractères.',
        'featured_image.image' => 'L\'image doit être un fichier image valide.',
        'featured_image.max' => 'L\'image ne doit pas dépasser 2 Mo.',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'title', 'slug', 'excerpt', 'content', 'category_id', 'tags',
            'featured_image', 'existing_image', 'published', 'published_at',
            'meta_title', 'meta_description', 'selectedPost'
        ]);

        $this->published_at = now()->format('Y-m-d\TH:i');
    }

    public function openCreateModal()
    {
        $this->authorize('create', Post::class);
        $this->showCreateModal = true;
        $this->resetForm();
        $this->dispatch('focus-title');
    }

    public function openEditModal($postId)
    {
        $post = Post::findOrFail($postId);
        $this->authorize('update', $post);

        $this->selectedPost = $post;
        $this->showEditModal = true;

        // Remplir le formulaire
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->excerpt = $post->excerpt;
        $this->content = $post->content;
        $this->category_id = $post->category_id;
        $this->tags = $post->tags->pluck('id')->toArray();
        $this->existing_image = $post->featured_image;
        $this->published = $post->published;
        $this->published_at = $post->published_at?->format('Y-m-d\TH:i') ?? '';
        $this->meta_title = $post->meta_title;
        $this->meta_description = $post->meta_description;

    }

    public function generateSlug()
    {
        if (empty($this->slug) && !empty($this->title)) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $imagePath = $this->existing_image;

            // Gérer l'upload de l'image
            if ($this->featured_image) {
                if ($this->existing_image) {
                    Storage::disk('public')->delete($this->existing_image);
                }
                $imagePath = $this->featured_image->store('blog/images', 'public');
            }

            $postData = [
                'title' => $this->title,
                'slug' => $this->slug,
                'excerpt' => $this->excerpt ?: Str::limit(strip_tags($this->content), 150),
                'content' => $this->content,
                'category_id' => $this->category_id ?: null,
                'featured_image' => $imagePath,
                'published' => $this->published,
                'published_at' => $this->published ? ($this->published_at ?: now()) : null,
                'meta_title' => $this->meta_title ?: $this->title,
                'meta_description' => $this->meta_description ?: Str::limit(strip_tags($this->content), 160),
                'status' => $this->published ? 'published' : 'draft',
            ];

            if ($this->showCreateModal) {
                $postData['author_id'] = Auth::id();
                $this->selectedPost = Post::create($postData);
                $message = 'Article créé avec succès !';
            }
            if($this->showEditModal) {
                $this->selectedPost->update($postData);
                $message = 'Article mis à jour avec succès !';
            }

            // Synchroniser les tags
            if (!empty($this->tags)) {
                $this->selectedPost->tags()->sync($this->tags);
            }
            $this->closeModals();
            $this->resetForm();

            $this->dispatch('toast',[
                'type' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            report($e);
            session()->flash('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    public function confirmDelete($postId)
    {
        $this->selectedPost = Post::findOrFail($postId);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if (!$this->selectedPost) {
            return;
        }

        $this->authorize('delete', $this->selectedPost);

        try {
            if ($this->selectedPost->featured_image) {
                Storage::disk('public')->delete($this->selectedPost->featured_image);
            }

            $this->selectedPost->delete();
            $this->closeModals();

            $message ='Article supprimé avec succès !';

            $this->dispatch('toast',[
                'type' => 'success',
                'message' => $message
            ]);


        } catch (\Exception $e) {
            report($e);
            session()->flash('error', 'Erreur lors de la suppression de l\'article.');
        }
    }

    public function closeModals()
    {
        $this->showDeleteModal = false;
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showPreviewModal = false;
        $this->selectedPost = null;
        $this->resetForm();
    }

    public function preview($postId)
    {
        $this->selectedPost = Post::findOrFail($postId);
        $this->showPreviewModal = true;
    }

    public function togglePublish($postId)
    {
        $post = Post::findOrFail($postId);
        $this->authorize('update', $post);

        try {
            $post->published = !$post->published;
            $post->published_at = $post->published ? now() : null;
            $post->status = $post->published ? 'published' : 'draft';
            $post->save();

            $message = $post->published ? 'Article publié !' : 'Article dépublié !';
            $this->dispatch('toast',[
                'type' => 'success',
                'message' => $message
            ]);

        } catch (\Exception $e) {
            report($e);
            session()->flash('error', 'Erreur lors de la mise à jour du statut.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function updatedFilterAuthor()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortBy = $field;
    }

    public function getPostsProperty()
    {
        $query = Post::with(['author', 'category', 'tags']);

        // Recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre par catégorie
        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }

        // Filtre par statut
        if ($this->filterStatus) {
            if ($this->filterStatus === 'published') {
                $query->where('published', true);
            } elseif ($this->filterStatus === 'draft') {
                $query->where('published', false);
            } elseif ($this->filterStatus === 'scheduled') {
                $query->where('published_at', '>', now());
            }
        }

        // Filtre par auteur
        if ($this->filterAuthor && Auth::user()->isAdmin()) {
            $query->where('author_id', $this->filterAuthor);
        } elseif (!Auth::user()->isAdmin()) {
            // Les non-admins ne voient que leurs propres articles
            $query->where('author_id', Auth::id());
        }

        return $query->orderBy($this->sortBy, $this->sortDirection)
                    ->paginate(10);
    }

    public function getCategoriesProperty()
    {
        return Category::where('is_active', true)->get();
    }

    public function getAllTagsProperty()
    {
        return Tag::where('is_active', true)->orderBy('name')->get();
    }

    public function getAuthorsProperty()
    {
        if (Auth::user()->isAdmin()) {
            return \App\Models\User::whereHas('posts')->get();
        }
        return collect();
    }

    public function render()
    {
        return view('livewire.blog.blog-manager', [
            'posts' => $this->posts,
            'categories' => $this->categories,
            'allTags' => $this->allTags,
            'authors' => $this->authors,
        ])->layout('layouts.app', [
            'title' => 'Gestion du Blog',
            'description' => 'Gérez vos articles de blog',
        ]);
    }
}