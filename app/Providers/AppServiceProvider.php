<?php

namespace App\Providers;

use App\Events\Notifications\ArticlePublished;
use App\Events\Notifications\NewOfferCreated;
use App\Listeners\Notifications\SendArticlePublishedNotification;
use App\Listeners\Notifications\SendNewOfferNotification;
use Illuminate\Support\Facades\Event;
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
        Event::listen(
            NewOfferCreated::class,
            SendNewOfferNotification::class,
        );

        Event::listen(
            ArticlePublished::class,
            SendArticlePublishedNotification::class,
        );
    }
}
