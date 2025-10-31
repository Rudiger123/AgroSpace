<?php

use App\Livewire\Admin\consumer\DemandsTable;
use App\Livewire\Admin\Producer\OffersTable;
use App\Livewire\Auth\TwoFactorChallenge;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Page d'acceuil
Volt::route('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/dashboard', 'pages.admin.dashboard')
    ->name('dashboard');

    Volt::route('/profile', 'pages.admin.profile')->name('profile');

    Route::get('/my-offers', OffersTable::class)->name('offers.my');

    Route::get('/my-demands', DemandsTable::class)->name('demands.my');

    Route::view('/admin', 'dashboard')->name('admin');

    Route::view('/chat', 'chat.index')->name('chat.index');
});


Route::get('/2fa-challenge', TwoFactorChallenge::class)
    ->middleware('guest')
    ->name('2fa.challenge');
require __DIR__ . '/../auth/main.php';
