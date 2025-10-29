<?php

use App\Livewire\Admin\consumer\DemandsTable;
use App\Livewire\Admin\Producer\OffersTable;
use App\Livewire\Auth\TwoFactorChallenge;
use App\Livewire\Auth\TwoFactorSettings;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/dashboard', 'pages.admin.dashboard')
        ->name('dashboard');

    Volt::route('/profile', 'pages.admin.profile')->name('profile');

    Route::get('/my-offers', OffersTable::class)->name('offers.my');

    Route::get('/my-demands', DemandsTable::class)->name('demands.my');
});

Route::middleware(['auth', 'verified', 'role:admin'])->get('/admin', function () {
    return view('admin');
})->name('admin');

// Route protégée pour les paramètres de profil
Route::middleware(['auth'])->group(function () {
    Volt::route('/profile/settings', 'pages.admin.profile.profile-settings')->name('profile.settings');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/account/security', TwoFactorSettings::class)->name('account.security');
});

Route::get('/2fa-challenge', TwoFactorChallenge::class)
    ->middleware('guest')
    ->name('2fa.challenge');
require __DIR__ . '/../auth/main.php';
