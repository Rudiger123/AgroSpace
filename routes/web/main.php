<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\OffersManagement\OffersManagement;
use App\Livewire\Admin\ProfileManagement\ProfileManagement;
use App\Livewire\Admin\UsersManagement\UsersManagement;
use App\Livewire\Auth\TwoFactorChallenge;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

/**
 * Les Routes protegées
 */
Route::middleware(['auth', 'verified','2fa'])->group(function () {
    
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/profile/settings', ProfileManagement::class)->name('profile');

    Route::get('/users', UsersManagement::class)->name('users-management');

    Route::get('/offers', OffersManagement::class)->name('offers-management');

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
