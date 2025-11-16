<?php

// app/Models/Demand.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Demand extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'description', 'quantity',
        'city', 'region', 'validity_date', 'budget', 'urgency',
        'status', 'views_count', 'contacts_received', 'is_verified', 'verified_at'
    ];

    protected $casts = [
        'validity_date' => 'date',
        'budget' => 'decimal:2',
        'views_count' => 'integer',
        'contacts_received' => 'integer',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function responses()
    {
        return $this->hasMany(DemandResponse::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('validity_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('validity_date', '<', now())
                    ->where('status', '!=', 'satisfied')
                    ->where('status', '!=', 'cancelled');
    }

    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Accessors
    public function getIsExpiredAttribute(): bool
    {
        return $this->validity_date->isPast() && $this->status === 'active';
    }

    public function getUrgencyBadgeColorAttribute(): string
    {
        return match ($this->urgency) {
            'high' => 'bg-red-100 text-red-700',
            'medium' => 'bg-yellow-100 text-yellow-700',
            'low' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700'
        };
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'bg-green-100 text-green-700',
            'satisfied' => 'bg-blue-100 text-blue-700',
            'expired' => 'bg-gray-100 text-gray-700',
            'cancelled' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700'
        };
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementContacts(): void
    {
        $this->increment('contacts_received');
    }
}
