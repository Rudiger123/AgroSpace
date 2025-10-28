<?php

namespace App\Policies;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role->name === 'producer';
    }

    public function update(User $user, Offer $offer)
    {
        return $user->id === $offer->user_id;
    }

    public function delete(User $user, Offer $offer)
    {
        return $user->id === $offer->user_id;
    }
}
