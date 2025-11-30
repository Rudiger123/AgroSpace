<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.main')]
class BlogShowEnhanced extends Component
{
    // Propriétés principales
    public Post $post;

    // Commentaires
    #[Validate('required|string|min:3|max:1000')]
    public string $commentContent = '';
    public ?int $replyingTo = null;
    public bool $showAllComments = false;

    // Réactions et interactions
    public bool $isLiked = false;
    public int $likesCount = 0;
    public int $commentsCount = 0;
    public int $viewsCount = 0;
    public int $sharesCount = 0;

    // Suivi de lecture
    public int $readingProgress = 0;
    public int $timeSpent = 0;
    public bool $hasRead = false;

    // Partage
    public bool $showShareModal = false;
    public string $shareUrl = '';

    // Navigation
    public ?Post $previousPost = null;
    public ?Post $nextPost = null;

    // Recommandations
    public $relatedPosts = [];

    public function mount($slug = null)
    {
        // Récupérer l'article
        if ($slug) {
            $this->post = Post::with([
                'author',
                'category',
                'tags',
                'comments' => function ($query) {
                    $query->with(['user', 'replies.user'])
                        ->approved()
                        ->latest();
                }
            ])
                ->where('slug', $slug)
                ->published()
                ->firstOrFail();
        } else {
            // Article le plus récent si aucun slug
            $this->post = Post::with([
                'author',
                'category',
                'tags',
                'comments' => function ($query) {
                    $query->with(['user', 'replies.user'])
                        ->approved()
                        ->latest();
                }
            ])
                ->published()
                ->latest('published_at')
                ->firstOrFail();
        }

        // Initialiser les compteurs
        $this->likesCount = $this->post->likes_count;
        $this->commentsCount = $this->post->comments_count;
        $this->viewsCount = $this->post->views_count;
        $this->sharesCount = $this->post->shares_count;

        // Vérifier si l'utilisateur a aimé l'article
        if (Auth::check()) {
            $this->isLiked = $this->post->hasLiked(Auth::user());
        }

        // Incrémenter les vues
        $this->post->incrementViews(Auth::user());
        $this->viewsCount++;

        // Récupérer les articles précédent et suivant
        $this->previousPost = Post::published()
            ->where('published_at', '<', $this->post->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $this->nextPost = Post::published()
            ->where('published_at', '>', $this->post->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        // Récupérer les articles liés
        $this->relatedPosts = $this->post->getRelatedPosts(4);

        // Générer l'URL de partage
        $this->shareUrl = route('blog.show', $this->post->slug);
    }

    #[Computed]
    public function comments()
    {
        $query = $this->post->comments()
            ->with([
                'user',
                'replies' => function ($query) {
                    $query->with('user')
                        ->approved()
                        ->latest();
                }
            ])
            ->approved();

        if (!$this->showAllComments) {
            $query->limit(5);
        }

        return $query->latest()->get();
    }

    public function addComment()
    {
        $this->validate([
            'commentContent' => 'required|string|min:3|max:1000',
        ], [
            'commentContent.required' => __('blog.validation.comment_required'),
            'commentContent.min' => __('blog.validation.comment_min'),
            'commentContent.max' => __('blog.validation.comment_max'),
        ]);

        if (!Auth::check()) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => __('blog.errors.auth_required')
            ]);
            return;
        }

