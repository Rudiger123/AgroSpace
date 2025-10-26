<?php
use App\Livewire\Admin\Profile as AdminProfile;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/dashboard', 'pages.admin.dashboard')
        ->name('dashboard');

    Volt::route('/profile', 'pages.admin.profile')->name('profile');
    //Route::get('/profile', AdminProfile::class)->name('profile');
});

Route::middleware(['auth', 'verified', 'role:admin'])->get('/admin', function () {
    return view('admin');
})->name('admin');

require __DIR__ . '/../auth/main.php';
