<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

#[UsePolicy(UserPolicy::class)]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'avatar',
        'bio',
        'location',
        'activity',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_enabled',
        'last_seen_at',
        'is_online',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'last_seen_at' => 'datetime',
            'is_online' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    // Accessors pour chiffrer/déchiffrer automatiquement
    public function setTwoFactorSecretAttribute($value)
    {
        $this->attributes['two_factor_secret'] = encrypt($value);
    }

    public function getTwoFactorSecretAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    public function setTwoFactorRecoveryCodesAttribute($value)
    {
        $this->attributes['two_factor_recovery_codes'] = encrypt(json_encode($value));
    }

    public function getTwoFactorRecoveryCodesAttribute($value)
    {
        return $value ? json_decode(decrypt($value), true) : [];
    }

    /**
     * conversation de l'utilisateur
     */

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)
            ->withPivot('joined_at', 'last_read_at')
            ->withTimestamps()
            ->orderByDesc('conversations.updated_at');
    }

    /**
     * Messages envoyés
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Marquer l'utilisateur comme en ligne
     */
    public function markAsOnline(): void
    {
        $this->update([
            'is_online' => true,
            'last_seen_at' => now(),
        ]);
    }
    /**
     * Marquer l'utilisateur comme hors ligne
     */
    public function markAsOffline(): void
    {
        $this->update([
            'is_online' => false,
            'last_seen_at' => now(),
        ]);
    }

    /**
     * Nombre de messages non lus pour cet utilisateur
     */
    public function unreadMessagesCount(): int
    {
        return Message::whereHas('conversation.users', function ($query) {
            $query->where('user_id', $this->id);
        })
            ->where('user_id', '!=', $this->id) // Pas mes propres messages
            ->whereDoesntHave('reads', function ($query) {
                $query->where('user_id', $this->id);
            })
            ->count();
    }

    protected static function booted()
    {
        static::updated(function ($user) {
            if ($user->wasChanged('is_online')) {
                Cache::forget('stats.active_users');
            }
        });
    }
}
