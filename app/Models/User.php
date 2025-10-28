<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
}
