# 🌾 Système Complet de Gestion des Offres - Agrospace

Je vais créer un système complet et professionnel pour la gestion des offres des producteurs avec le système de notation intégré.

## 📁 Structure des Fichiers

```
database/migrations/
├── xxxx_create_offres_table.php
├── xxxx_create_avis_table.php
└── xxxx_create_offre_photos_table.php

app/Models/
├── Offre.php
├── Avis.php
└── OffrePhoto.php

app/Http/Livewire/Offres/
├── OffresList.php
├── CreateOffre.php
├── EditOffre.php
├── ShowOffre.php
└── ManageOffres.php

app/Services/
├── OffreService.php
└── AvisService.php

resources/views/livewire/offres/
├── offres-list.blade.php
├── create-offre.blade.php
├── edit-offre.blade.php
├── show-offre.blade.php
└── manage-offres.blade.php
```

---

## 1️⃣ Migrations

### Migration - Table Offres

```php
<?php
// database/migrations/2024_01_15_create_offres_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producteur_id')->constrained('users')->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->string('categorie');
            $table->decimal('prix', 10, 2);
            $table->integer('quantite');
            $table->string('unite'); // kg, tonne, sac, pièce
            $table->string('localisation');
            $table->string('region')->nullable();
            $table->string('ville')->nullable();
            $table->timestamp('date_publication');
            $table->timestamp('date_expiration')->nullable();
            $table->enum('statut', ['active', 'expirée', 'vendue', 'suspendue'])->default('active');
            $table->text('conditions_livraison')->nullable();
            $table->string('contact')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('contacts_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['statut', 'date_publication']);
            $table->index(['categorie', 'statut']);
            $table->index('producteur_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
```

### Migration - Table Photos des Offres

```php
<?php
// database/migrations/2024_01_16_create_offre_photos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offre_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offre_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->integer('ordre')->default(0);
            $table->boolean('is_principale')->default(false);
            $table->timestamps();
            
            $table->index('offre_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offre_photos');
    }
};
```

### Migration - Table Avis

```php
<?php
// database/migrations/2024_01_17_create_avis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producteur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('acheteur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('offre_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('note'); // 1 à 5
            $table->text('commentaire')->nullable();
            $table->boolean('is_verified')->default(false); // Achat vérifié
            $table->boolean('is_visible')->default(true);
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();
            
            $table->unique(['producteur_id', 'acheteur_id', 'offre_id']);
            $table->index(['producteur_id', 'is_visible']);
            $table->index('note');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
```

---

## 2️⃣ Models

### Model - Offre

```php
<?php
// app/Models/Offre.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offre extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'producteur_id',
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
    public function producteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'producteur_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(OffrePhoto::class)->orderBy('ordre');
    }

    public function avis(): HasMany
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
```

### Model - OffrePhoto

```php
<?php
// app/Models/OffrePhoto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OffrePhoto extends Model
{
    protected $fillable = [
        'offre_id',
        'path',
        'ordre',
        'is_principale',
    ];

    protected $casts = [
        'is_principale' => 'boolean',
    ];

    public function offre(): BelongsTo
    {
        return $this->belongsTo(Offre::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
```

### Model - Avis

```php
<?php
// app/Models/Avis.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avis extends Model
{
    protected $table = 'avis';

    protected $fillable = [
        'producteur_id',
        'acheteur_id',
        'offre_id',
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
    public function producteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'producteur_id');
    }

    public function acheteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acheteur_id');
    }

    public function offre(): BelongsTo
    {
        return $this->belongsTo(Offre::class);
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

    public function scopeForProducteur($query, $producteurId)
    {
        return $query->where('producteur_id', $producteurId);
    }

    // Méthodes statiques
    public static function getNoteMoyenne($producteurId): float
    {
        return self::where('producteur_id', $producteurId)
                   ->where('is_visible', true)
                   ->avg('note') ?? 0;
    }

    public static function getDistributionNotes($producteurId): array
    {
        $distribution = self::where('producteur_id', $producteurId)
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
```

### Mise à jour Model User

