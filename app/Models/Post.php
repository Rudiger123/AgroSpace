<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_id',
        'category_id',
        'is_featured',
        'published',
        'published_at',
        'meta_title',
        'meta_description',
        'views_count',
        'likes_count',
        'comments_count',
        'shares_count',
        'reading_time',
        'status',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'shares_count' => 'integer',
        'is_featured' => 'boolean'
    ];

    protected $appends = ['reading_time', 'formatted_published_date'];

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_SCHEDULED = 'scheduled';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 150);
            }
            if (empty($post->reading_time)) {
                $post->reading_time = $post->calculateReadingTime();
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if ($post->isDirty('content') && empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 150);
            }
        });
    }

    public function calculateReadingTime(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200)); // 200 mots par minute
    }

    public function getReadingTimeAttribute(): int
    {
        return $this->calculateReadingTime();
    }

    public function getFormattedPublishedDateAttribute(): string
    {
        return $this->published_at ? $this->published_at->format('d M Y') : '';
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('published', false);
    }

    public function scopeScheduled($query)
    {
        return $query->where('published', true)
                    ->where('published_at', '>', now());
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc')
                    ->orderBy('likes_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag')
                    ->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function shares(): MorphMany
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function incrementViews(?User $user = null): void
    {
        $viewData = [
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($user) {
            $viewData['user_id'] = $user->id;
        }

        $this->views()->create($viewData);
        $this->increment('views_count');
    }

    public function toggleReaction(User $user, string $type): void
    {
        $existingReaction = $this->reactions()
            ->where('user_id', $user->id)
            ->where('type', $type)
            ->first();

        if ($existingReaction) {
            $existingReaction->delete();
            $this->decrement('likes_count');
        } else {
            $this->reactions()->create([
                'user_id' => $user->id,
                'type' => $type,
            ]);
            $this->increment('likes_count');
        }
    }

    public function hasLiked(User $user): bool
    {
        return $this->reactions()
            ->where('user_id', $user->id)
            ->where('type', 'like')
            ->exists();
    }

    public function recordShare(string $platform, ?User $user = null): void
    {
        $shareData = [
            'platform' => $platform,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($user) {
            $shareData['user_id'] = $user->id;
        }

        $this->shares()->create($shareData);
        $this->increment('shares_count');
    }

    public function getRelatedPosts(int $limit = 3)
    {
        return Post::published()
            ->where('id', '!=', $this->id)
            ->where(function ($query) {
                $query->where('category_id', $this->category_id)
                    ->orWhereHas('tags', function ($q) {
                        $q->whereIn('tags.id', $this->tags->pluck('id'));
                    });
            })
            ->limit($limit)
            ->get();
    }
}
