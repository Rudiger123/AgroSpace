<?php

// config/demands.php

return [

    /*
    |--------------------------------------------------------------------------
    | Paramètres généraux des demandes
    |--------------------------------------------------------------------------
    */

    'default_validity_days' => 30, // Durée par défaut d'une demande (jours)

    'min_description_length' => 20, // Nombre minimum de caractères pour la description

    'max_description_length' => 2000, // Nombre maximum de caractères

    'min_response_length' => 20, // Longueur minimale d'une réponse

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    'pagination' => [
        'my_demands' => 10,      // Mes demandes
        'public_demands' => 12,  // Demandes publiques (grille 3 colonnes)
        'admin_demands' => 15,   // Administration
    ],

    /*
    |--------------------------------------------------------------------------
    | Régions du Cameroun
    |--------------------------------------------------------------------------
    */

    'regions' => [
        'Adamaoua',
        'Centre',
        'Est',
        'Extrême-Nord',
        'Littoral',
        'Nord',
        'Nord-Ouest',
        'Ouest',
        'Sud',
        'Sud-Ouest',
    ],

    /*
    |--------------------------------------------------------------------------
    | Niveaux d'urgence
    |--------------------------------------------------------------------------
    */

    'urgency_levels' => [
        'low' => [
            'label' => 'Basse',
            'icon' => '🟢',
            'color' => 'bg-green-100 text-green-700',
        ],
        'medium' => [
            'label' => 'Moyenne',
            'icon' => '🟡',
            'color' => 'bg-yellow-100 text-yellow-700',
        ],
        'high' => [
            'label' => 'Haute',
            'icon' => '🔴',
            'color' => 'bg-red-100 text-red-700',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Statuts des demandes
    |--------------------------------------------------------------------------
    */

    'statuses' => [
        'active' => [
            'label' => 'Active',
            'color' => 'bg-green-100 text-green-700',
            'icon' => '✅',
        ],
        'satisfied' => [
            'label' => 'Satisfaite',
            'color' => 'bg-blue-100 text-blue-700',
            'icon' => '👍',
        ],
        'expired' => [
            'label' => 'Expirée',
            'color' => 'bg-gray-100 text-gray-700',
            'icon' => '⏰',
        ],
        'cancelled' => [
            'label' => 'Annulée',
            'color' => 'bg-red-100 text-red-700',
            'icon' => '❌',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Modération
    |--------------------------------------------------------------------------
    */

    'moderation' => [
        'auto_verify' => false, // Vérification automatique des demandes
        'require_admin_approval' => false, // Approbation admin requise avant publication
        'max_demands_per_day' => 5, // Nombre max de demandes par utilisateur/jour
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        'notify_on_new_response' => true, // Notifier le demandeur d'une nouvelle réponse
        'notify_on_demand_expiring' => true, // Notifier 3 jours avant expiration
        'notify_admin_on_new_demand' => false, // Notifier admin de chaque nouvelle demande
    ],

    /*
    |--------------------------------------------------------------------------
    | Limites
    |--------------------------------------------------------------------------
    */

    'limits' => [
        'max_active_demands_per_user' => 10, // Max demandes actives par utilisateur
        'max_responses_per_demand' => null, // null = illimité
        'min_budget' => 0,
        'max_budget' => 100000000, // 100 millions FCFA
    ],

    /*
    |--------------------------------------------------------------------------
    | Expiration automatique
    |--------------------------------------------------------------------------
    */

    'auto_expire' => [
        'enabled' => true, // Activer l'expiration automatique
        'schedule' => '00:01', // Heure d'exécution quotidienne (format H:i)
        'notify_before_days' => 3, // Notifier X jours avant expiration
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */

    'cache' => [
        'categories_ttl' => 86400, // 24 heures (en secondes)
        'stats_ttl' => 3600, // 1 heure
    ],

];