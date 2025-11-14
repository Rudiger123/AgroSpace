<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoModerateOffers extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'offers:auto-moderate
                            {--suspend-expired : Suspendre automatiquement les offres expirées}
                            {--alert-pending : Envoyer des alertes pour les offres en attente depuis plus de 48h}';

    /**
     * The console command description.
     */
    protected $description = 'Automatise certaines tâches de modération des offres';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Démarrage de la modération automatique...');

        // Suspendre les offres expirées
        if ($this->option('suspend-expired')) {
            $this->suspendExpiredOffers();
        }

        // Alerter pour les offres en attente depuis longtemps
        if ($this->option('alert-pending')) {
            $this->alertPendingOffers();
        }

        // Si aucune option n'est spécifiée, tout exécuter
        if (!$this->option('suspend-expired') && !$this->option('alert-pending')) {
            $this->suspendExpiredOffers();
            $this->alertPendingOffers();
        }

        $this->newLine();
        $this->info('✅ Modération automatique terminée !');

        return 0;
    }

    /**
     * Suspendre les offres expirées
     */
    protected function suspendExpiredOffers()
    {
        $this->info('📅 Suspension des offres expirées...');

        $expiredOffers = Offer::where('statut', '!=', 'expiré')
            ->where('statut', '!=', 'suspendu')
            ->where('date_expiration', '<', now())
            ->get();

        $count = $expiredOffers->count();

        if ($count === 0) {
            $this->line('   ✓ Aucune offre expirée trouvée.');
            return;
        }

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach ($expiredOffers as $offer) {
            $offer->update(['statut' => 'expiré']);
            
            // TODO: Notifier le producteur
            
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("   ✓ {$count} offre(s) expirée(s) suspendue(s)");
    }

    /**
     * Alerter pour les offres en attente depuis plus de 48h
     */
    protected function alertPendingOffers()
    {
        $this->info('⏰ Vérification des offres en attente...');

        $pendingOffers = Offer::where('statut', 'en attente')
            ->where('date_publication', '<', now()->subHours(48))
            ->with('producer')
            ->get();

        $count = $pendingOffers->count();

        if ($count === 0) {
            $this->line('   ✓ Aucune offre en attente depuis plus de 48h.');
            return;
        }

        $this->warn("   ⚠️  {$count} offre(s) en attente depuis plus de 48h :");

        foreach ($pendingOffers as $offer) {
            $hours = now()->diffInHours($offer->date_publication);
            $this->line("      - {$offer->titre} (#{$offer->id}) - {$hours}h - Producteur: {$offer->producer->name}");
        }

        // TODO: Envoyer notification aux admins
    }
}

// ============================================
// app/Console/Kernel.php
// Ajouter dans la méthode schedule()
// ============================================

protected function schedule(Schedule $schedule)
{
    // Modération automatique tous les jours à 01h00
    $schedule->command('offers:auto-moderate')
        ->dailyAt('01:00')
        ->name('auto-moderate-offers')
        ->withoutOverlapping()
        ->onSuccess(function () {
            \Log::info('Modération automatique effectuée avec succès');
        })
        ->onFailure(function () {
            \Log::error('Erreur lors de la modération automatique');
        });

    // Alertes pour offres en attente toutes les 12h
    $schedule->command('offers:auto-moderate --alert-pending')
        ->twiceDaily(9, 18)
        ->name('alert-pending-offers')
        ->withoutOverlapping();
}