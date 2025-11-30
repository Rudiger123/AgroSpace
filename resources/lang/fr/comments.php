<?php

return [
    'management' => [
        'title' => 'Gestion des Commentaires',
        'subtitle' => 'Modérez et gérez tous les commentaires du blog',
    ],

    'filters' => [
        'title' => 'Filtrage et Recherche',
        'search' => 'Rechercher',
        'search_placeholder' => 'Contenu, auteur, email...',
        'status' => 'Statut',
        'post' => 'Article',
        'all_posts' => 'Tous les articles',
        'per_page' => 'Par page',
    ],

    'status' => [
        'all' => 'Tous',
        'pending' => 'En attente',
        'approved' => 'Approuvé',
        'rejected' => 'Rejeté',
        'spam' => 'Spam',
    ],

    'table' => [
        'comment' => 'Commentaire',
        'post' => 'Article',
        'author' => 'Auteur',
        'status' => 'Statut',
        'likes' => 'Likes',
        'reports' => 'Signal.',
        'ip' => 'IP',
        'date' => 'Date',
        'actions' => 'Actions',
        'na' => 'N/A',
        'anonymous' => 'Anonyme',
        'no_comments' => 'Aucun commentaire trouvé',
        'adjust_filters' => 'Veuillez ajuster vos filtres de recherche.',
    ],

    'actions' => [
        'delete_selected' => 'Supprimer (:count)',
        'details' => 'Détails',
        'approve' => 'Approuver',
        'reject' => 'Rejeter',
        'spam' => 'Spam',
        'delete' => 'Supprimer',
        'confirm_delete' => 'Oui, supprimer',
        'confirm_bulk_delete' => 'Oui, supprimer tout',
        'cancel' => 'Annuler',
    ],

    'messages' => [
        'confirm_delete_title' => 'Êtes-vous sûr ?',
        'confirm_delete_text' => 'Cette action est irréversible !',
        'confirm_bulk_delete_title' => 'Supprimer les commentaires sélectionnés ?',
        'confirm_bulk_delete_text' => 'Cette action est irréversible !',
        'approved_title' => 'Approuvé',
        'rejected_title' => 'Rejeté',
        'spam_title' => 'Spam',
        'deleted_title' => 'Supprimé',
        'bulk_deleted_title' => 'Supprimés',
    ],
];
