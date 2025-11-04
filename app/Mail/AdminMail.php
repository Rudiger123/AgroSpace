<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailMessage;

    public function __construct($subject, $message)
    {
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
    }

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->view('emails.admin-email')
                    ->with([
                        'subject' => $this->emailSubject,
                        'message' => $this->emailMessage,
                    ]);
    }
}