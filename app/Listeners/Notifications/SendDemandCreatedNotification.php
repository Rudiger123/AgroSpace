<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\DemandCreated;
use App\Models\User;
use App\Notifications\DemandCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SendDemandCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;
    
    public $queue = 'notifications';
    public $connection = 'redis';
    public $tries = 1;
    public $timeout = 60;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DemandCreated $event): void
    {
        try {
            Log::info('🎯 Début du traitement des notifications', [
                'demand_id' => $event->demand->id,
                'user_id' => $event->user->id
            ]);

            // 🔒 Verrou pour éviter les doublons
            $lockKey = "demand_notification:{$event->demand->id}";
            $lock = Cache::lock($lockKey, 30); // 30 secondes

            if (!$lock->get()) {
                Log::warning('🔒 Notification déjà en cours de traitement', [
                    'demand_id' => $event->demand->id
                ]);
                return;
            }

            try {
                // Récupérer tous les administrateurs
                $admins = $this->getRecipients($event);

                Log::info('👥 Administrateurs trouvés', [
                    'count' => $admins->count(),
                    'demand_id' => $event->demand->id
                ]);

                $notificationsSent = 0;

                // Envoyer la notification à chaque administrateur
                foreach ($admins as $admin) {
                    try {
                        // Vérifier si la notification existe déjà (protection supplémentaire)
                        $notificationExists = $this->notificationAlreadyExists($admin, $event->demand->id);
                        
                        if ($notificationExists) {
                            Log::warning('⚠️ Notification déjà envoyée', [
                                'admin_id' => $admin->id,
                                'demand_id' => $event->demand->id
                            ]);
                            continue;
                        }

                        $admin->notify(new DemandCreatedNotification(
                            $event->demand,
                            $event->user
                        ));

                        $notificationsSent++;
                        
                        Log::debug('✅ Notification envoyée', [
                            'admin_id' => $admin->id,
                            'demand_id' => $event->demand->id
                        ]);

                    } catch (\Exception $e) {
                        Log::error('❌ Erreur envoi notification à un admin', [
                            'admin_id' => $admin->id,
                            'demand_id' => $event->demand->id,
                            'error' => $e->getMessage()
                        ]);
                        // Continuer avec les autres admins même si un échoue
                    }
                }

                Log::info('📊 Résumé des notifications', [
                    'demand_id' => $event->demand->id,
                    'admins_total' => $admins->count(),
                    'notifications_sent' => $notificationsSent,
                    'notifications_skipped' => $admins->count() - $notificationsSent
                ]);

            } finally {
                $lock->release();
                Log::info('🔓 Verrou libéré', ['demand_id' => $event->demand->id]);
            }

        } catch (\Exception $e) {
            Log::error('💥 Erreur critique dans le listener', [
                'demand_id' => $event->demand->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Relancer l'exception pour marquer le job comme échoué
            throw $e;
        }
    }

    /**
     * Get notification recipients (tous les administrateurs).
     */
    protected function getRecipients(DemandCreated $event)
    {
        try {
            return User::where('role_id', 1) // ID 1 = Administrateur
                       ->where('status', 'active') // Seulement les admins actifs
                       ->get();
        } catch (\Exception $e) {
            Log::error('❌ Erreur récupération des administrateurs', [
                'error' => $e->getMessage()
            ]);
            return collect(); // Retourner une collection vide en cas d'erreur
        }
    }

    /**
     * Vérifie si une notification existe déjà pour cette demande et cet admin.
     */
    protected function notificationAlreadyExists(User $admin, int $demandId): bool
    {
        try {
            return $admin->notifications()
                ->where('type', DemandCreatedNotification::class)
                ->where('data->demand_id', $demandId)
                ->exists();
        } catch (\Exception $e) {
            Log::warning('⚠️ Erreur vérification notification existante', [
                'admin_id' => $admin->id,
                'demand_id' => $demandId,
                'error' => $e->getMessage()
            ]);
            return false; // En cas d'erreur, on considère qu'elle n'existe pas
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(DemandCreated $event, $exception): void
    {
        Log::error('💥 Échec critique du listener SendDemandCreatedNotification', [
            'event' => get_class($event),
            'demand_id' => $event->demand->id ?? 'unknown',
            'user_id' => $event->user->id ?? 'unknown',
            'error' => $exception->getMessage(),
            'exception_class' => get_class($exception),
            'trace' => $exception->getTraceAsString()
        ]);

        // Optionnel: Notifier les super-admins de l'échec
        // $this->notifyAdminsOfFailure($event, $exception);
    }

    /**
     * Optionnel: Notifier les super-admins des échecs critiques
     */
    protected function notifyAdminsOfFailure(DemandCreated $event, $exception): void
    {
        try {
            $superAdmins = User::where('role_id', 1)
                              ->get();

            foreach ($superAdmins as $admin) {
                // Envoyer une notification d'erreur (vous pouvez créer une notification spéciale)
                Log::alert('🚨 Notification d\'échec envoyée à super-admin', [
                    'admin_id' => $admin->id,
                    'demand_id' => $event->demand->id ?? 'unknown'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('❌ Impossible de notifier les super-admins', [
                'error' => $e->getMessage()
            ]);
        }
    }
}