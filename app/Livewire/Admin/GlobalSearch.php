<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Offer;
use App\Models\Demand;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];
    public $isOpen = false;
    public $selectedIndex = -1;
    public $totalResults = 0;

    protected $listeners = ['openSearch' => 'open', 'closeSearch' => 'close'];

    public function mount()
    {
        $this->results = [];
        $this->query = '';
    }

    public function render()
    {
        return view('livewire.admin.global-search');
    }

    public function updatedQuery()
    {
        $this->selectedIndex = -1;

        if (strlen($this->query) < 2) {
            $this->results = [];
            $this->totalResults = 0;
            return;
        }

        $this->search();
    }

    public function search()
    {
        $cacheKey = 'global_search_' . md5($this->query . Auth::id() . (Auth::user()->role_id ?? 'guest'));

        $this->results = Cache::remember($cacheKey, 60, function () {
            $searchResults = [];
            $user = Auth::user();

            if (!$user) {
                return [];
            }

            $user = User::findOrFail($user->id);
            $isAdmin = $user->isAdmin();
            $isProducer = $user->isProducer();
            $isConsumer = $user->isConsumer();

            // 1. Search Posts (Articles) - Visible to all authenticated users
            $posts = Post::published()
                ->where(function ($q) {
                    $q->where('title', 'ILIKE', "%{$this->query}%")
                      ->orWhere('content', 'ILIKE', "%{$this->query}%")
                      ->orWhere('excerpt', 'ILIKE', "%{$this->query}%");
                })
                ->with('author', 'category')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($post) {
                    return [
                        'type' => 'post',
                        'id' => $post->id,
                        'title' => $post->title,
                        'excerpt' => $this->getExcerpt($post->excerpt ?? strip_tags($post->content), 80),
                        'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>',
                        'color' => 'text-purple-600 bg-purple-100',
                        'label' => __('search.article'),
                        'url' => route('blog.show', $post->slug),
                        'author' => $post->author->name ?? 'N/A',
                        'date' => $post->created_at->format('d/m/Y'),
                        'status' => null,
                    ];
                })
                ->toArray();

            $searchResults = array_merge($searchResults, $posts);

            // 2. Search Offers - Admin sees all, Producer sees own, Consumer sees public
            if ($isAdmin || $isProducer || $isConsumer) {
                $offersQuery = Offer::query()
                    ->where(function ($q) {
                        $q->where('titre', 'ILIKE', "%{$this->query}%")
                          ->orWhere('description', 'ILIKE', "%{$this->query}%");
                    })
                    ->with('producer', 'category');

                if ($isProducer && !$isAdmin) {
                    $offersQuery->where('producer_id', $user->id);
                } elseif ($isConsumer && !$isAdmin) {
                    $offersQuery->whereIn('statut', ['active', 'validé']);
                }

                $offers = $offersQuery->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($offer) {
                        return [
                            'type' => 'offer',
                            'id' => $offer->id,
                            'title' => $offer->titre,
                            'excerpt' => $this->getExcerpt($offer->description, 80),
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>',
                            'color' => 'text-green-600 bg-green-100',
                            'label' => __('search.offer'),
                            'url' => route('offers-list', ['search' => $offer->titre]),
                            'author' => $offer->producer->name ?? 'N/A',
                            'date' => $offer->created_at->format('d/m/Y'),
                            'status' => $offer->statut,
                        ];
                    })
                    ->toArray();

                $searchResults = array_merge($searchResults, $offers);
            }

            // 3. Search Demands - Admin sees all, Producer sees public, Consumer sees own
            if ($isAdmin || $isProducer || $isConsumer) {
                $demandsQuery = Demand::query()
                    ->where(function ($q) {
                        $q->where('title', 'ILIKE', "%{$this->query}%")
                          ->orWhere('description', 'ILIKE', "%{$this->query}%");
                    })
                    ->with('user', 'category');

                if ($isConsumer && !$isAdmin) {
                    $demandsQuery->where('user_id', $user->id);
                } elseif ($isProducer && !$isAdmin) {
                    $demandsQuery->where('status', 'active');
                }

                $demands = $demandsQuery->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($demand) {
                        return [
                            'type' => 'demand',
                            'id' => $demand->id,
                            'title' => $demand->title,
                            'excerpt' => $this->getExcerpt($demand->description, 80),
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>',
                            'color' => 'text-orange-600 bg-orange-100',
                            'label' => __('search.demand'),
                            'url' => route('demands-list', ['search' => $demand->title]),
                            'author' => $demand->user->name ?? 'N/A',
                            'date' => $demand->created_at->format('d/m/Y'),
                            'status' => $demand->status,
                        ];
                    })
                    ->toArray();

                $searchResults = array_merge($searchResults, $demands);
            }

            // 4. Search Categories - Admin only
            if ($isAdmin) {
                $categories = Category::where('name', 'ILIKE', "%{$this->query}%")
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($category) {
                        return [
                            'type' => 'category',
                            'id' => $category->id,
                            'title' => $category->name,
                            'excerpt' => $category->description ?? __('search.category_default_desc'),
                            'icon' => $category->icon ?? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>',
                            'color' => 'text-blue-600 bg-blue-100',
                            'label' => __('search.category'),
                            'url' => route('categories.index', ['search' => $category->name]),
                            'author' => __('search.system'),
                            'date' => $category->created_at->format('d/m/Y'),
                            'status' => $category->is_active ? 'active' : 'inactive',
                        ];
                    })
                    ->toArray();

                $searchResults = array_merge($searchResults, $categories);
            }

            // 5. Search Users - Admin only
            if ($isAdmin) {
                $users = User::where(function ($q) {
                    $q->where('name', 'ILIKE', "%{$this->query}%")
                      ->orWhere('email', 'ILIKE', "%{$this->query}%");
                })
                    ->with('role')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($user) {
                        $roleLabels = [
                            1 => __('search.admin'),
                            2 => __('search.producer'),
                            3 => __('search.consumer'),
                        ];

                        return [
                            'type' => 'user',
                            'id' => $user->id,
                            'title' => $user->name,
                            'excerpt' => $user->email,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                            'color' => 'text-indigo-600 bg-indigo-100',
                            'label' => $roleLabels[$user->role_id] ?? __('search.user'),
                            'url' => route('users-management', ['search' => $user->name]),
                            'author' => $roleLabels[$user->role_id] ?? __('search.user'),
                            'date' => $user->created_at->format('d/m/Y'),
                            'status' => $user->status,
                        ];
                    })
                    ->toArray();

                $searchResults = array_merge($searchResults, $users);
            }

            // 6. Search Comments - Admin only
            if ($isAdmin) {
                $comments = Comment::where('content', 'ILIKE', "%{$this->query}%")
                    ->with('user', 'post')
                    ->latest()
                    ->take(3)
                    ->get()
                    ->map(function ($comment) {
                        return [
                            'type' => 'comment',
                            'id' => $comment->id,
                            'title' => __('search.comment_on') . ($comment->post->title ?? __('search.deleted_article')),
                            'excerpt' => $this->getExcerpt($comment->content, 80),
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>',
                            'color' => 'text-pink-600 bg-pink-100',
                            'label' => __('search.comment'),
                            'url' => route('admin.blog.comments.index') . '?search=' . $comment->id,
                            'author' => $comment->user->name ?? __('search.anonymous'),
                            'date' => $comment->created_at->format('d/m/Y'),
                            'status' => $comment->status,
                        ];
                    })
                    ->toArray();

                $searchResults = array_merge($searchResults, $comments);
            }

            // 7. Search Newsletter Subscribers - Admin only
            if ($isAdmin) {
                $subscribers = NewsletterSubscriber::where(function ($q) {
                    $q->where('email', 'ILIKE', "%{$this->query}%")
                      ->orWhere('name', 'ILIKE', "%{$this->query}%");
                })
                    ->latest()
                    ->take(3)
                    ->get()
                    ->map(function ($subscriber) {
                        return [
                            'type' => 'newsletter',
                            'id' => $subscriber->id,
                            'title' => $subscriber->name ?? $subscriber->email,
                            'excerpt' => $subscriber->email,
                            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                            'color' => 'text-teal-600 bg-teal-100',
                            'label' => __('search.newsletter'),
                            'url' => route('admin.newsletter.list') . '?search=' . $subscriber->email,
                            'author' => __('search.subscriber'),
                            'date' => $subscriber->created_at->format('d/m/Y'),
                            'status' => $subscriber->isActive() ? 'active' : 'unsubscribed',
                        ];
                    })
                    ->toArray();

                $searchResults = array_merge($searchResults, $subscribers);
            }

            // Sort by date (most recent first) and limit to 20
            usort($searchResults, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            return array_slice($searchResults, 0, 20);
        });

        $this->totalResults = count($this->results);
    }

    private function getExcerpt($text, $length = 100)
    {
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length) . '...';
    }

    public function open()
    {
        $this->isOpen = true;
        $this->query = '';
        $this->results = [];
        $this->selectedIndex = -1;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->query = '';
        $this->results = [];
        $this->selectedIndex = -1;
    }

    public function selectNext()
    {
        if ($this->totalResults > 0) {
            $this->selectedIndex = ($this->selectedIndex + 1) % $this->totalResults;
        }
    }

    public function selectPrevious()
    {
        if ($this->totalResults > 0) {
            $this->selectedIndex = $this->selectedIndex <= 0
                ? $this->totalResults - 1
                : $this->selectedIndex - 1;
        }
    }

    public function selectResult()
    {
        if ($this->selectedIndex >= 0 && $this->selectedIndex < $this->totalResults) {
            $result = $this->results[$this->selectedIndex];
            return redirect($result['url']);
        }
    }

    public function goToResult($index)
    {
        if (isset($this->results[$index])) {
            $this->redirect($this->results[$index]['url'], navigate: true);
        }
    }
}