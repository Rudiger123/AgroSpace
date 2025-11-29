<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'reply_message',
        'replied_at',
        'replied_by',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a répondu
     */
    public function repliedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    /**
     * Scope pour rechercher dans les contacts
     */
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%");
        });
    }

    /**
     * Scope pour filtrer par statut
     */
    public function scopeStatus($query, $status)
    {
        if ($status === 'all') {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Scope pour obtenir les nouveaux messages
     */
    public function scopeNewMessages($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope pour obtenir les messages non lus
     */
    public function scopeUnread($query)
    {
        return $query->whereIn('status', ['new', 'opened']);
    }

    /**
     * Vérifier si le message est nouveau
     */
    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    /**
     * Vérifier si le message a été répondu
     */
    public function isReplied(): bool
    {
        return $this->status === 'replied';
    }

    /**
     * Vérifier si le message est fermé
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /**
     * Marquer comme ouvert
     */
    public function markAsOpened(): void
    {
        if ($this->status === 'new') {
            $this->update(['status' => 'opened']);
        }
    }

    /**
     * Marquer comme répondu
     */
    public function markAsReplied(string $replyMessage, int $repliedBy): void
    {
        $this->update([
            'status' => 'replied',
            'reply_message' => $replyMessage,
            'replied_at' => now(),
            'replied_by' => $repliedBy,
        ]);
    }

    /**
     * Marquer comme fermé
     */
    public function markAsClosed(): void
    {
        $this->update(['status' => 'closed']);
    }

    /**
     * Obtenir la couleur du badge de statut
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'new' => 'blue',
            'opened' => 'amber',
            'replied' => 'green',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Obtenir le label du statut
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new' => 'Nouveau',
            'opened' => 'Ouvert',
            'replied' => 'Répondu',
            'closed' => 'Fermé',
            default => $this->status,
        };
    }
}
