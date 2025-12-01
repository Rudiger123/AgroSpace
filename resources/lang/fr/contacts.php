<?php

return [
    'title' => 'Gestion des Contacts',
    'subtitle' => 'Gérez vos messages et feedbacks de manière professionnelle',
    
    'delete_selected' => 'Supprimer (:count)',
    'delete_selected_confirm' => 'Êtes-vous sûr de vouloir supprimer :count message(s) ?',
    'export' => 'Exporter',
    
    'stats' => [
        'total' => 'Total Messages',
        'new' => 'Nouveaux',
        'opened' => 'Ouverts',
        'replied' => 'Répondus',
        'closed' => 'Fermés',
        'all_statuses' => 'Tous les statuts',
        'unread' => 'Non lus',
        'pending' => 'En attente',
        'processed' => 'Traités',
        'archived' => 'Archivés',
    ],
    
    'advanced_stats' => [
        'today' => 'Aujourd\'hui',
        'this_week' => 'Cette semaine',
        'avg_response_time' => 'Temps moyen',
        'response_rate' => 'Taux réponse',
    ],
    
    'search' => [
        'label' => '🔍 Rechercher',
        'placeholder' => 'Nom, email, sujet, message...',
    ],
    
    'status' => [
        'label' => '📊 Statut',
        'all' => '🎯 Tous les statuts',
        'new' => '🆕 Nouveaux',
        'opened' => '👁️ Ouverts',
        'replied' => '✅ Répondus',
        'closed' => '❌ Fermés',
        'new_badge' => 'NEW',
    ],
    
    'status_labels' => [
        'new' => 'Nouveau',
        'opened' => 'Ouvert',
        'replied' => 'Répondu',
        'closed' => 'Fermé',
    ],
    
    'results_found' => 'résultat(s) trouvé(s)',
    'reset' => 'Réinitialiser',
    
    'table' => [
        'contact' => 'Contact',
        'subject_message' => 'Sujet & Message',
        'status' => 'Statut',
        'date' => 'Date',
        'actions' => 'Actions',
    ],
    
    'actions' => [
        'view' => 'Voir les détails',
        'reply' => 'Répondre',
        'delete' => 'Supprimer',
    ],
    
    'no_messages' => 'Aucun message trouvé',
    'no_messages_description' => 'Les messages de contact apparaîtront ici',
    
    'modal_view' => [
        'subject' => '📝 Sujet',
        'message' => '💬 Message',
        'received_date' => 'Date de réception',
        'current_status' => 'Statut actuel',
        'reply_sent' => 'Réponse envoyée',
        'by' => 'Par',
        'unknown' => 'Inconnu',
        'on' => 'le',
    ],
    
    'modal_reply' => [
        'title' => 'Répondre au message',
        'to' => 'À',
        'original_message' => 'MESSAGE ORIGINAL',
        'select_recipients' => '👥 Sélectionner les destinataires *',
        'recipients_selected' => ':count destinataire(s) sélectionné(s)',
        'your_reply' => '✍️ Votre réponse *',
        'reply_placeholder' => 'Rédigez votre réponse ici...',
        'characters' => 'caractères',
        'cc_sender' => 'Mettre l\'expéditeur en copie (CC)',
        'cc_sender_description' => 'recevra également une copie',
        'send_copy_to_me' => 'M\'envoyer une copie',
        'send_copy_to_me_description' => 'Recevoir une copie de cette réponse',
    ],
    
    'modal_delete' => [
        'title' => 'Confirmer la suppression',
        'confirm_message' => 'Êtes-vous sûr de vouloir supprimer ce message de :name ?',
        'warning' => 'Cette action est irréversible !',
    ],
    
    'buttons' => [
        'close' => 'Fermer',
        'close_status' => 'Fermer',
        'reply' => 'Répondre',
        'cancel' => 'Annuler',
        'send_reply' => 'Envoyer la réponse',
        'sending' => 'Envoi en cours...',
        'delete' => 'Supprimer',
    ],
    
    'notifications' => [
        'reply_sent' => 'Réponse envoyée !',
        'great' => 'Super !',
        'deleted' => 'Supprimé !',
        'multiple_deleted' => 'Suppression multiple !',
        'updated' => 'Mis à jour !',
        'error' => 'Erreur',
        'export_started' => 'Export en cours...',
        'export_description' => 'Votre fichier sera téléchargé dans quelques instants.',
    ],


        'reply_message_required' => 'Please enter a reply message.',
        'reply_message_min' => 'The message must contain at least 10 characters.',
        'reply_subject' => 'Reply: ',
        'reply_sent_success' => 'Reply sent successfully to ',
        'reply_send_error' => 'Error while sending: ',
        'contact_deleted_success' => 'Message deleted successfully!',
        'contact_delete_error' => 'Error while deleting.',
        'contacts_deleted_success' => 'message(s) deleted successfully!',
        'contacts_delete_error' => 'Error during multiple deletion.',
        'status_updated' => 'Status updated!',
    ];