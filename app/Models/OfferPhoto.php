<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferPhoto extends Model
{
    protected $fillable = [
        'offer_id',
        'path',
        'ordre',
        'is_principale',
    ];

    protected $casts = [
        'is_principale' => 'boolean',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
