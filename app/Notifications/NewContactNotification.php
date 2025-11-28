<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Contact $contact)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📩 Nouveau message de contact - ' . $this->contact->subject)
            ->greeting('Bonjour Admin,')
            ->line('Vous avez reçu un nouveau message de contact.')
            ->line('**De:** ' . $this->contact->name)
            ->line('**Email:** ' . $this->contact->email)
            ->line('**Sujet:** ' . $this->contact->subject)
            ->line('**Message:**')
            ->line($this->contact->message)
            ->action('Voir le message', route('admin.contacts.index'))
            ->line('Merci d\'utiliser AgroSpace!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'contact_id' => $this->contact->id,
            'name' => $this->contact->name,
            'email' => $this->contact->email,
            'subject' => $this->contact->subject,
            'message' => $this->contact->message,
        ];
    }
}