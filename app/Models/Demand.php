<?php

// app/Models/Demand.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Demand extends Model
{
    protected $fillable = [
        'user_id',
        'product',
        'description',
        'category',
        'quantity',
        'region',
        'contact',
        'status'
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour la recherche
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('product', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%")
              ->orWhere('region', 'like', "%{$search}%");
        });
    }

    /**
     * Scope pour filtrer par catégorie
     */
    public function scopeCategory($query, $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    /**
     * Scope pour filtrer par région
     */
    public function scopeRegion($query, $region)
    {
        if ($region) {
            return $query->where('region', $region);
        }
        return $query;
    }

    /**
     * Obtenir le statut formaté de la demande
     */
    public function getStatusAttribute(): string
    {
        // Calcul du statut basé sur l'ancienneté
        $daysOld = $this->created_at->diffInDays(now());

        if ($daysOld < 7) {
            return 'Récente';
        } elseif ($daysOld < 30) {
            return 'Active';
        } else {
            return 'Ancienne';
        }
    }

    /**
     * Obtenir la couleur du badge de statut
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Récente' => 'bg-green-100 text-green-800',
            'Active' => 'bg-blue-100 text-blue-800',
            'Ancienne' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
