<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmail extends Command
{
    protected $signature = 'email:test';
    protected $description = 'Test email configuration with MailHog';

    public function handle()
    {
        try {
            Mail::raw('Ceci est un email de test depuis Laravel!', function ($message) {
                $message->to('test@agrospace.cm')
                        ->subject('Test Email Laravel - MailHog');
            });

            $this->info('✅ Email envoyé avec succès!');
            $this->info('📧 Vérifiez MailHog: http://localhost:8025');
        } catch (\Exception $e) {
            $this->error('❌ Erreur: ' . $e->getMessage());
        }
    }
}
