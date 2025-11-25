<?php

namespace App\Providers;

use App\Events\Notifications\DemandCreated;
use App\Events\Notifications\NewOfferCreated;
use App\Events\Notifications\ArticlePublished;
use App\Events\Notifications\DemandResponseCreated;
use App\Events\Notifications\NewReviewCreated;
use App\Listeners\Notifications\SendDemandCreatedNotification;
use App\Listeners\Notifications\SendNewOfferNotification;
use App\Listeners\Notifications\SendArticlePublishedNotification;
use App\Listeners\Notifications\SendDemandResponseNotification;
use App\Listeners\Notifications\SendNewReviewNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        DemandCreated::class => [
            SendDemandCreatedNotification::class,
        ],
        NewOfferCreated::class => [
            SendNewOfferNotification::class,
        ],
        ArticlePublished::class => [
            SendArticlePublishedNotification::class,
        ],
        DemandResponseCreated::class => [
            SendDemandResponseNotification::class,
        ],
        NewReviewCreated::class => [
            SendNewReviewNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // ⚠️ LAISSER VIDE - pas de Event::listen() manuels ici
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false; // ✅ Désactiver l'auto-discovery pour éviter les doublons
    }
}