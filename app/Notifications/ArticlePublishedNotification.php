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
     */
    public function __construct(Post $article, User $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        // For newsletter subscribers, only send email
        if ($notifiable instanceof \App\Models\NewsletterSubscriber) {
            return ['mail'];
        }

        // For registered users, check their preferences
        if ($notifiable instanceof User) {
            $channels = ['database'];
            
            // Load preferences if not loaded
            if (!$notifiable->relationLoaded('preferences')) {
                $notifiable->load('preferences');
            }
            
            $preferences = $notifiable->preferences ?? new \App\Models\UserPreference(\App\Models\UserPreference::getDefaults());
            
            if ($preferences->email_notifications && $preferences->notify_articles) {
                $channels[] = 'mail';
            }
            
            if ($preferences->push_notifications && $preferences->notify_articles) {
                $channels[] = 'broadcast';
            }
            
            return $channels;
        }

        return ['mail']; // fallback
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $recipientName = $notifiable->name ?? $notifiable->email ?? 'Cher(e) abonné(e)';

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
     * Get the array representation for database.
     */
    public function toArray($notifiable): array
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