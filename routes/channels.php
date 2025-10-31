<?php

// routes/channels.php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Ici nous déclarons les canaux de broadcast et leurs autorisations.
| Chaque canal privé nécessite une autorisation pour que l'utilisateur
| puisse s'y abonner via Echo.
|
*/

/**
 * Canal privé : Chat d'une conversation
 * L'utilisateur doit être participant de la conversation
 */
Broadcast::channel('chat.{conversationId}', function (User $user, int $conversationId) {
    $conversation = Conversation::find($conversationId);

    if (!$conversation) {
        return false;
    }

    // Vérifier que l'utilisateur participe à cette conversation
    return $conversation->hasParticipant($user);
});

/**
 * Canal privé : Notifications d'un utilisateur
 * L'utilisateur ne peut recevoir que SES notifications
 */
Broadcast::channel('notifications.{userId}', function (User $user, int $userId) {
    return (int) $user->id === (int) $userId;
});

/**
 * Canal de présence : Utilisateurs en ligne dans une conversation
 * Permet de voir qui est connecté en temps réel
 */
Broadcast::channel('conversation.{conversationId}', function (User $user, int $conversationId) {
    $conversation = Conversation::find($conversationId);

    if (!$conversation || !$conversation->hasParticipant($user)) {
        return false;
    }

    // Retourner les infos publiques de l'utilisateur
    return [
        'id' => $user->id,
        'name' => $user->name,
        'avatar' => $user->avatar ?? null,
    ];
});

/**
 * Canal de présence : Dashboard (admin/modérateurs)
 * Pour voir qui est actif sur la plateforme
 */
Broadcast::channel('online-users', function (User $user) {
    // Accessible à tous les utilisateurs authentifiés
    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});

/**
 * Canal privé : Offres d'un utilisateur (pour notifications d'offres)
 */
Broadcast::channel('user.{userId}.offers', function (User $user, int $userId) {
    return (int) $user->id === (int) $userId;
});
