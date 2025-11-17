<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\NewsletterSubscriber;

class NewsletterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public NewsletterSubscriber $subscriber,
        public string $newsletterSubject,
        public string $newsletterMessage
    ) {}

    public function build()
    {
        $unsubscribeUrl = route('newsletter.unsubscribe', [
            'token' => $this->subscriber->unsubscribe_token
        ]);

        return $this->subject($this->newsletterSubject)
                    ->view('emails.newsletter')
                    ->with([
                        'subscriberName' => $this->subscriber->name,
                        'messageContent' => $this->newsletterMessage,
                        'unsubscribeUrl' => $unsubscribeUrl,
                    ]);
    }
}
