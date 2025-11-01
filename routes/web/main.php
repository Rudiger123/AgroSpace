<?php

use App\Livewire\Admin\consumer\DemandsTable;
use App\Livewire\Admin\Producer\OffersTable;
use App\Livewire\Auth\TwoFactorChallenge;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Guest Routes
Volt::route('/', 'welcome')->name('home');
Volt::route('/features', 'features')->name('features');
Volt::route('/blog', 'blog-page')->name('blog.page');
Volt::route('/about', 'about-page')->name('about.page');
Volt::route('/consumers', 'consumer-page')->name('consumer.page');
Volt::route('/producers', 'producer-page')->name('producer.page');

/**
 * Les Routes protegées
 */
Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/dashboard', 'pages.admin.dashboard')
        ->name('dashboard');

    Volt::route('/profile', 'pages.admin.profile')->name('profile');

    Route::get('/my-offers', OffersTable::class)->name('offers.my');

    Route::get('/my-demands', DemandsTable::class)->name('demands.my');
});

/**
 * Les Routes Guest
 */
Route::get('/2fa-challenge', TwoFactorChallenge::class)
    ->middleware('guest')
    ->name('2fa.challenge');

/**
 * imports
 */
require __DIR__ . '/../auth/main.php';
