<?php

namespace App\Providers;

use App\Events\Notifications\ArticlePublished;
use App\Events\Notifications\DemandCreated;
use App\Events\Notifications\DemandResponseCreated;
use App\Events\Notifications\NewOfferCreated;
use App\Events\Notifications\NewReviewCreated;
use App\Listeners\Notifications\SendArticlePublishedNotification;
use App\Listeners\Notifications\SendDemandCreatedNotification;
use App\Listeners\Notifications\SendDemandResponseNotification;
use App\Listeners\Notifications\SendNewOfferNotification;
use App\Listeners\Notifications\SendNewReviewNotification;
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
        Event::listen(
            DemandResponseCreated::class,
            SendDemandResponseNotification::class,
        );
        Event::listen(
            NewReviewCreated::class,
            SendNewReviewNotification::class,
        );
        Event::listen(
            DemandCreated::class,
            SendDemandCreatedNotification::class,
        );
    }
}
