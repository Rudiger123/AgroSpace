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

/**
 * Les Routes Guest
 */
Route::get('/2fa-challenge', TwoFactorChallenge::class)
    ->middleware('guest')
    ->name('2fa.challenge');

Volt::route('/', 'welcome')->name('home');
Volt::route('/features', 'features')->name('features');
Volt::route('/blog', 'blog-page')->name('blog.page');
Volt::route('/about', 'about-page')->name('about.page');
Volt::route('/consumers', 'consumer-page')->name('consumer.page');
Volt::route('/producers', 'producer-page')->name('producer.page');

/**
 * imports
 */
require __DIR__ . '/../auth/main.php';
