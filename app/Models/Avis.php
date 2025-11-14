<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    /** @use HasFactory<\Database\Factories\AvisFactory> */
    use HasFactory;

    protected $table = 'avis';

    protected $fillable = [
        'producer_id',
        'consumer_id',
        'offer_id',
        'note',
        'commentaire',
        'is_verified',
        'is_visible',
        'date_creation',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_visible' => 'boolean',
        'date_creation' => 'datetime',
    ];

    // Relations
    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }

    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeForproducer($query, $producerId)
    {
        return $query->where('producer_id', $producerId);
    }

    // Méthodes statiques
    public static function getNoteMoyenne($producerId): float
    {
        return self::where('producer_id', $producerId)
                   ->where('is_visible', true)
                   ->avg('note') ?? 0;
    }

    public static function getDistributionNotes($producerId): array
    {
        $distribution = self::where('producer_id', $producerId)
                            ->where('is_visible', true)
                            ->selectRaw('note, COUNT(*) as count')
                            ->groupBy('note')
                            ->pluck('count', 'note')
                            ->toArray();

        // Remplir les notes manquantes avec 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($distribution[$i])) {
                $distribution[$i] = 0;
            }
        }

        ksort($distribution);
        return $distribution;
    }
}