```php
<?php
// app/Models/User.php (ajouts)

// Dans la classe User, ajouter ces méthodes

public function offres()
{
    return $this->hasMany(Offre::class, 'producteur_id');
}

public function avisRecus()
{
    return $this->hasMany(Avis::class, 'producteur_id');
}

public function avisDonnes()
{
    return $this->hasMany(Avis::class, 'acheteur_id');
}

public function getNoteMoyenneAttribute(): float
{
    return Avis::getNoteMoyenne($this->id);
}

public function getNombreAvisAttribute(): int
{
    return $this->avisRecus()->visible()->count();
}
```

---

## 3️⃣ Services

### Service - OffreService

```php
<?php
// app/Services/OffreService.php

namespace App\Services;

use App\Models\Offre;
use App\Models\OffrePhoto;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class OffreService
{
    public function createOffre(array $data, array $photos = []): Offre
    {
        return DB::transaction(function () use ($data, $photos) {
            // Créer l'offre
            $offre = Offre::create([
                'producteur_id' => auth()->id(),
                'titre' => $data['titre'],
                'description' => $data['description'],
                'categorie' => $data['categorie'],
                'prix' => $data['prix'],
                'quantite' => $data['quantite'],
                'unite' => $data['unite'],
                'localisation' => $data['localisation'],
                'region' => $data['region'] ?? null,
                'ville' => $data['ville'] ?? null,
                'date_publication' => now(),
                'date_expiration' => $data['date_expiration'] ?? null,
                'statut' => 'active',
                'conditions_livraison' => $data['conditions_livraison'] ?? null,
                'contact' => $data['contact'] ?? auth()->user()->phone,
            ]);

            // Uploader les photos
            if (!empty($photos)) {
                $this->uploadPhotos($offre, $photos);
            }

            ActivityLog::log('offre_created', "Offre créée : {$offre->titre}", [
                'offre_id' => $offre->id
            ]);

            return $offre->fresh(['photos']);
        });
    }

    public function updateOffre(Offre $offre, array $data, array $newPhotos = []): Offre
    {
        return DB::transaction(function () use ($offre, $data, $newPhotos) {
            $offre->update([
                'titre' => $data['titre'],
                'description' => $data['description'],
                'categorie' => $data['categorie'],
                'prix' => $data['prix'],
                'quantite' => $data['quantite'],
                'unite' => $data['unite'],
                'localisation' => $data['localisation'],
                'region' => $data['region'] ?? null,
                'ville' => $data['ville'] ?? null,
                'date_expiration' => $data['date_expiration'] ?? null,
                'conditions_livraison' => $data['conditions_livraison'] ?? null,
                'contact' => $data['contact'] ?? null,
            ]);

            // Uploader nouvelles photos si présentes
            if (!empty($newPhotos)) {
                $this->uploadPhotos($offre, $newPhotos);
            }

            ActivityLog::log('offre_updated', "Offre modifiée : {$offre->titre}", [
                'offre_id' => $offre->id
            ]);

            return $offre->fresh(['photos']);
        });
    }

    public function deleteOffre(Offre $offre): bool
    {
        return DB::transaction(function () use ($offre) {
            // Supprimer les photos du storage
            foreach ($offre->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
            }

            ActivityLog::log('offre_deleted', "Offre supprimée : {$offre->titre}", [
                'offre_id' => $offre->id
            ]);

            return $offre->delete();
        });
    }

    public function markAsSold(Offre $offre): bool
    {
        $result = $offre->markAsSold();

        if ($result) {
            ActivityLog::log('offre_sold', "Offre marquée comme vendue : {$offre->titre}", [
                'offre_id' => $offre->id
            ]);
        }

        return $result;
    }

    public function uploadPhotos(Offre $offre, array $photos): void
    {
        $ordre = $offre->photos()->max('ordre') ?? 0;
        $isPremiere = $offre->photos()->count() === 0;

        foreach ($photos as $index => $photo) {
            if ($photo instanceof UploadedFile) {
                $path = $photo->store('offres/' . $offre->id, 'public');
                
                OffrePhoto::create([
                    'offre_id' => $offre->id,
                    'path' => $path,
                    'ordre' => ++$ordre,
                    'is_principale' => $isPremiere && $index === 0,
                ]);
            }
        }
    }

    public function deletePhoto(OffrePhoto $photo): bool
    {
        Storage::disk('public')->delete($photo->path);
        return $photo->delete();
    }

    public function setPhotoPrincipale(OffrePhoto $photo): void
    {
        DB::transaction(function () use ($photo) {
            // Retirer le statut principal des autres photos
            OffrePhoto::where('offre_id', $photo->offre_id)
                      ->update(['is_principale' => false]);

            // Définir cette photo comme principale
            $photo->update(['is_principale' => true]);
        });
    }

    public function duplicateOffre(Offre $offre): Offre
    {
        return DB::transaction(function () use ($offre) {
            $newOffre = $offre->replicate();
            $newOffre->titre = $offre->titre . ' (Copie)';
            $newOffre->date_publication = now();
            $newOffre->statut = 'active';
            $newOffre->views_count = 0;
            $newOffre->contacts_count = 0;
            $newOffre->save();

            // Dupliquer les photos
            foreach ($offre->photos as $photo) {
                $newPath = str_replace(
                    'offres/' . $offre->id,
                    'offres/' . $newOffre->id,
                    $photo->path
                );

                // Copier le fichier
                Storage::disk('public')->copy($photo->path, $newPath);

                OffrePhoto::create([
                    'offre_id' => $newOffre->id,
                    'path' => $newPath,
                    'ordre' => $photo->ordre,
                    'is_principale' => $photo->is_principale,
                ]);
            }

            ActivityLog::log('offre_duplicated', "Offre dupliquée : {$newOffre->titre}");

            return $newOffre;
        });
    }
}
```

