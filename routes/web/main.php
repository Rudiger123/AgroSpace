<?php

use App\Livewire\Admin\Blog\CategoryManage;
use App\Livewire\Admin\Blog\TagManage;
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
use App\Livewire\Blog\BlogAnalytics;
use App\Livewire\Blog\BlogList;
use App\Livewire\Blog\BlogManager;
use App\Livewire\Blog\BlogShowEnhanced;
use App\Livewire\Blog\CommentManagement;
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

    // Gestion des catégories
    Route::get('/categories', CategoryManage::class)->name('categories.index');

    // Gestion des tags
    Route::get('/tags', TagManage::class)->name('tags.index');
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
});

// Gestion du blog (administration)
Route::prefix('admin/blog')->name('admin.blog.')->middleware(['auth', 'verified'])->group(function () {
    // Gestion principale des articles
    Route::get('/', BlogManager::class)->name('index');

     // Blog Analytics
     Route::get('/analytics', BlogAnalytics::class)->name('blog.analytics');
    
     // Comment Management
     Route::get('/comments', CommentManagement::class)->name('comments.index');
 
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
