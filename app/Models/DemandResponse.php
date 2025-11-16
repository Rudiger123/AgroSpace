<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'demand_id', 'user_id', 'message', 'proposed_price',
        'contact_phone', 'contact_email', 'status'
    ];

    protected $casts = [
        'proposed_price' => 'decimal:2',
    ];

    public function demand()
    {
        return $this->belongsTo(Demand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            'accepted' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            'pending' => 'bg-yellow-100 text-yellow-700',
            default => 'bg-gray-100 text-gray-700'
        };
    }
}
