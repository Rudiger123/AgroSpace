<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Private notification channel for each user
Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Channel for admin notifications
Broadcast::channel('admin.notifications', function ($user) {
    return $user->isAdmin();
});

// Channel for producer notifications
Broadcast::channel('producer.notifications.{producerId}', function ($user, $producerId) {
    return $user->isProducer() && (int) $user->id === (int) $producerId;
});

// Channel for consumer notifications
Broadcast::channel('consumer.notifications.{consumerId}', function ($user, $consumerId) {
    return $user->isConsumer() && (int) $user->id === (int) $consumerId;
});