<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $subscriber,
        public string $subject,
        public string $message
    ) {}

    public function handle()
    { 
        $subscriberUrl = route('newsletter.unsubscribe', [
            'token' => $this->subscriber->unsubscribe_token
        ]);
        
        Mail::to($this->subscriber->email)->send(
            new NewsletterMail($this->subscriber, $this->subject, $this->message)
        );
    }
}