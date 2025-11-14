<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\DemandsManagement\DemandsManage;
use App\Livewire\Admin\DemandsManagement\MyDemands;
use App\Livewire\Admin\DemandsManagement\PublicDemands;
use App\Livewire\Admin\OffersManagement\ManageOffers;
use App\Livewire\Admin\OffersManagement\ModerateOffers;
use App\Livewire\Admin\OffersManagement\OffresList;
use App\Livewire\Admin\ProfileManagement\ProfileManagement;
use App\Livewire\Admin\UsersManagement\UsersManagement;
use App\Livewire\Auth\TwoFactorChallenge;
use App\Livewire\Blog\BlogList;
use App\Livewire\Blog\BlogManager;
use App\Livewire\Blog\BlogShowEnhanced;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/**
 * Les Routes protegées
 */
Route::middleware(['auth', 'verified', '2fa'])->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/profile/settings', ProfileManagement::class)->name('profile');

    Route::get('/users', UsersManagement::class)->name('users-management');

    Route::get('/my-offers', ManageOffers::class)->name('offers-management');

    Route::get('/offers', OffresList::class)->name('offers-list');

    Route::get('/my-demands', MyDemands::class)->name('demands-management');

    Route::get('/demands', PublicDemands::class)->name('demands-list');

    Route::get('/demandes', DemandsManage::class)
        ->name('demands.index'); //admin

    // Modération des offres
    Route::get('/offers/moderation', ModerateOffers::class)
    ->name('offers.moderate');

});

/*
|--------------------------------------------------------------------------
| Blog Routes
|--------------------------------------------------------------------------
|
| Routes pour le module de blog d'AgroSpace
|
*/

Route::prefix('blog')->name('blog.')->group(function () {
    
    // Page principale du blog - liste des articles
    Route::get('/', BlogList::class)->name('index');
    
    // Affichage d'un article individuel
    Route::get('/{slug}', BlogShowEnhanced::class)->name('show');
    
    // Recherche dans le blog
    Route::get('/search', function () {
        return redirect()->route('blog.index');
    })->name('search');
    
    // Filtrage par catégorie
    Route::get('/category/{category}', function ($category) {
        return redirect()->route('blog.index', ['category' => $category]);
    })->name('category');
    
    // Filtrage par tag
    Route::get('/tag/{tag}', function ($tag) {
        return redirect()->route('blog.index', ['tag' => $tag]);
    })->name('tag');
});

// Gestion du blog (administration)
Route::prefix('admin/blog')->name('admin.blog.')->middleware(['auth', 'verified'])->group(function () {
    
    // Gestion principale des articles
    Route::get('/', BlogManager::class)->name('index');
    
    // Création d'un article
    Route::get('/create', function () {
        return redirect()->route('blog.index');
    })->name('create');
    
    // Édition d'un article
    Route::get('/{post}/edit', function ($post) {
        return redirect()->route('blog.index');
    })->name('edit');
    
    // API pour la gestion des catégories et tags
    Route::prefix('api')->name('api.')->group(function () {
        
        // Gestion des catégories
        Route::get('/categories', function () {
            return \App\Models\Category::active()->ordered()->get();
        })->name('categories.index');
        
        Route::post('/categories', function () {
            // Création de catégorie
        })->name('categories.store');
        
        // Gestion des tags
        Route::get('/tags', function () {
            return \App\Models\Tag::active()->popular()->get();
        })->name('tags.index');
        
        Route::post('/tags', function () {
            // Création de tag
        })->name('tags.store');
        
        // Upload d'images
        Route::post('/upload-image', function () {
            // Gestion de l'upload d'images
        })->name('upload.image');
    });
});

/**
 * Les Routes Guest
 */
Route::get('/2fa-challenge', TwoFactorChallenge::class)
    ->middleware('guest')
    ->name('2fa.challenge');

Volt::route('/', 'welcome')->name('home');
Volt::route('/features', 'features')->name('features');
Volt::route('/blogs', 'blog-page')->name('blog.page');
Volt::route('/about', 'about-page')->name('about.page');
Volt::route('/consumers', 'consumer-page')->name('consumer.page');
Volt::route('/producers', 'producer-page')->name('producer.page');

/**
 * imports
 */
require __DIR__ . '/../auth/main.php';
