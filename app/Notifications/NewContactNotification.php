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
        return (new MailMessage())
            ->subject('Nouveau message de contact - ' . $this->contact->subject)
            ->view('emails.notification', [
                'title'      => 'Nouveau message de contact',
                'content'    => view('emails.partials.new-contact-admin', [
                    'contact' => $this->contact,
                ])->render(),
                'actionText' => 'Voir tous les messages',
                'actionUrl'  => route('contacts.index'),
            ]);
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
