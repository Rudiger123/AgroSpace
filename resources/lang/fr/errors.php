<?php

return [
    '403' => [
        'title' => 'Accès Refusé',
        'message' => 'Zone Restreinte',
        'description' => 'Désolé, cette zone de l\'exploitation est réservée au personnel autorisé. Vous n\'avez pas les clés du hangar.',
    ],
    '404' => [
        'title' => 'Parcelle Introuvable',
        'message' => 'Oups ! Cette parcelle n\'existe pas.',
        'description' => 'Il semble que vous ayez labouré trop loin. La page que vous cherchez a peut-être été récoltée ou déplacée.',
    ],
    '419' => [
        'title' => 'Session Expirée',
        'message' => 'Temps de pause écoulé',
        'description' => 'Votre session a expiré par inactivité. Veuillez recharger la page pour reprendre votre travail.',
        'refresh' => 'Rafraîchir la page',
    ],
    '429' => [
        'title' => 'Trop de requêtes',
        'message' => 'Doucement sur la pédale !',
        'description' => 'Vous envoyez trop de demandes au serveur. Laissez un peu de temps à la nature pour respirer.',
    ],
    '500' => [
        'title' => 'Erreur Technique',
        'message' => 'Panne Moteur',
        'description' => 'Notre système d\'irrigation numérique rencontre un problème inattendu. Nos techniciens sont déjà dans le champ pour réparer ça.',
    ],
    '503' => [
        'title' => 'Maintenance en cours',
        'message' => 'Nous cultivons des nouveautés',
        'description' => 'AgroSpace est actuellement en maintenance pour améliorer votre expérience. Nous serons de retour après la récolte (quelques minutes).',
        'checking' => 'Vérification automatique du statut...',
        'console' => 'Toujours en maintenance...',
    ],
    'back_to_fields' => 'Retour aux champs',
];