### Service - AvisService

```php
<?php
// app/Services/AvisService.php

namespace App\Services;

use App\Models\Avis;
use App\Models\User;
use App\Models\Offre;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class AvisService
{
    public function createAvis(array $data): Avis
    {
        return DB::transaction(function () use ($data) {
            $avis = Avis::create([
                'producteur_id' => $data['producteur_id'],
                'acheteur_id' => auth()->id(),
                'offre_id' => $data['offre_id'] ?? null,
                'note' => $data['note'],
                'commentaire' => $data['commentaire'] ?? null,
                'is_verified' => $data['is_verified'] ?? false,
                'is_visible' => true,
                'date_creation' => now(),
            ]);

            ActivityLog::log('avis_created', "Avis donné à un producteur", [
                'avis_id' => $avis->id,
                'note' => $avis->note
            ]);

            // TODO: Envoyer notification au producteur

            return $avis;
        });
    }

    public function updateAvis(Avis $avis, array $data): Avis
    {
        $avis->update([
            'note' => $data['note'],
            'commentaire' => $data['commentaire'] ?? null,
        ]);

        ActivityLog::log('avis_updated', "Avis modifié", ['avis_id' => $avis->id]);

        return $avis->fresh();
    }

    public function deleteAvis(Avis $avis): bool
    {
        ActivityLog::log('avis_deleted', "Avis supprimé", ['avis_id' => $avis->id]);
        return $avis->delete();
    }

    public function toggleVisibility(Avis $avis): bool
    {
        $avis->update(['is_visible' => !$avis->is_visible]);
        
        ActivityLog::log('avis_visibility_changed', "Visibilité de l'avis changée", [
            'avis_id' => $avis->id,
            'is_visible' => $avis->is_visible
        ]);

        return $avis->is_visible;
    }

    public function canUserLeaveAvis(User $acheteur, User $producteur): bool
    {
        // Vérifier si l'utilisateur a déjà laissé un avis
        $existingAvis = Avis::where('acheteur_id', $acheteur->id)
                            ->where('producteur_id', $producteur->id)
                            ->exists();

        return !$existingAvis;
    }
}
```

---

## 4️⃣ Composant Livewire Principal
