<?php
// app/Models/ActivityLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Méthode statique pour logger une activité
    public static function log(string $type, string $description, ?array $properties = null): void
    {
        if (Auth::check()) {
            self::create([
                'user_id' => Auth::user()->id,
                'type' => $type,
                'description' => $description,
                'properties' => $properties,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    // Obtenir les stats de connexion
    public static function getLoginStats(int $userId, int $days = 30): array
    {
        $logs = self::where('user_id', $userId)
            ->where('type', 'login')
            ->where('created_at', '>=', now()->subDays($days))
            ->get();

        return [
            'total_logins' => $logs->count(),
            'last_login' => $logs->sortByDesc('created_at')->first()?->created_at,
            'logins_by_day' => $logs->groupBy(fn($log) => $log->created_at->format('Y-m-d'))
                ->map->count()
                ->toArray(),
        ];
    }
}