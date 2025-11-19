# 📚 Guide d'Utilisation - Système de Notifications AgroSpace

## 🎯 Comment déclencher une notification

### 1️⃣ Nouvelle Offre Créée

```php
// Dans votre OfferController ou service
use App\Events\Notifications\NewOfferCreated;

public function store(Request $request)
{
    // Valider et créer l'offre
    $offer = Offer::create($request->validated());
    
    // Déclencher l'événement de notification
    event(new NewOfferCreated($offer, auth()->user()));
    
    return redirect()->route('offers.index')
        ->with('success', 'Offre créée avec succès');
}
```

### 2️⃣ Producteur Noté

```php
// Dans votre ReviewController ou service
use App\Events\Notifications\ProducerRated;

public function store(Request $request, User $producer)
{
    // Créer l'avis
    $review = Review::create([
        'producer_id' => $producer->id,
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);
    
    // Déclencher l'événement de notification
    event(new ProducerRated(
        $producer,
        auth()->user(),
        $request->rating,
        $request->comment,
        $review
    ));
    
    return redirect()->back()
        ->with('success', 'Merci pour votre avis !');
}
```

### 3️⃣ Article Publié

```php
// Dans votre PostController ou service
use App\Events\Notifications\ArticlePublished;

public function publish(Post $post)
{
    // Publier l'article
    $post->update([
        'status' => 'published',
        'published_at' => now(),
    ]);
    
    // Déclencher l'événement de notification
    event(new ArticlePublished($post, $post->author));
    
    return redirect()->route('blog.index')
        ->with('success', 'Article publié avec succès');
}
```

---

## 🔔 Intégration du Bell dans le Layout

### Dans votre layout principal (ex: `layouts/app.blade.php`)

```blade
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Votre logo et menu -->
            </div>

            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                @auth
                    @livewire('notification-bell')
                @endauth

                <!-- Autres éléments du header -->
            </div>
        </div>
    </div>
</nav>
```

---

## 📡 Configuration Broadcasting (Laravel Echo)

### 1. Installer Laravel Echo et Pusher

```bash
npm install --save-dev laravel-echo pusher-js
```

### 2. Configurer `resources/js/bootstrap.js`

```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }
});
```

### 3. Mettre à jour `.env`

```env
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster

# Ou pour développement local avec Laravel Websockets
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
```

---

## 🛠️ Créer une Nouvelle Notification

### Template Générique

```php
<?php

namespace App\Events\Notifications;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class YourEventName implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $yourModel;
    public $user;

    public function __construct($yourModel, $user)
    {
        $this->yourModel = $yourModel;
        $this->user = $user;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.' . $this->recipientId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'your.event.name';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->yourModel->id,
            'title' => $this->yourModel->title,
            // ... autres données
        ];
    }
}
```

---

## 📊 Page Complète des Notifications

### Route

```php
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
});
```

### Controller

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }
}
```

### View

```blade
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">
                Toutes les notifications
            </h1>
        </div>

        <div class="divide-y divide-gray-200">
            @livewire('notification-list', ['limit' => 100])
        </div>
    </div>
</div>
@endsection
```

---

## 🧪 Tests

### Test d'Événement

```php
use App\Events\Notifications\NewOfferCreated;
use Illuminate\Support\Facades\Event;

public function test_new_offer_triggers_notification_event()
{
    Event::fake();

    $offer = Offer::factory()->create();
    $user = User::factory()->create();

    event(new NewOfferCreated($offer, $user));

    Event::assertDispatched(NewOfferCreated::class);
}
```

### Test de Notification

```php
use App\Notifications\NewOfferNotification;
use Illuminate\Support\Facades\Notification;

public function test_users_receive_new_offer_notification()
{
    Notification::fake();

    $offer = Offer::factory()->create();
    $user = User::factory()->create();

    $user->notify(new NewOfferNotification($offer, $offer->producer));

    Notification::assertSentTo($user, NewOfferNotification::class);
}
```

---

## 🎨 Personnalisation des Couleurs et Icônes

### Dans votre notification class:

```php
public function toDatabase($notifiable): array
{
    return [
        'type' => 'your_type',
        'title' => 'Votre titre',
        'message' => 'Votre message',
        'icon' => 'bell', // Options: bell, shopping-bag, star, newspaper, user
        'color' => 'green', // Options: green, blue, yellow, orange, red, purple, pink, indigo, gray
        'action_url' => route('your.route'),
        // ... autres données
    ];
}
```

---

## 📱 Préférences de Notification Utilisateur

### Migration pour ajouter les préférences

```php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('email_notifications_enabled')->default(true);
    $table->boolean('push_notifications_enabled')->default(true);
    $table->boolean('blog_notifications_enabled')->default(true);
    $table->json('notification_preferences')->nullable();
});
```

### Page de paramètres

```blade
<form method="POST" action="{{ route('profile.notifications.update') }}">
    @csrf
    @method('PATCH')

    <div class="space-y-4">
        <label class="flex items-center">
            <input type="checkbox" name="email_notifications_enabled" 
                {{ auth()->user()->email_notifications_enabled ? 'checked' : '' }}>
            <span class="ml-2">Recevoir les notifications par email</span>
        </label>

        <label class="flex items-center">
            <input type="checkbox" name="blog_notifications_enabled"
                {{ auth()->user()->blog_notifications_enabled ? 'checked' : '' }}>
            <span class="ml-2">Nouveaux articles du blog</span>
        </label>
    </div>

    <button type="submit" class="mt-4 btn-primary">
        Enregistrer les préférences
    </button>
</form>
```

---

## 🔍 Debugging

### Vérifier les jobs en attente

```bash
php artisan queue:work --verbose
```

### Vérifier les événements broadcast

```bash
php artisan websockets:serve
```

### Log des notifications

```php
// Dans votre AppServiceProvider
use Illuminate\Notifications\Events\NotificationSent;

Event::listen(NotificationSent::class, function ($event) {
    Log::info('Notification sent', [
        'notifiable' => $event->notifiable->id,
        'notification' => get_class($event->notification),
        'channel' => $event->channel,
    ]);
});
```
