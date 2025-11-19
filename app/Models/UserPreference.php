<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'notify_new_offers',
        'notify_new_demands',
        'notify_articles',
        'notify_chat_messages'
    ];
}
