<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'language',
        'timezone',
        'currency',
        'notify_new_offers',
        'notify_new_demands',
        'notify_articles',
        'notify_chat_messages',
        'notify_admin_alerts',
        'email_notifications',
        'push_notifications',
        'sms_notifications',
        'theme',
        'compact_view',
        'show_tutorials',
    ];

    protected $casts = [
        'notify_new_offers' => 'boolean',
        'notify_new_demands' => 'boolean',
        'notify_articles' => 'boolean',
        'notify_chat_messages' => 'boolean',
        'notify_admin_alerts' => 'boolean',
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'compact_view' => 'boolean',
        'show_tutorials' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get default preferences
     */
    public static function getDefaults(): array
    {
        return [
            'language' => 'fr',
            'timezone' => 'Africa/Douala',
            'currency' => 'XAF',
            'notify_new_offers' => true,
            'notify_new_demands' => true,
            'notify_articles' => true,
            'notify_chat_messages' => true,
            'notify_admin_alerts' => true,
            'email_notifications' => true,
            'push_notifications' => true,
            'sms_notifications' => false,
            'theme' => 'light',
            'compact_view' => false,
            'show_tutorials' => true,
        ];
    }
}
