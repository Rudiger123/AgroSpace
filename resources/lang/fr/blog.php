<?php

return [
    // Messages d'erreur et succès généraux
    'errors' => [
        'auth_required' => 'Vous devez être connecté pour effectuer cette action.',
        'comment_not_found' => 'Commentaire introuvable.',
        'spam_detected' => 'Votre commentaire semble être du spam. Veuillez réessayer.',
        'reaction_error' => 'Erreur lors de la mise à jour de la réaction.',
        'share_error' => 'Erreur lors du partage.',
        'comment_error' => 'Une erreur est survenue lors de l\'ajout du commentaire.',
        'operation_error' => 'Erreur lors de l\'opération.',
        'delete_error' => 'Erreur lors de la suppression.',
        'save_error' => 'Erreur lors de la sauvegarde.',
        'no_selection' => 'Aucun élément sélectionné.'
    ],
    
    'success' => [
        'comment_added' => 'Commentaire ajouté avec succès !',
        'liked' => 'Article aimé !',
        'unliked' => 'Like retiré.',
        'shared' => 'Merci d\'avoir partagé cet article !',
        'saved' => 'Enregistrement réussi !',
        'deleted' => 'Suppression réussie !',
        'approved' => 'Approbation réussie !',
        'rejected' => 'Rejet réussi !',
        'marked_spam' => 'Marqué comme spam !',
        'published' => 'Article publié !',
        'unpublished' => 'Article dépublié !',
        'featured' => 'Article mis en avant !',
        'unfeatured' => 'Article retiré de la mise en avant !'
    ],
    
    // Validation
    'validation' => [
        'comment_required' => 'Veuillez saisir un commentaire.',
        'comment_min' => 'Le commentaire doit contenir au moins 3 caractères.',
        'comment_max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        'title_required' => 'Le titre est obligatoire.',
        'title_min' => 'Le titre doit contenir au moins 3 caractères.',
        'slug_required' => 'Le slug est obligatoire.',
        'slug_unique' => 'Ce slug est déjà utilisé.',
        'content_required' => 'Le contenu est obligatoire.',
        'content_min' => 'Le contenu doit contenir au moins 10 caractères.',
        'image_invalid' => 'L\'image doit être un fichier image valide.',
        'image_max' => 'L\'image ne doit pas dépasser 2 Mo.'
    ],
    
    // Boutons et actions
    'actions' => [
        'like' => 'Aimer',
        'unlike' => 'Ne plus aimer',
        'comment' => 'Commenter',
        'reply' => 'Répondre',
        'cancel_reply' => 'Annuler la réponse',
        'share' => 'Partager',
        'read_more' => 'Lire la suite',
        'view_all' => 'Voir tout',
        'show_more' => 'Afficher plus',
        'show_less' => 'Afficher moins',
        'apply_filters' => 'Appliquer les filtres',
        'reset_filters' => 'Réinitialiser les filtres',
        'create' => 'Créer',
        'edit' => 'Modifier',
        'delete' => 'Supprimer',
        'save' => 'Enregistrer',
        'cancel' => 'Annuler',
        'preview' => 'Aperçu',
        'publish' => 'Publier',
        'unpublish' => 'Dépublier',
        'approve' => 'Approuver',
        'reject' => 'Rejeter',
        'mark_spam' => 'Marquer comme spam',
        'export' => 'Exporter',
        'refresh' => 'Rafraîchir',
        'feature' => 'Mettre en avant',
        'unfeature' => 'Retirer de la mise en avant'
    ],
    
    // États et statuts
    'status' => [
        'published' => 'Publié',
        'draft' => 'Brouillon',
        'scheduled' => 'Planifié',
        'pending' => 'En attente',
        'approved' => 'Approuvé',
        'rejected' => 'Rejeté',
        'spam' => 'Spam',
        'all' => 'Tous'
    ],
    
    // Filtres et tris
    'filters' => [
        'search' => 'Rechercher...',
        'category' => 'Catégorie',
        'tag' => 'Tag',
        'author' => 'Auteur',
        'status' => 'Statut',
        'sort_by' => 'Trier par',
        'date_from' => 'Date de début',
        'date_to' => 'Date de fin',
        'all_categories' => 'Toutes les catégories',
        'all_authors' => 'Tous les auteurs'
    ],
    
    'sort_options' => [
        'recent' => 'Plus récent',
        'popular' => 'Plus populaire',
        'likes' => 'Plus aimés',
        'views' => 'Plus vus',
        'comments' => 'Plus commentés',
        'title' => 'Titre',
        'published_at' => 'Date de publication',
        'created_at' => 'Date de création'
    ],
    
    // Métriques et statistiques
    'metrics' => [
        'views' => 'Vues',
        'likes' => 'J\'aime',
        'comments' => 'Commentaires',
        'shares' => 'Partages',
        'reading_time' => 'Temps de lecture',
        'progress' => 'Progression',
        'engagement' => 'Engagement',
        'total_posts' => 'Total articles',
        'posts_this_month' => 'Articles ce mois',
        'total_views' => 'Total vues',
        'views_today' => 'Vues aujourd\'hui',
        'total_comments' => 'Total commentaires',
        'approved_comments' => 'Commentaires approuvés',
        'total_likes' => 'Total j\'aime',
        'total_shares' => 'Total partages',
        'tags_count' => 'Tags',
        'categories_count' => 'Catégories',
        'active_authors' => 'Auteurs actifs'
    ],
    
    // Interface utilisateur
    'ui' => [
        'no_posts' => 'Aucun article trouvé.',
        'no_comments' => 'Aucun commentaire.',
        'no_results' => 'Aucun résultat trouvé.',
        'loading' => 'Chargement...',
        'confirm_delete' => 'Êtes-vous sûr de vouloir supprimer cet élément ?',
        'confirm_bulk_delete' => 'Êtes-vous sûr de vouloir supprimer les éléments sélectionnés ?',
        'select_all' => 'Tout sélectionner',
        'selected_count' => ':count éléments sélectionnés',
        'reading_progress' => 'Progression de lecture',
        'time_spent' => 'Temps passé',
        'related_posts' => 'Articles similaires',
        'previous_post' => 'Article précédent',
        'next_post' => 'Article suivant',
        'featured_post' => 'Article vedette',
        'recent_posts' => 'Articles récents',
        'popular_tags' => 'Tags populaires',
        'communication_channels' => 'Canaux de communication'
    ],
    
    // Formulaires
    'forms' => [
        'title' => 'Titre',
        'slug' => 'Slug',
        'excerpt' => 'Extrait',
        'content' => 'Contenu',
        'category' => 'Catégorie',
        'tags' => 'Tags',
        'featured_image' => 'Image principale',
        'meta_title' => 'Titre SEO',
        'meta_description' => 'Description SEO',
        'published' => 'Publié',
        'published_at' => 'Date de publication',
        'choose_category' => 'Choisir une catégorie...',
        'choose_tags' => 'Choisir des tags...',
        'generate_slug' => 'Générer le slug',
        'upload_image' => 'Télécharger une image'
    ],
    
    // Partage
    'share' => [
        'title' => 'Partager cet article',
        'platforms' => [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'linkedin' => 'LinkedIn',
            'whatsapp' => 'WhatsApp',
            'email' => 'Email'
        ]
    ],
    
    // Analytics
    'analytics' => [
        'title' => 'Analytiques du Blog',
        'period' => 'Période',
        'posts' => 'Articles',
        'reactions' => 'Réactions',
        'platforms' => 'Plateformes',
        'top_posts' => 'Articles les plus populaires',
        'reaction_breakdown' => 'Répartition des réactions',
        'shares_by_platform' => 'Partages par plateforme',
        'export_csv' => 'Exporter en CSV'
    ],
    
    // Gestion des commentaires
    'comments' => [
        'management' => 'Gestion des commentaires',
        'content' => 'Contenu du commentaire',
        'author' => 'Auteur',
        'post' => 'Article',
        'date' => 'Date',
        'actions' => 'Actions',
        'bulk_actions' => 'Actions groupées',
        'details' => 'Détails du commentaire',
        'ip_address' => 'Adresse IP',
        'user_agent' => 'User Agent'
    ],
    
    // Gestion des articles
    'posts' => [
        'management' => 'Gestion des articles',
        'create' => 'Créer un article',
        'edit' => 'Modifier l\'article',
        'preview' => 'Aperçu de l\'article',
        'list' => 'Liste des articles',
        'bulk_actions' => 'Actions groupées',
        'author' => 'Auteur',
        'published_date' => 'Date de publication',
        'status' => 'Statut',
        'featured' => 'En vedette'
    ]
];