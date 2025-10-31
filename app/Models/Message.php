<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'content',
        'attachments',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Conversation parente
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Auteur du message
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Utilisateurs ayant lu ce message
     */
    public function reads()
    {
        return $this->belongsToMany(User::class, 'message_reads')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    /**
     * Vérifier si un utilisateur a lu ce message
     */
    public function isReadBy(User $user): bool
    {
        return $this->reads()->where('user_id', $user->id)->exists();
    }

    /**
     * Marquer comme lu par un utilisateur
     */
    public function markAsReadBy(User $user): void
    {
        if (!$this->isReadBy($user) && $this->user_id !== $user->id) {
            $this->reads()->attach($user->id, ['read_at' => now()]);
        }
    }

    /**
     * Boot : mettre à jour last_message_id de la conversation
     */
    protected static function booted(): void
    {
        static::created(function (Message $message) {
            $message->conversation()->update([
                'last_message_id' => $message->id,
                'updated_at' => $message->created_at,
            ]);
        });
    }
}
