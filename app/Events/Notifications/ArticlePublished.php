<?php

namespace App\Events\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArticlePublished implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Post $article;
    public User $author;

    /**
     * Create a new event instance.
     *
     * @param Post $article
     * @param User $author
     */
    public function __construct(Post $article, User $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast to all authenticated users (public channel)
        return [
            new Channel('articles'),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'article.published';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
            'article_slug' => $this->article->slug,
            'author_name' => $this->author->name,
            'category' => $this->article->category->name ?? null,
            'excerpt' => $this->article->excerpt,
            'featured_image' => $this->article->featured_image,
            'published_at' => $this->article->published_at->toIso8601String(),
        ];
    }
}
