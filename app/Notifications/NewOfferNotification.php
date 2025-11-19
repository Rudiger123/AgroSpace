<?php

namespace App\Notifications;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOfferNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Offer $offer;
    public User $creator;

    /**
     * Create a new notification instance.
     *
     * @param Offer $offer
     * @param User $creator
     */
    public function __construct(Offer $offer, User $creator)
    {
        $this->offer = $offer;
        $this->creator = $creator;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        // Customize channels based on user preferences
        $channels = ['database'];

        if ($notifiable->email_notifications_enabled ?? true) {
            $channels[] = 'mail';
        }

        if ($notifiable->push_notifications_enabled ?? true) {
            $channels[] = 'broadcast';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle offre disponible - ' . $this->offer->titre)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Une nouvelle offre vient d\'être publiée sur AgroSpace.')
            ->line('**' . $this->offer->titre . '**')
            ->line($this->offer->description)
            ->line('Producteur : ' . $this->creator->name)
            ->line('Prix : ' . number_format($this->offer->prix, 0, ',', ' ') . ' FCFA')
            ->action('Voir l\'offre', route('offers.moderate', ['search' => $this->offer->titre]))
            ->line('Merci d\'utiliser AgroSpace !');
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
            'type' => 'new_offer',
            'title' => 'Nouvelle offre disponible',
            'message' => $this->creator->name . ' a publié une nouvelle offre : ' . $this->offer->titre,
            'offer_id' => $this->offer->id,
            'offer_title' => $this->offer->titre,
            'offer_price' => $this->offer->prix,
            'creator_id' => $this->creator->id,
            'creator_name' => $this->creator->name,
            'category' => $this->offer->category->name ?? null,
            'action_url' => route('offers.moderate', ['search' => $this->offer->titre]),
            'icon' => 'offer',
            'color' => 'green',
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
            'type' => 'new_offer',
            'title' => 'Nouvelle offre disponible',
            'message' => $this->creator->name . ' a publié une nouvelle offre : ' . $this->offer->titre,
            'offer_id' => $this->offer->id,
            'creator_name' => $this->creator->name,
            'action_url' => route('offers.moderate', ['search' => $this->offer->titre]),
            'icon' => 'shopping-bag',
            'color' => 'green',
            'created_at' => now()->toIso8601String(),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'offer_id' => $this->offer->id,
            'creator_id' => $this->creator->id,
        ];
    }
}