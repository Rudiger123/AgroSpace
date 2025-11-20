<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * NotificationService - Helper pour gérer les notifications
 */
class NotificationService
{
    /**
     * Get users who should receive notifications for new offers.
     *
     * @param \App\Models\Offer $offer
     * @return \Illuminate\Support\Collection
     */
    public function getNewOfferRecipients($offer): Collection
    {
        // Admins
        $admins = User::where('role_id', 1)->get();

        // Consumers interested in this category
        $interestedConsumers = User::where('role_id', 3)
            ->where('email_notifications_enabled', true)
            ->whereHas('preferences', function ($query) use ($offer) {
                $query->where('category_id', $offer->category_id);
            })
            ->get();

        return $admins->merge($interestedConsumers);
    }

    /**
     * Get users who should receive notifications for new articles.
     *
     * @param \App\Models\Post $article
     * @return \Illuminate\Support\Collection
     */
    public function getArticleRecipients($article): Collection
    {
        // All users with blog notifications enabled
        $users = User::where('blog_notifications_enabled', true)->get();

        // Newsletter subscribers
        $subscribers = \App\Models\NewsletterSubscriber::where('status', 'active')->get();

        return $users->merge($subscribers);
    }

    /**
     * Get admins who should receive system notifications.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAdminRecipients(): Collection
    {
        return User::where('role_id', 1)
            ->where('email_notifications_enabled', true)
            ->get();
    }

    /**
     * Get producers in a specific region.
     *
     * @param string $region
     * @return \Illuminate\Support\Collection
     */
    public function getProducersByRegion(string $region): Collection
    {
        return User::where('role_id', 2)
            ->where('region', $region)
            ->where('email_notifications_enabled', true)
            ->get();
    }

    /**
     * Get consumers interested in a specific category.
     *
     * @param int $categoryId
     * @return \Illuminate\Support\Collection
     */
    public function getConsumersByCategory(int $categoryId): Collection
    {
        return User::where('role_id', 3)
            ->where('email_notifications_enabled', true)
            ->whereHas('preferences', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->get();
    }

    /**
     * Mark all notifications as read for a user.
     *
     * @param \App\Models\User $user
     * @return int
     */
    public function markAllAsRead(User $user): int
    {
        return $user->unreadNotifications->markAsRead();
    }

    /**
     * Delete old read notifications (older than X days).
     *
     * @param int $days
     * @return int
     */
    public function deleteOldNotifications(int $days = 30): int
    {
        return DB::table('notifications')
            ->whereNotNull('read_at')
            ->where('read_at', '<', now()->subDays($days))
            ->delete();
    }

    /**
     * Get notification statistics for a user.
     *
     * @param \App\Models\User $user
     * @return array
     */
    public function getStatistics(User $user): array
    {
        return [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'today' => $user->notifications()
                ->whereDate('created_at', today())
                ->count(),
            'this_week' => $user->notifications()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ];
    }

    /**
     * Send a custom notification to specific users.
     *
     * @param \Illuminate\Support\Collection|array $users
     * @param string $notificationClass
     * @param mixed ...$args
     * @return void
     */
    public function sendToUsers($users, string $notificationClass, ...$args): void
    {
        if (is_array($users)) {
            $users = collect($users);
        }

        foreach ($users as $user) {
            $user->notify(new $notificationClass(...$args));
        }
    }

    /**
     * Send notification to all admins.
     *
     * @param string $notificationClass
     * @param mixed ...$args
     * @return void
     */
    public function notifyAdmins(string $notificationClass, ...$args): void
    {
        $admins = $this->getAdminRecipients();
        $this->sendToUsers($admins, $notificationClass, ...$args);
    }

    /**
     * Get unread notification count for a user.
     *
     * @param \App\Models\User $user
     * @return int
     */
    public function getUnreadCount(User $user): int
    {
        return $user->unreadNotifications()->count();
    }

    /**
     * Check if user has unread notifications.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function hasUnread(User $user): bool
    {
        return $this->getUnreadCount($user) > 0;
    }
}
