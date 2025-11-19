<?php

namespace App\Providers;

use App\Events\Notifications\ArticlePublished;
use App\Events\Notifications\NewOfferCreated;
use App\Events\Notifications\ProducerRated;
use App\Listeners\Notifications\SendArticlePublishedNotification;
use App\Listeners\Notifications\SendNewOfferNotification;
use App\Listeners\Notifications\SendProducerRatedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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

        // Notification Events
        NewOfferCreated::class => [
            SendNewOfferNotification::class,
        ],

        ProducerRated::class => [
            SendProducerRatedNotification::class,
        ],

        ArticlePublished::class => [
            SendArticlePublishedNotification::class,
        ],

        // Add more events here as needed
        // DemandCreated::class => [
        //     SendDemandCreatedNotification::class,
        // ],
        // OrderPlaced::class => [
        //     SendOrderPlacedNotification::class,
        // ],
        // MessageReceived::class => [
        //     SendMessageReceivedNotification::class,
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
