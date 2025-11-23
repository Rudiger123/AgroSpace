<?php

use App\Livewire\Admin\AvisManagement;
use App\Livewire\Admin\Blog\CategoryManage;
use App\Livewire\Admin\Blog\TagManage;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\DemandResponseManagement;
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
use App\Livewire\Newsletter\AdminNewsletterList;
use App\Livewire\Newsletter\UnsubscribeConfirmation;
use App\Livewire\Notifications\NotificationsPage;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/**
 * Les Routes protegées
 */
Route::middleware(['auth', 'verified', '2fa'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/profile/settings', ProfileManagement::class)->name('profile');

    Route::get('/offers', OffresList::class)->name('offers-list');

    Route::get('/demands', PublicDemands::class)->name('demands-list');

    Route::get('/notifications', NotificationsPage::class)->name('notifications.index');

    Route::get('/avis', AvisManagement::class)->name('admin.avis');

    Route::get('/responses', DemandResponseManagement::class)->name('admin.responses');

    Route::prefix('/admin')->middleware('role:admin')->group(function () {
        //Gestion des Utilisateurs
        Route::get('/users', UsersManagement::class)->name('users-management');

        //Modération des demandes
        Route::get('/demands/moderate', DemandsManage::class)
            ->name('demands.index'); //admin

        // Modération des offres
        Route::get('/offers/moderate', ModerateOffers::class)
            ->name('offers.moderate');

        // Gestion des catégories
        Route::get('/categories', CategoryManage::class)->name('categories.index');

        // Gestion des tags
        Route::get('/tags', TagManage::class)->name('tags.index');

        // Gestion du blog (administration)
        Route::prefix('/blog')->name('admin.blog.')->middleware(['auth', 'verified'])->group(function () {
            // Gestion principale des articles
            Route::get('/', BlogManager::class)->name('index');

            // Blog Analytics
            Route::get('/analytics', BlogAnalytics::class)->name('blog.analytics');

            // Comment Management
            Route::get('/comments', CommentManagement::class)->name('comments.index');
        });

        // Protected Admin Routes
        Route::get('/newsletter/subscribers', AdminNewsletterList::class)
            ->name('admin.newsletter.list');
    });

    Route::prefix('/consumer')->middleware('role:consumer')->group(function () {
        Route::get('/my-demands', MyDemands::class)->name('demands-management');
    });

    Route::prefix('/producer')->middleware('role:producer')->group(function () {
        Route::get('/my-offers', ManageOffers::class)->name('offers-management');
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
Volt::route('/about', 'about-page')->name('about.page');
Volt::route('/consumers', 'consumer-page')->name('consumer.page');
Volt::route('/producers', 'producer-page')->name('producer.page');
Route::prefix('blog')->name('blog.')->group(function () {
    // Page principale du blog - liste des articles
    Route::get('/', BlogList::class)->name('index');

    // Affichage d'un article individuel
    Route::get('/{slug}', BlogShowEnhanced::class)->name('show');
});
// Public Newsletter Routes
Route::get('/newsletter/unsubscribe/{token}', UnsubscribeConfirmation::class)
    ->name('newsletter.unsubscribe');

Volt::route('/contact', 'contact')->name('contact');

/**
 * imports
 */
require __DIR__ . '/../auth/main.php';
