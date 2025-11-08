<?php

// app/Models/Offer.php

namespace App\Models;

use App\Policies\OfferPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(OfferPolicy::class)]
class Offer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'producer_id',
        'titre',
        'description',
        'categorie',
        'prix',
        'quantite',
        'unite',
        'localisation',
        'region',
        'ville',
        'date_publication',
        'date_expiration',
        'statut',
        'conditions_livraison',
        'contact',
        'views_count',
        'contacts_count',
        'is_featured',
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'date_expiration' => 'datetime',
        'prix' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    protected $appends = ['photo_principale_url', 'is_expired'];

    // Relations
    public function producer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'producer_id');
    }

    public function photos()
    {
        return $this->hasMany(OfferPhoto::class)->orderBy('ordre');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    // Accessors
    public function getPhotoPrincipaleUrlAttribute(): ?string
    {
        $photo = $this->photos()->where('is_principale', true)->first();

        if ($photo) {
            return asset('storage/' . $photo->path);
        }

        $firstPhoto = $this->photos()->first();
        return $firstPhoto ? asset('storage/' . $firstPhoto->path) : null;
    }

    public function getIsExpiredAttribute(): bool
    {
        if (!$this->date_expiration) {
            return false;
        }

        return $this->date_expiration->isPast();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('statut', 'active')
                     ->where(function ($q) {
                         $q->whereNull('date_expiration')
                           ->orWhere('date_expiration', '>', now());
                     });
    }

    public function scopeExpired($query)
    {
        return $query->where('statut', 'active')
                     ->whereNotNull('date_expiration')
                     ->where('date_expiration', '<=', now());
    }

    public function scopeByCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('localisation', 'like', "%{$search}%");
        });
    }

    // Méthodes
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementContacts(): void
    {
        $this->increment('contacts_count');
    }

    public function checkAndUpdateExpiration(): void
    {
        if ($this->is_expired && $this->statut === 'active') {
            $this->update(['statut' => 'expirée']);
        }
    }

    public function markAsSold(): bool
    {
        return $this->update(['statut' => 'vendue']);
    }

    public static function getCategoriesOptions(): array
    {
        return [
            'cereales' => 'Céréales & Grains',
            'legumes' => 'Légumes & Fruits',
            'elevage' => 'Élevage & Volaille',
            'tubercules' => 'Tubercules',
            'produits_transformes' => 'Produits Transformés',
            'services' => 'Services Agricoles',
        ];
    }

    public static function getUnitesOptions(): array
    {
        return [
            'kg' => 'Kilogramme (kg)',
            'tonne' => 'Tonne',
            'sac' => 'Sac',
            'piece' => 'Pièce',
            'litre' => 'Litre',
            'cageot' => 'Cageot',
        ];
    }

    public static function getRegionsOptions(): array
    {
        return [
            'Adamaoua', 'Centre', 'Est', 'Extrême-Nord',
            'Littoral', 'Nord', 'Nord-Ouest', 'Ouest',
            'Sud', 'Sud-Ouest'
        ];
    }
}
