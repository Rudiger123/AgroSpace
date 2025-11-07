<?php

// app/Models/Offer.php

namespace App\Models;

use App\Policies\OfferPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[UsePolicy(OfferPolicy::class)]
class Offer extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'category',
        'price',
        'region',
        'status',
        'contact',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir l'URL complète de l'image
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return Storage::url($this->image);
        }

        // Image par défaut si aucune image
        return asset('images/offer-default.png');
    }

    /**
     * Supprimer l'image lors de la suppression de l'offre
     */
    protected static function booted()
    {
        static::deleting(function ($offer) {
            if ($offer->image && Storage::exists($offer->image)) {
                Storage::delete($offer->image);
            }
        });
    }

    /**
     * Scope pour la recherche
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
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
}
