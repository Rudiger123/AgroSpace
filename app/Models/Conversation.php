<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'last_message_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Participants de la conversation
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('joined_at', 'last_read_at')
            ->withTimestamps();
    }

    /**
     * Messages de la conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');
    }

    /**
     * Dernier message
     */
    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    /**
     * Scope : conversations d'un utilisateur
     */
    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('users', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    /**
     * Vérifier si un utilisateur participe à cette conversation
     */
    public function hasParticipant(User $user): bool
    {
        return $this->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Compte de messages non lus pour un utilisateur
     */
    public function unreadCountFor(User $user): int
    {
        $lastReadAt = $this->users()
            ->where('user_id', $user->id)
            ->value('last_read_at');

        return $this->messages()
            ->where('user_id', '!=', $user->id)
            ->when($lastReadAt, function ($query) use ($lastReadAt) {
                $query->where('created_at', '>', $lastReadAt);
            })
            ->count();
    }

    /**
     * Marquer tous les messages comme lus pour un utilisateur
     */
    public function markAsReadFor(User $user): void
    {
        $this->users()->updateExistingPivot($user->id, [
            'last_read_at' => now(),
        ]);
    }

    /**
     * Obtenir l'autre participant (pour conversation privée)
     */
    public function getOtherParticipant(User $currentUser): ?User
    {
        if ($this->type !== 'private') {
            return null;
        }

        return $this->users()
            ->where('user_id', '!=', $currentUser->id)
            ->first();
    }

    /**
     * Créer ou récupérer une conversation privée entre deux utilisateurs
     */
    public static function findOrCreatePrivate(User $user1, User $user2): self
    {
        // Chercher conversation existante
        $conversation = self::where('type', 'private')
            ->whereHas('users', fn ($q) => $q->where('user_id', $user1->id))
            ->whereHas('users', fn ($q) => $q->where('user_id', $user2->id))
            ->first();

        if (!$conversation) {
            $conversation = self::create(['type' => 'private']);
            $conversation->users()->attach([$user1->id, $user2->id]);
        }

        return $conversation;
    }
}
