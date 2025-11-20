<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'status',
        'ip_address',
        'user_agent',
        'likes_count',
        'reports_count',
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'reports_count' => 'integer',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_SPAM = 'spam';

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->approved()
                    ->latest();
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(CommentReport::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeByPost($query, $postId)
    {
        return $query->where('post_id', $postId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function incrementLikes(): void
    {
        $this->increment('likes_count');
    }

    public function reportBy(User $user, string $reason): void
    {
        $this->reports()->create([
            'user_id' => $user->id,
            'reason' => $reason,
            'ip_address' => request()->ip(),
        ]);

        $this->increment('reports_count');
    }

    public function isOwner(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    public function canBeEditedBy(User $user): bool
    {
        return $this->isOwner($user) || $user->hasRole('admin');
    }

    public function getDepthAttribute(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('content', 'like', '%' . $search . '%')
                // Recherche par nom ou email de l'utilisateur associé
                ->orWhereHas('user', function ($q_user) use ($search) {
                    $q_user->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                // Recherche par nom ou email de l'auteur non-utilisateur (si ces colonnes existent)
                ->orWhere('author_name', 'like', '%' . $search . '%')
                ->orWhere('author_email', 'like', '%' . $search . '%');
        });
    }
}
