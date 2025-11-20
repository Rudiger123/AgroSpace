<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticlePublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Post $article;
    public User $author;

    /**
     * Create a new notification instance.
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
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        // For newsletter subscribers, only send email
        if ($notifiable instanceof \App\Models\NewsletterSubscriber) {
            return ['mail'];
        }

        // For registered users, send all channels
        return ['database', 'mail', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $recipientName = $notifiable->name ?? 'Cher(e) abonné(e)';

        return (new MailMessage())
            ->subject('Nouvel article : ' . $this->article->title)
            ->greeting('Bonjour ' . $recipientName . ',')
            ->line('Un nouvel article vient d\'être publié sur le blog AgroSpace.')
            ->line('**' . $this->article->title . '**')
            ->line($this->article->excerpt ?? strip_tags(substr($this->article->content, 0, 150)) . '...')
            ->line('Auteur : ' . $this->author->name)
            ->line('Catégorie : ' . ($this->article->category->name ?? 'Non catégorisé'))
            ->action('Lire l\'article', route('blog.show', $this->article->slug))
            ->line('Merci de faire partie de la communauté AgroSpace !');
    }

    /**
     * Get the array representation of the notification for database.
     *
     * @param mixed $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'article_published',
            'title' => 'Nouvel article publié',
            'message' => 'Un nouvel article est disponible : ' . $this->article->title,
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
            'article_slug' => $this->article->slug,
            'article_excerpt' => $this->article->excerpt,
            'author_id' => $this->author->id,
            'author_name' => $this->author->name,
            'category' => $this->article->category->name ?? null,
            'featured_image' => $this->article->featured_image,
            'action_url' => route('blog.show', $this->article->slug),
            'icon' => 'newspaper',
            'color' => 'purple',
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'article_published',
            'title' => 'Nouvel article publié',
            'message' => $this->article->title,
            'article_id' => $this->article->id,
            'article_slug' => $this->article->slug,
            'author_name' => $this->author->name,
            'action_url' => route('blog.show', $this->article->slug),
            'icon' => 'article',
            'color' => 'purple',
            'created_at' => now()->toIso8601String(),
        ]);
    }
}
