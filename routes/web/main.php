<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/dashboard', 'pages.admin.dashboard')
        ->name('dashboard');

    Volt::route('/profile', 'pages.admin.profile')->name('profile');
});

Route::middleware(['auth', 'verified', 'role:admin'])->get('/admin', function () {
    return view('admin');
})->name('admin');

// Route protégée pour les paramètres de profil
Route::middleware(['auth'])->group(function () {
    Volt::route('/profile/settings', 'pages.admin.profile.profile-settings')->name('profile.settings');
});


require __DIR__ . '/../auth/main.php';
