<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\ArticlePublished;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use App\Notifications\ArticlePublishedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendArticlePublishedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ArticlePublished $event
     * @return void
     */
    public function handle(ArticlePublished $event): void
    {
        // Get all active newsletter subscribers
        $subscribers = \App\Models\NewsletterSubscriber::whereNull('unsubscribe_token')->get();
    
        // Get registered users who enabled blog notifications through their preferences
        $users = \App\Models\User::whereHas('preferences', function($query) {
                $query->where('notify_articles', true);
            })
            ->with('preferences') // Charger les préférences pour éviter les requêtes N+1
            ->get();
    
        // Combine both collections
        $recipients = $subscribers->merge($users);
    
        \Log::info("Envoi de notifications à " . $recipients->count() . " destinataires");
    
        // Send notification to each recipient
        foreach ($recipients as $recipient) {
            try {
                $recipient->notify(new ArticlePublishedNotification($event->article, $event->author));
                \Log::info("Notification envoyée à: " . ($recipient->email ?? $recipient->id));
            } catch (\Exception $e) {
                \Log::error("Erreur envoi notification: " . $e->getMessage());
            }
        }
    }

    /**
     * Handle a job failure.
     *
     * @param ArticlePublished $event
     * @param \Throwable $exception
     * @return void
     */
    public function failed(ArticlePublished $event, $exception): void
    {
        logger()->error('Failed to send article published notification', [
            'article_id' => $event->article->id,
            'article_title' => $event->article->title,
            'error' => $exception->getMessage(),
        ]);
    }
}
