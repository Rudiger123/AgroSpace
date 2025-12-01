<?php

namespace App\Notifications;

use App\Models\DemandResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDemandResponse extends Notification implements ShouldQueue
{
    use Queueable;

    public $response;

    public function __construct(DemandResponse $response)
    {
        $this->response = $response;
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
        $responder = $this->response->user;

        return (new MailMessage())
            ->subject('Nouvelle proposition pour votre demande')
            ->view('emails.notification', [
                'title'      => 'Vous avez une nouvelle proposition !',
                'content'    => view('emails.partials.new-demand-response', [
                    'notifiable' => $notifiable,
                    'responder'  => $responder,
                    'response'   => $this->response,
                ])->render(),
                'actionText' => 'Voir la proposition',
                'actionUrl'  => route('demands-management', $this->response->demand_id),
            ]);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'demand_response',
            'title' => 'Nouvelle réponse à votre demande',
            'message' => ($this->response->user->name ?? 'Quelqu\'un') . ' vous a fait une proposition.',
            'model_id' => $this->response->id,
            'model_type' => DemandResponse::class,
            'action_url' => route('demands-management', $this->response->demand_id),
            'icon' => 'message',
            'color' => 'blue',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'demand_response',
            'title' => 'Nouvelle proposition 📩',
            'message' => 'Une réponse a été ajoutée à votre demande.',
            'action_url' => route('demands-management', $this->response->demand_id),
            'icon' => 'message',
            'color' => 'blue',
            'created_at' => now()->toIso8601String(),
        ]);
    }
}
