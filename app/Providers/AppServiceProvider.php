<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ⚠️ SUPPRIMEZ TOUTES les lignes Event::listen()
        // Ce fichier doit être VIDE de events personnalisés
    }
}
