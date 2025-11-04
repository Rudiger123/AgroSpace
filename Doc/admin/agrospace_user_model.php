<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role', // producer, consumer, admin
        'status', // active, suspended, banned
        'region',
        'city',
        'bio',
        'avatar',
        'email_verified_at',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_active_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        // Définir le statut par défaut
        static::creating(function ($user) {
            if (empty($user->status)) {
                $user->status = 'active';
            }
        });
    }

    /**
     * Relations
     */

    // Un utilisateur (producteur) peut avoir plusieurs offres
    public function offers()
    {
        return $this->hasMany(Offer::class, 'producer_id');
    }

    // Un utilisateur (consommateur) peut avoir plusieurs demandes
    public function demands()
    {
        return $this->hasMany(Demand::class, 'consumer_id');
    }

    // Un utilisateur peut envoyer plusieurs messages
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Un utilisateur peut recevoir plusieurs messages
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Tous les messages (envoyés et reçus)
    public function messages()
    {
        return $this->sentMessages()->union($this->receivedMessages());
    }

    // Un utilisateur peut avoir plusieurs notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Un utilisateur peut créer des articles de blog (si admin)
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    /**
     * Scopes
     */

    // Scope pour les producteurs
    public function scopeProducers($query)
    {
        return $query->where('role', 'producer');
    }

    // Scope pour les consommateurs
    public function scopeConsumers($query)
    {
        return $query->where('role', 'consumer');
    }

    // Scope pour les administrateurs
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
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

                // Avatar par défaut avec UI Avatars
                $name = urlencode($this->name);
                $colors = [
                    'producer' => '22c55e', // Vert
                    'consumer' => '3b82f6', // Bleu
                    'admin' => '8b5cf6',    // Violet
                ];
                $color = $colors[$this->role] ?? 'gray';

                return "https://ui-avatars.com/api/?name={$name}&background={$color}&color=fff&size=200";
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

    // Vérifier si l'utilisateur est un producteur
    public function isProducer(): bool
    {
        return $this->role === 'producer';
    }

    // Vérifier si l'utilisateur est un consommateur
    public function isConsumer(): bool
    {
        return $this->role === 'consumer';
    }

    // Vérifier si l'utilisateur est un administrateur
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
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

    // Compter les offres actives (pour les producteurs)
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
            'producer' => '👨‍🌾 Producteur',
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
            'producer' => [
                'class' => 'bg-green-100 text-green-700',
                'label' => '👨‍🌾 Producteur',
            ],
            'consumer' => [
                'class' => 'bg-blue-100 text-blue-700',
                'label' => '🛒 Consommateur',
            ],
            'admin' => [
                'class' => 'bg-purple-100 text-purple-700',
                'label' => '👨‍💼 Admin',
            ],
        ];

        return $badges[$this->role] ?? [
            'class' => 'bg-gray-100 text-gray-700',
            'label' => $this->role,
        ];
    }
}
