<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ckeditor\CKEditor;

#[Layout('layouts.app')]
class BlogManager extends Component
{
    use WithPagination, WithFileUploads;

    // États du formulaire
    public $mode = 'list'; // list, create, edit
    public $selectedPost = null;
    
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
    
    // Validation
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

    #[On('create-post')]
    public function create()
    {
        $this->authorize('create', Post::class);
        $this->mode = 'create';
        $this->resetForm();
        $this->dispatch('focus-title');
    }

    #[On('edit-post')]
    public function edit($postId)
    {
        $post = Post::findOrFail($postId);
        $this->authorize('update', $post);
        
        $this->selectedPost = $post;
        $this->mode = 'edit';
        
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
        
        $this->dispatch('focus-title');
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
                // Supprimer l'ancienne image si elle existe
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
            
            if ($this->mode === 'create') {
                $postData['author_id'] = Auth::id();
                $this->selectedPost = Post::create($postData);
                $message = 'Article créé avec succès !';
            } else {
                $this->selectedPost->update($postData);
                $message = 'Article mis à jour avec succès !';
            }
            
            // Synchroniser les tags
            if (!empty($this->tags)) {
                $this->selectedPost->tags()->sync($this->tags);
            }
            
            $this->mode = 'list';
            $this->resetForm();
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => $message
            ]);
            
            $this->dispatch('post-saved');
            
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Une erreur est survenue. Veuillez réessayer.'
            ]);
        }
    }

    #[On('delete-post')]
    public function delete($postId)
    {
        $post = Post::findOrFail($postId);
        $this->authorize('delete', $post);
        
        try {
            // Supprimer l'image associée
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $post->delete();
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Article supprimé avec succès !'
            ]);
            
            $this->dispatch('post-deleted');
            
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression de l\'article.'
            ]);
        }
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
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erreur lors de la mise à jour du statut.'
            ]);
        }
    }

    public function cancel()
    {
        $this->mode = 'list';
        $this->resetForm();
    }

    public function getPostsProperty()
    {
        $query = Post::with(['author', 'category', 'tags'])
            ->search($this->search);
            
        if ($this->filterCategory) {
            $query->where('category_id', $this->filterCategory);
        }
        
        if ($this->filterStatus) {
            if ($this->filterStatus === 'published') {
                $query->published();
            } elseif ($this->filterStatus === 'draft') {
                $query->draft();
            } elseif ($this->filterStatus === 'scheduled') {
                $query->scheduled();
            }
        }
        
        if ($this->filterAuthor && Auth::user()->isAdmin()) {
            $query->where('author_id', $this->filterAuthor);
        } else {
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
        return Tag::active()->popular()->get();
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
        ])
        ->layout('layouts.app', [
            'title' => 'Gestion du Blog',
            'description' => 'Gérez vos articles de blog',
        ]);
    }
}