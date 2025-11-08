<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Policies\UserPolicy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FA\Google2FA;

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
        'status',
        'bio',
        'phone',
        'region',
        'city',
        'activity',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'last_active_at'
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
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'producer_id');
    }

    public function avisRecus()
    {
        return $this->hasMany(Avis::class, 'producer_id');
    }

    public function avisDonnes()
    {
        return $this->hasMany(Avis::class, 'consumer_id');
    }

    public function getNoteMoyenneAttribute(): float
    {
        return Avis::getNoteMoyenne($this->id);
    }

    public function getNombreAvisAttribute(): int
    {
        return $this->avisRecus()->visible()->count();
    }

    public function demands()
    {
        return $this->hasMany(Demand::class);
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
     * Scopes
     */

    // Scope pour les administrateurs
    public function scopeAdmins($query)
    {
        return $query->role('admin');
    }

    public function scopeProducers($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'producer');
        });
    }

    public function scopeConsumers($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'consumer');
        });
    }

    public function scopeByRole($query, $role = null)
    {
        return $role
            ? $query->whereHas('role', fn ($q) => $q->where('name', $role))
            : $query;
    }

    // Scope pour les utilisateurs actifs
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope pour les utilisateurs vérifiés
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    // Scope pour rechercher par nom ou email
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    /**
     * Accesseurs & Mutateurs
     */

    // URL de l'avatar
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
                    return Storage::url($this->avatar);
                }
                return asset('images/avatar.jpg');
            }
        );
    }

    // Dernière activité formatée
    protected function lastActive(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->last_active_at) {
                    return 'Jamais connecté';
                }

                $now = now();
                $diff = $this->last_active_at->diffInMinutes($now);

                if ($diff < 5) {
                    return 'En ligne';
                }

                return $this->last_active_at->diffForHumans();
            }
        );
    }

    // Vérifier si l'utilisateur est vérifié
    protected function verified(): Attribute
    {
        return Attribute::make(
            get: fn () => !is_null($this->email_verified_at)
        );
    }

    /**
     * Méthodes Helper
     */

    public function isAdmin(): bool
    {
        return optional($this->role)->name === 'admin';
    }

    public function isProducer(): bool
    {
        return optional($this->role)->name === 'producer';
    }

    public function isConsumer(): bool
    {
        return optional($this->role)->name === 'consumer';
    }

    // Vérifier si l'utilisateur est actif
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // Vérifier si l'utilisateur est suspendu
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    // Vérifier si l'utilisateur est banni
    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    // Mettre à jour la dernière activité
    public function updateLastActive(): void
    {
        $this->update(['last_active_at' => now()]);
    }

    // Compter les offres actives (pour les producers)
    public function activeOffersCount(): int
    {
        return $this->offers()->where('status', 'active')->count();
    }

    // Compter les demandes actives (pour les consommateurs)
    public function activeDemandsCount(): int
    {
        return $this->demands()->where('status', 'active')->count();
    }

    // Compter les messages non lus
    public function unreadMessagesCount(): int
    {
        return $this->receivedMessages()->where('read_at', null)->count();
    }

    // Obtenir le nom complet avec le rôle
    public function getFullNameWithRole(): string
    {
        $roleLabels = [
            'producer' => '👨‍🌾 producer',
            'consumer' => '🛒 Consommateur',
            'admin' => '👨‍💼 Administrateur',
        ];

        $roleLabel = $roleLabels[$this->role] ?? $this->role;

        return "{$this->name} ({$roleLabel})";
    }

    // Obtenir la badge du statut
    public function getStatusBadge(): array
    {
        $badges = [
            'active' => [
                'class' => 'bg-green-100 text-green-700',
                'label' => '✓ Actif',
            ],
            'suspended' => [
                'class' => 'bg-orange-100 text-orange-700',
                'label' => '⏸ Suspendu',
            ],
            'banned' => [
                'class' => 'bg-red-100 text-red-700',
                'label' => '⛔ Banni',
            ],
        ];

        return $badges[$this->status] ?? [
            'class' => 'bg-gray-100 text-gray-700',
            'label' => $this->status,
        ];
    }

    // Obtenir la badge du rôle
    public function getRoleBadge(): array
    {
        $badges = [
            '2' => [
                'class' => 'bg-green-100 text-green-700',
                'label' => '👨‍🌾 producer',
            ],
            '3' => [
                'class' => 'bg-blue-100 text-blue-700',
                'label' => '🛒 Consommateur',
            ],
            '1' => [
                'class' => 'bg-purple-100 text-purple-700',
                'label' => '👨‍💼 Admin',
            ],
        ];

        return $badges[$this->role_id] ?? [
            'class' => 'bg-gray-100 text-gray-700',
            'label' => $this->role,
        ];
    }

    // Relations
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }


    // Méthodes 2FA
    public function hasTwoFactorEnabled(): bool
    {
        return !is_null($this->two_factor_secret) && !is_null($this->two_factor_confirmed_at);
    }

    public function twoFactorQrCodeSvg(): string
    {
        return app(Google2FA::class)->getQRCodeUrl(
            config('app.name'),
            $this->email,
            decrypt($this->two_factor_secret)
        );
    }

    public function recoveryCodes(): array
    {
        return json_decode(decrypt($this->two_factor_recovery_codes), true) ?? [];
    }

    // Statistiques producer
    public function getProducerStats(): array
    {
        if (!$this->isProducer()) {
            return [];
        }

        $totalOffers = $this->offers()->count();
        $completedOffers = $this->offers()->where('statut', 'vendue')->count();
        $activeOffers = $this->offers()->where('statut', 'active')->count();

        $conversionRate = $totalOffers > 0 ? round(($completedOffers / $totalOffers) * 100, 2) : 0;

        return [
            'total_offers' => $totalOffers,
            'active_offers' => $activeOffers,
            'completed_offers' => $completedOffers,
            'conversion_rate' => $conversionRate,
            // Supprimer success_percentage qui est dupliqué, ou le garder avec une valeur différente :
            'success_percentage' => $conversionRate, // Ou calculer autre chose si besoin
        ];
    }

    // Statistiques consommateur
    public function getConsumerStats(): array
    {
        if (!$this->isConsumer()) {
            return [];
        }

        $totalDemands = $this->demands()->count();
        $fulfilledDemands = $this->demands()->where('status', 'fulfilled')->count();
        $activeDemands = $this->demands()->where('status', 'active')->count();

        $fulfillmentRate = $totalDemands > 0 ? round(($fulfilledDemands / $totalDemands) * 100, 2) : 0;

        // Vérification de la logique du matching_rate
        // Si vous voulez le taux de demandes qui ont eu au moins un match (actives ou fulfillies)
        $matchedDemands = $this->demands()
            ->whereIn('status', ['active', 'fulfilled'])
            ->count();

        $matchingRate = $totalDemands > 0 ? round(($matchedDemands / $totalDemands) * 100, 2) : 0;

        return [
            'total_demands' => $totalDemands,
            'active_demands' => $activeDemands,
            'fulfilled_demands' => $fulfilledDemands,
            'fulfillment_rate' => $fulfillmentRate,
            'matching_rate' => $matchingRate,
        ];
    }
}
