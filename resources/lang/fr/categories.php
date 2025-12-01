<?php

return [
    'title' => 'Gestion des Catégories',
    'subtitle' => 'Gérez vos catégories de produits agricoles',
    'new_category' => 'Nouvelle Catégorie',

    'search_placeholder' => 'Rechercher une catégorie...',
    'filter_all_types' => 'Tous les types',
    'type_offer' => 'Offre',
    'type_demand' => 'Demande',
    'type_post' => 'Article',
    'sort_by_name' => 'Nom',
    'sort_by_date' => 'Date de création',
    'sort_by_status' => 'Statut',

    'modal' => [
        'edit_title' => 'Modifier la Catégorie',
        'create_title' => 'Nouvelle Catégorie',
    ],

    'form' => [
        'name' => 'Nom',
        'slug' => 'Slug',
        'type' => 'Type',
        'icon' => 'Icône',
        'icon_placeholder' => 'Clique pour choisir un emoji',
        'icon_help' => 'Clique pour sélectionner un emoji',
        'color' => 'Couleur',
        'description' => 'Description',
        'active_category' => 'Catégorie active',
    ],

    'buttons' => [
        'cancel' => 'Annuler',
        'update' => 'Mettre à jour',
        'create' => 'Créer',
        'delete' => 'Supprimer',
    ],

    'delete_modal' => [
        'title' => 'Confirmer la suppression',
        'message' => 'Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.',
    ],

    'notifications' => [
        'color_copied' => 'Couleur copiée !',
    ],

        'validation' => [
            'name_required' => 'Le nom de la catégorie est obligatoire.',
            'slug_required' => 'Le slug est obligatoire.',
            'slug_unique' => 'Ce slug est déjà utilisé.',
            'color_required' => 'La couleur est obligatoire.',
        ],
        'updated_success' => 'Catégorie mise à jour avec succès.',
        'created_success' => 'Catégorie créée avec succès.',
        'deleted_success' => 'Catégorie supprimée avec succès.',
        'status_updated' => 'Statut de la catégorie mis à jour.',
    ];
