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
    ],

    'analytics' => [
        'title' => 'Tableau de Bord Agrospace Analytics',
        'description' => 'Analyse approfondie des performances du blog',
        'refresh' => 'Actualiser',
        'export_csv' => 'Exporter CSV',
        'filters' => [
            'title' => 'Filtres de Période & Contenu',
            'date_from' => 'Du',
            'date_to' => 'Au',
            'selected_period' => 'Période sélectionnée : du :from au :to',
            'filter_by_post' => 'Filtrer par Article',
            'filter_by_author' => 'Filtrer par Auteur',
            'comment_status' => 'Statut Commentaire',
            'all_posts' => 'Tous les articles',
            'all_authors' => 'Tous les auteurs',
            'all_comments' => 'Tous les commentaires',
            'approved' => 'Approuvés',
            'pending' => 'En attente',
            'rejected' => 'Rejetés',
            'spam' => 'Spam',
        ],
        'stats' => [
            'published_posts' => 'Articles publiés',
            'filtered_coverage' => 'Couverts par les filtres',
            'total_views' => 'Vues totales',
            'period' => 'Sur la période',
            'comments' => 'Commentaires',
            'pending' => 'en attente',
            'total_likes' => 'Total J\'aime',
            'total_engagement' => 'Engagement total',
            'total_shares' => 'Total Partages',
            'external_visibility' => 'Visibilité externe',
        ],
        'charts' => [
            'traffic_trend' => 'Tendance du Trafic (Vues et Commentaires)',
            'reaction_breakdown' => 'Répartition des Réactions',
            'shares_by_platform' => 'Partages par Plateforme',
            'top_posts' => 'Top 5 Articles par Commentaires',
            'no_articles' => 'Aucun article trouvé selon les filtres.',
        ],
    ],
    
    'list' => [
        'hero' => [
            'title' => 'Actualités & :highlight du monde agropastoral',
            'highlight' => 'Innovations',
            'description' => 'Découvrez les tendances, les conseils et les histoires inspirantes de la communauté Agrospace.',
            'explore_articles' => 'Explorer les articles',
            'stats' => [
                'published_articles' => 'Articles publiés',
                'expert_contributors' => 'Experts contributeurs',
                'engaged_readers' => 'Lecteurs engagés',
            ],
        ],
        'featured' => [
            'title' => 'À la une',
            'featured_badge' => '⭐ Article vedette',
            'read_full' => 'Lire l\'article complet',
        ],
        'filters' => [
            'search_placeholder' => 'Rechercher un article ou un thème...',
            'all_categories' => '📚 Tous',
            'popular_tags' => 'Tags populaires:',
            'sort_by' => 'Trier par:',
            'most_recent' => 'Plus récents',
            'most_popular' => 'Plus populaires',
            'most_liked' => 'Plus aimés',
            'clear_filters' => 'Effacer les filtres',
            'loading' => 'Chargement des articles...',
        ],
        'articles' => [
            'no_results' => [
                'title' => 'Aucun article trouvé',
                'description' => 'Aucun article ne correspond à vos critères de recherche.',
                'reset_filters' => 'Réinitialiser les filtres',
            ],
            'read' => 'Lire',
            'stats' => [
                'views' => 'vues',
                'likes' => 'j\'aime',
                'comments' => 'commentaires',
            ],
        ],
        'impact' => [
            'title' => 'L\'Impact d\'<span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-700">AgroSpace</span>',
            'description' => 'Une communauté dynamique qui partage, apprend et grandit ensemble',
            'stats' => [
                'published_articles' => 'Articles Publiés',
                'this_month' => 'ce mois',
                'total_views' => 'Vues Totales',
                'today' => 'Aujourd\'hui',
                'comments' => 'Commentaires',
                'approved' => 'approuvés',
                'reactions' => 'Réactions',
                'liked_articles' => 'Articles appréciés',
                'shares' => 'Partages',
                'tags' => 'Tags',
                'categories' => 'Catégories',
                'authors' => 'Auteurs',
            ],
        ],
        'cta' => [
            'title' => 'Agrospace, c\'est plus qu\'une plateforme',
            'description' => 'C\'est une communauté agricole qui avance ensemble vers un avenir durable et prospère.',
            'join_community' => 'Rejoindre la communauté',
            'signup_info' => 'Inscrivez-vous gratuitement et connectez-vous aux producteurs et consommateurs près de chez vous.',
        ],
    ],
    
    'manager' => [
        'title' => 'Gestion du Blog',
        'description' => 'Créez, éditez et gérez vos articles avec style',
        'actions' => [
            'new_article' => 'Nouvel Article',
            'comments_manager' => 'Gestion des commentaires',
            'analytics' => 'Analytics',
        ],
        'stats' => [
            'total_posts' => 'Total Articles',
            'published' => 'Publiés',
            'drafts' => 'Brouillons',
            'total_views' => 'Vues totales',
        ],
        'filters' => [
            'search' => [
                'label' => 'Rechercher',
                'placeholder' => 'Titre, contenu, auteur...',
            ],
            'category' => [
                'label' => 'Catégorie',
                'all' => 'Toutes les catégories',
            ],
            'status' => [
                'label' => 'Statut',
                'all' => 'Tous les statuts',
                'published' => 'Publiés',
                'draft' => 'Brouillons',
                'scheduled' => 'Programmés',
            ],
            'author' => [
                'label' => 'Auteur',
                'all' => 'Tous les auteurs',
            ],
            'quick_filters' => [
                'all_posts' => 'Tous les articles',
                'published' => 'Publiés',
                'drafts' => 'Brouillons',
                'oldest' => 'Plus ancien',
                'newest' => 'Plus récent',
            ],
        ],
        'articles' => [
            'status' => [
                'published' => 'Publié',
                'draft' => 'Brouillon',
            ],
            'actions' => [
                'preview' => 'Prévisualiser',
                'edit' => 'Modifier',
                'publish' => 'Publier',
                'unpublish' => 'Dépublier',
                'feature' => 'Mettre en vedette',
                'unfeature' => 'Retirer de la vedette',
                'delete' => 'Supprimer',
            ],
            'meta' => [
                'author' => 'Auteur',
                'publish_date' => 'Date de publication',
                'not_published' => 'Non publié',
            ],
            'no_results' => [
                'title' => 'Aucun article trouvé',
                'description' => 'Commencez votre aventure blogging en créant votre premier article magnifique.',
                'create_first' => 'Créer mon premier article',
            ],
        ],
        'modals' => [
            'create' => [
                'title' => '✨ Créer un Nouvel Article',
                'description' => 'Partagez vos connaissances et inspirez la communauté AgroSpace',
            ],
            'edit' => [
                'title' => '✏️ Modifier l\'Article',
                'description' => 'Mettez à jour les informations de votre article pour tenir votre communauté informée',
            ],
            'sections' => [
                'main_info' => [
                    'title' => 'Informations Principales',
                    'description' => 'Les détails essentiels de votre article',
                    'fields' => [
                        'title' => 'Titre de l\'Article',
                        'slug' => 'URL (Slug)',
                        'slug_info' => 'Généré automatiquement à partir du titre',
                    ],
                ],
                'classification' => [
                    'title' => 'Classification',
                    'description' => 'Catégorie et tags pour organiser votre contenu',
                    'fields' => [
                        'category' => 'Catégorie',
                        'tags' => 'Tags',
                        'tags_info' => 'Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs tags',
                    ],
                ],
                'featured_image' => [
                    'title' => 'Image de Couverture',
                    'description' => 'Choisissez une image attractive pour votre article',
                    'upload' => [
                        'click_to_upload' => 'Cliquez pour télécharger ou glissez-déposez',
                        'formats' => 'PNG, JPG, GIF jusqu\'à 2MB',
                    ],
                ],
                'excerpt' => [
                    'title' => 'Résumé',
                    'description' => 'Un aperçu concis de votre article',
                    'fields' => [
                        'excerpt' => 'Description Courte',
                        'excerpt_info' => 'Sera généré automatiquement depuis le contenu si laissé vide',
                    ],
                ],
                'content' => [
                    'title' => 'Contenu de l\'Article',
                    'description' => 'Rédigez le corps de votre article',
                    'fields' => [
                        'content' => 'Texte Principal',
                        'markdown_support' => 'Markdown supporté',
                    ],
                ],
                'publishing' => [
                    'title' => 'Options de Publication',
                    'description' => 'Planifiez la publication de votre article',
                    'fields' => [
                        'publish_now' => 'Publier maintenant',
                        'publish_now_info' => 'L\'article sera visible immédiatement',
                        'publish_date' => 'Date et Heure de Publication',
                        'publish_date_info' => 'Laissez vide pour publication immédiate',
                    ],
                ],
                'seo' => [
                    'title' => 'Optimisation SEO',
                    'description' => 'Améliorez votre visibilité sur les moteurs de recherche',
                    'fields' => [
                        'meta_title' => 'Meta Title',
                        'meta_title_info' => 'Idéalement entre 50-60 caractères',
                        'meta_description' => 'Meta Description',
                        'meta_description_info' => 'Optimal entre 150-160 caractères pour un affichage complet',
                    ],
                ],
            ],
            'actions' => [
                'cancel' => 'Annuler',
                'save' => 'Enregistrer',
                'create' => '✨ Créer l\'Article',
                'update' => '💾 Mettre à Jour',
                'saving' => 'Enregistrement en cours...',
                'auto_save' => 'Sauvegarde automatique',
                'auto_save_info' => 'Vos modifications sont enregistrées',
            ],
        ],
        'delete_modal' => [
            'title' => 'Confirmer la suppression',
            'description' => 'Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.',
            'cancel' => 'Annuler',
            'confirm' => 'Supprimer',
        ],
        'preview_modal' => [
            'title' => '✨ Prévisualisation',
            'description' => 'Aperçu de votre article avant publication',
            'desktop_view' => 'Vue Bureau',
            'mobile_view' => 'Vue Mobile',
            'fullscreen' => 'Plein écran',
            'share' => [
                'title' => 'Partagez cet article',
                'description' => 'Faites découvrir ce contenu à votre communauté',
            ],
            'cta' => [
                'title' => 'Prêt à publier votre article ?',
                'description' => 'Partagez vos connaissances avec la communauté AgroSpace',
                'back_to_edit' => 'Retour à l\'édition',
            ],
        ],
    ],
];