        // Protection contre le spam
        if ($this->isSpam()) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => __('blog.errors.spam_detected')
            ]);
            return;
        }

        try {
            $comment = Comment::create([
                'post_id' => $this->post->id,
                'user_id' => Auth::id(),
                'parent_id' => $this->replyingTo,
                'content' => trim($this->commentContent),
                'status' => Comment::STATUS_APPROVED,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $this->post->increment('comments_count');
            $this->commentsCount++;

            $this->reset(['commentContent', 'replyingTo']);

            $this->dispatch('comment-added');
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => __('blog.errors.comment_error')
            ]);
        }
    }

    public function replyTo(int $commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment || $comment->post_id !== $this->post->id) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => __('blog.errors.comment_not_found')
            ]);
            return;
        }

        $this->replyingTo = $commentId;
        $this->dispatch('focusCommentInput');
    }

    public function cancelReply()
    {
        $this->reset('replyingTo');
    }

    #[On('toggle-like')]
    public function toggleLike()
    {
        if (!Auth::check()) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => __('blog.errors.auth_required')
            ]);
            return;
        }

        try {
            $this->post->toggleReaction(Auth::user(), 'like');
            $this->isLiked = !$this->isLiked;
            $this->likesCount = $this->isLiked ? $this->likesCount + 1 : $this->likesCount - 1;
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => __('blog.errors.reaction_error')
            ]);
        }
    }

    public function share(string $platform)
    {
        $validPlatforms = ['facebook', 'twitter', 'linkedin', 'whatsapp', 'email'];

        if (!in_array($platform, $validPlatforms)) {
            return;
        }

        try {
            /* 1  –  comptabiliser */
            $this->post->recordShare($platform, Auth::user());
            $this->sharesCount++;

            /* 2  –  construire l'URL de partage */
            $postUrl   = route('blog.show', $this->post->slug, true);
            $postTitle = $this->post->title;

            $shareLinks = [
                'facebook'  => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($postUrl),
                'twitter'   => 'https://twitter.com/intent/tweet?url='.urlencode($postUrl).'&text='.urlencode($postTitle),
                'linkedin'  => 'https://www.linkedin.com/sharing/share-offsite/?url='.urlencode($postUrl),
                'whatsapp'  => 'https://wa.me/?text='.urlencode($postTitle.' '.$postUrl),
                'email'     => 'mailto:?subject='.urlencode($postTitle).'&body='.urlencode($postUrl),
            ];

            /* 3  –  demander au navigateur d'ouvrir le lien */
            $this->dispatch('openShareWindow', url: $shareLinks[$platform]);

            /* 4  –  feedback */
            $this->dispatch(
                'toast',
                type: 'success',
                message: __('blog.success.shared')
            );
        } catch (\Exception $e) {
            report($e);
            $this->dispatch(
                'toast',
                type: 'error',
                message: __('blog.errors.share_error')
            );
        }
    }

    public function updateReadingProgress(int $progress, int $time)
    {
        $this->readingProgress = min(100, max(0, $progress));
        $this->timeSpent = $time;

        // Si l'utilisateur a lu au moins 80%, enregistrer
        if ($progress >= 80 && !$this->hasRead && Auth::check()) {
            try {
                Auth::user()->readPosts()->syncWithoutDetaching([
                    $this->post->id => [
                        'read_at' => now(),
                        'time_spent' => $time,
                        'progress' => $progress
                    ]
                ]);
                $this->hasRead = true;
            } catch (\Exception $e) {
                report($e);
            }
        }
    }

    protected function isSpam(): bool
    {
        $content = strtolower($this->commentContent);
        $spamWords = [
            'spam', 'viagra', 'casino', 'bitcoin', 'click here',
            'buy now', 'free money', 'get rich', 'weight loss'
        ];

        $spamCount = 0;
        foreach ($spamWords as $word) {
            if (strpos($content, $word) !== false) {
                $spamCount++;
            }
        }

        return $spamCount > 2;
    }

    public function render()
    {
        return view('livewire.blog.blog-show-enhanced', [
            'post' => $this->post,
            'comments' => $this->comments,
            'previousPost' => $this->previousPost,
            'nextPost' => $this->nextPost,
            'relatedPosts' => $this->relatedPosts,
            'shareUrl' => $this->shareUrl,
        ])
        ->layout('layouts.main', [
            'title' => $this->post->meta_title ?? $this->post->title,
            'description' => $this->post->meta_description ?? $this->post->excerpt,
            'canonical' => route('blog.show', $this->post->slug),
            'og' => [
                'title' => $this->post->title,
                'description' => $this->post->excerpt,
                'image' => $this->post->featured_image,
                'type' => 'article',
                'author' => $this->post->author->name,
                'published_time' => $this->post->published_at?->toIso8601String(),
                'modified_time' => $this->post->updated_at?->toIso8601String(),
            ],
            'twitter' => [
                'card' => 'summary_large_image',
                'title' => $this->post->title,
                'description' => $this->post->excerpt,
                'image' => $this->post->featured_image,
            ]
        ]);
    }
}
