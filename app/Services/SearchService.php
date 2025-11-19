<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Offer;
use App\Models\Demand;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Search across all models based on user role and permissions
     */
    public function searchAll(string $query, ?User $user = null, int $limit = 20): array
    {
        if (strlen($query) < 2) {
            return [];
        }

        $results = [];
        $isAdmin = $user && $user->isAdmin();
        $isProducer = $user && $user->isProducer();
        $isConsumer = $user && $user->isConsumer();

        // Search Posts
        if ($user) {
            $results = array_merge($results, $this->searchPosts($query, 5));
        }

        // Search Offers
        if ($isAdmin || $isProducer || $isConsumer) {
            $results = array_merge($results, $this->searchOffers($query, $user, 5));
        }

        // Search Demands
        if ($isAdmin || $isProducer || $isConsumer) {
            $results = array_merge($results, $this->searchDemands($query, $user, 5));
        }

        // Search Categories (Admin only)
        if ($isAdmin) {
            $results = array_merge($results, $this->searchCategories($query, 5));
        }

        // Search Users (Admin only)
        if ($isAdmin) {
            $results = array_merge($results, $this->searchUsers($query, 5));
        }

        // Search Comments (Admin only)
        if ($isAdmin) {
            $results = array_merge($results, $this->searchComments($query, 3));
        }

        // Search Newsletter Subscribers (Admin only)
        if ($isAdmin) {
            $results = array_merge($results, $this->searchNewsletterSubscribers($query, 3));
        }

        // Sort by date and limit
        usort($results, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return array_slice($results, 0, $limit);
    }

    /**
     * Search Posts (Articles)
     */
    private function searchPosts(string $query, int $limit): array
    {
        return Post::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'ILIKE', "%{$query}%")
                  ->orWhere('content', 'ILIKE', "%{$query}%")
                  ->orWhere('excerpt', 'ILIKE', "%{$query}%");
            })
            ->with('author', 'category')
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($post) {
                return [
                    'type' => 'post',
                    'id' => $post->id,
                    'title' => $post->title,
                    'excerpt' => $this->getExcerpt($post->excerpt ?? strip_tags($post->content), 80),
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>',
                    'color' => 'text-purple-600 bg-purple-100',
                    'label' => 'Article',
                    'url' => route('blog.show', $post->slug),
                    'author' => $post->author->name ?? 'N/A',
                    'date' => $post->created_at->format('d/m/Y'),
                    'status' => null,
                ];
            })
            ->toArray();
    }

    /**
     * Search Offers
     */
    private function searchOffers(string $query, ?User $user, int $limit): array
    {
        $offersQuery = Offer::query()
            ->where(function ($q) use ($query) {
                $q->where('titre', 'ILIKE', "%{$query}%")
                  ->orWhere('description', 'ILIKE', "%{$query}%");
            })
            ->with('producer', 'category');

        if ($user->isProducer() && !$user->isAdmin()) {
            $offersQuery->where('producer_id', $user->id);
        } elseif ($user->isConsumer() && !$user->isAdmin()) {
            $offersQuery->whereIn('statut', ['active', 'validé']);
        }

        return $offersQuery->latest()
            ->take($limit)
            ->get()
            ->map(function ($offer) {
                return [
                    'type' => 'offer',
                    'id' => $offer->id,
                    'title' => $offer->titre,
                    'excerpt' => $this->getExcerpt($offer->description, 80),
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                    'color' => 'text-green-600 bg-green-100',
                    'label' => 'Offre',
                    'url' => route('offers.show', $offer->id),
                    'author' => $offer->producer->name ?? 'N/A',
                    'date' => $offer->created_at->format('d/m/Y'),
                    'status' => $offer->statut,
                ];
            })
            ->toArray();
    }

    /**
     * Search Demands
     */
    private function searchDemands(string $query, ?User $user, int $limit): array
    {
        $demandsQuery = Demand::query()
            ->where(function ($q) use ($query) {
                $q->where('title', 'ILIKE', "%{$query}%")
                  ->orWhere('description', 'ILIKE', "%{$query}%");
            })
            ->with('user', 'category');

        if ($user->isConsumer() && !$user->isAdmin()) {
            $demandsQuery->where('user_id', $user->id);
        } elseif ($user->isProducer() && !$user->isAdmin()) {
            $demandsQuery->where('status', 'active');
        }

        return $demandsQuery->latest()
            ->take($limit)
            ->get()
            ->map(function ($demand) {
                return [
                    'type' => 'demand',
                    'id' => $demand->id,
                    'title' => $demand->title,
                    'excerpt' => $this->getExcerpt($demand->description, 80),
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>',
                    'color' => 'text-orange-600 bg-orange-100',
                    'label' => 'Demande',
                    'url' => route('demands.show', $demand->id),
                    'author' => $demand->user->name ?? 'N/A',
                    'date' => $demand->created_at->format('d/m/Y'),
                    'status' => $demand->status,
                ];
            })
            ->toArray();
    }

    /**
     * Search Categories
     */
    private function searchCategories(string $query, int $limit): array
    {
        return Category::where('name', 'ILIKE', "%{$query}%")
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($category) {
                return [
                    'type' => 'category',
                    'id' => $category->id,
                    'title' => $category->name,
                    'excerpt' => $category->description ?? 'Catégorie',
                    'icon' => $category->icon ?? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>',
                    'color' => 'text-blue-600 bg-blue-100',
                    'label' => 'Catégorie',
                    'url' => route('admin.categories.edit', $category->id),
                    'author' => 'Système',
                    'date' => $category->created_at->format('d/m/Y'),
                    'status' => $category->is_active ? 'active' : 'inactive',
                ];
            })
            ->toArray();
    }

    /**
     * Search Users
     */
    private function searchUsers(string $query, int $limit): array
    {
        return User::where(function ($q) use ($query) {
                $q->where('name', 'ILIKE', "%{$query}%")
                  ->orWhere('email', 'ILIKE', "%{$query}%");
            })
            ->with('role')
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($user) {
                $roleLabels = [
                    1 => 'Administrateur',
                    2 => 'Producteur',
                    3 => 'Consommateur',
                ];
                
                return [
                    'type' => 'user',
                    'id' => $user->id,
                    'title' => $user->name,
                    'excerpt' => $user->email,
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                    'color' => 'text-indigo-600 bg-indigo-100',
                    'label' => $roleLabels[$user->role_id] ?? 'Utilisateur',
                    'url' => route('admin.users.show', $user->id),
                    'author' => $roleLabels[$user->role_id] ?? 'Utilisateur',
                    'date' => $user->created_at->format('d/m/Y'),
                    'status' => $user->status,
                ];
            })
            ->toArray();
    }

    /**
     * Search Comments
     */
    private function searchComments(string $query, int $limit): array
    {
        return Comment::where('content', 'ILIKE', "%{$query}%")
            ->with('user', 'post')
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($comment) {
                return [
                    'type' => 'comment',
                    'id' => $comment->id,
                    'title' => 'Commentaire sur: ' . ($comment->post->title ?? 'Article supprimé'),
                    'excerpt' => $this->getExcerpt($comment->content, 80),
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>',
                    'color' => 'text-pink-600 bg-pink-100',
                    'label' => 'Commentaire',
                    'url' => route('admin.comments.index') . '?search=' . $comment->id,
                    'author' => $comment->user->name ?? 'Anonyme',
                    'date' => $comment->created_at->format('d/m/Y'),
                    'status' => $comment->status,
                ];
            })
            ->toArray();
    }

    /**
     * Search Newsletter Subscribers
     */
    private function searchNewsletterSubscribers(string $query, int $limit): array
    {
        return NewsletterSubscriber::where(function ($q) use ($query) {
                $q->where('email', 'ILIKE', "%{$query}%")
                  ->orWhere('name', 'ILIKE', "%{$query}%");
            })
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($subscriber) {
                return [
                    'type' => 'newsletter',
                    'id' => $subscriber->id,
                    'title' => $subscriber->name ?? $subscriber->email,
                    'excerpt' => $subscriber->email,
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                    'color' => 'text-teal-600 bg-teal-100',
                    'label' => 'Newsletter',
                    'url' => route('admin.newsletter.index') . '?search=' . $subscriber->email,
                    'author' => 'Abonné',
                    'date' => $subscriber->created_at->format('d/m/Y'),
                    'status' => $subscriber->isActive() ? 'active' : 'unsubscribed',
                ];
            })
            ->toArray();
    }

    /**
     * Get excerpt from text
     */
    private function getExcerpt(string $text, int $length = 100): string
    {
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . '...';
    }

    /**
     * Highlight search terms in text
     */
    public function highlight(string $text, string $query): string
    {
        if (empty($query)) {
            return $text;
        }

        $pattern = '/(' . preg_quote($query, '/') . ')/i';
        return preg_replace($pattern, '<mark class="bg-yellow-200 text-gray-900 rounded px-1">$1</mark>', $text);
    }
}