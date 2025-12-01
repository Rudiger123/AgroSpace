<?php

return [
    'title' => 'Gestion des Tags',
    'subtitle' => 'Organisez et catégorisez vos contenus avec style',
    'new_tag' => 'Nouveau Tag',
    'more_actions' => 'Plus d\'actions',
    'export_csv' => 'Exporter CSV',
    'import_csv' => 'Importer CSV',
    'delete_selected' => 'Supprimer la sélection (:count)',

    'search_placeholder' => 'Rechercher un tag...',
    'sort_by_name' => 'Trier par nom',
    'sort_by_date' => 'Date de création',
    'sort_by_color' => 'Couleur',
    'sort_by_status' => 'Statut',
    'sort_order' => 'Ordre',

    'filter_all' => 'Tous les tags',
    'filter_active' => 'Actifs',
    'filter_inactive' => 'Inactifs',

    'stats' => [
        'total' => 'Total Tags',
        'active' => 'Actifs',
        'selected' => 'Sélectionnés',
        'colors' => 'Couleurs',
    ],

    'default_color' => 'Couleur par défaut',
    'status' => [
        'active' => 'Actif',
        'inactive' => 'Inactif',
    ],

    'actions' => [
        'edit' => 'Modifier',
        'duplicate' => 'Dupliquer',
        'delete' => 'Supprimer',
    ],

    'modal' => [
        'edit_title' => 'Modifier le Tag',
        'edit_subtitle' => 'Mettez à jour les informations du tag',
        'create_title' => 'Créer un Tag',
        'create_subtitle' => 'Ajoutez un nouveau tag à votre collection',
    ],

    'form' => [
        'name' => 'Nom',
        'name_placeholder' => 'Entrez le nom du tag...',
        'slug' => 'Slug',
        'slug_placeholder' => 'slug-automatique',
        'description' => 'Description',
        'description_placeholder' => 'Décrivez ce tag en détail...',
        'color' => 'Couleur',
        'color_presets' => 'Couleurs prédéfinies',
        'status' => 'Statut du tag',
        'status_description' => 'Activez ou désactivez ce tag',
    ],

    'buttons' => [
        'cancel' => 'Annuler',
        'update' => 'Mettre à jour',
        'create' => 'Créer',
        'delete' => 'Supprimer',
        'import' => 'Importer',
        'delete_all' => 'Supprimer tout',
    ],

    'delete_modal' => [
        'title' => 'Confirmer la suppression',
        'message' => 'Êtes-vous sûr de vouloir supprimer ce tag ? Cette action est irréversible.',
    ],

    'import_modal' => [
        'title' => 'Importer des tags',
        'file_label' => 'Fichier CSV',
        'click_to_choose' => 'Cliquez pour choisir un fichier CSV',
        'format' => 'Format: nom, description, couleur, statut',
    ],

    'bulk_delete_modal' => [
        'title' => 'Suppression multiple',
        'message' => 'Êtes-vous sûr de vouloir supprimer ces tags ?',
        'tags_count' => 'tags',
    ],

    'notifications' => [
        'color_copied' => 'Couleur copiée !',
    ],
        'validation' => [
            'name_required' => 'Le nom du tag est obligatoire.',
            'slug_required' => 'Le slug est obligatoire.',
            'slug_unique' => 'Ce tag existe déjà.',
        ],
        'updated_success' => 'Tag mis à jour avec succès !',
        'created_success' => 'Tag créé avec succès !',
        'deleted_success' => 'Tag supprimé avec succès !',
        'bulk_deleted_success' => 'tags supprimés avec succès !',
        'status_updated' => 'Statut du tag mis à jour !',
        'duplicated_success' => 'Tag dupliqué avec succès !',
        'copy_suffix' => 'Copie',
        'export_header' => 'Nom,Slug,Description,Couleur,Statut',
        'export_filename' => 'tags-export',
        'status_active' => 'Actif',
        'status_inactive' => 'Inactif',
        'imported_success' => 'tags importés avec succès !',
    ];
