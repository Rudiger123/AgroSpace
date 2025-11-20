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
        $subscribers = NewsletterSubscriber::where('status', 'active')
            ->orWhere('is_active', true)
            ->get();

        // Also notify registered users who enabled blog notifications
        $users = User::where('blog_notifications_enabled', true)->get();

        // Combine both collections
        $recipients = $subscribers->merge($users);

        // Send notification to each recipient
        foreach ($recipients as $recipient) {
            $recipient->notify(new ArticlePublishedNotification($event->article, $event->author));
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
