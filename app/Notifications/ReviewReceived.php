<?php

namespace App\Notifications;

use App\Models\Avis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReviewReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $avis;

    public function __construct(Avis $avis)
    {
        $this->avis = $avis;
    }

    public function via($notifiable): array
    {
        $channels = ['database'];
        if ($notifiable->email_notifications_enabled ?? true) {
            $channels[] = 'mail';
        }
        if ($notifiable->push_notifications_enabled ?? true) {
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Nouvel avis reçu sur AgroSpace')
            ->view('emails.notification', [
                'title'      => 'Nouvel avis (' . $this->avis->note . '/5)',
                'content'    => view('emails.partials.review-received', [
                    'notifiable' => $notifiable,
                    'avis'       => $this->avis,
                ])->render(),
                'actionText' => 'Voir mes avis',
                'actionUrl'  => route('admin.avis', ["search" => $this->avis->title]),
            ]);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'review_received',
            'title' => 'Nouvel avis reçu (' . $this->avis->note . '/5)',
            'message' => ($this->avis->consumer->name ?? 'Un utilisateur') . ' a évalué vos services.',
            'model_id' => $this->avis->id,
            'model_type' => Avis::class,
            'action_url' => route('admin.avis', ["search" => $this->avis->title]), // Ajuster la route
            'icon' => 'star',
            'color' => 'yellow',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'review_received',
            'title' => 'Nouvel avis ⭐',
            'message' => 'Vous avez reçu une note de ' . $this->avis->note . '/5',
            'action_url' => route('admin.avis', ["search" => $this->avis->title]),
            'icon' => 'star',
            'color' => 'yellow',
            'created_at' => now()->toIso8601String(),
        ]);
    }
}
