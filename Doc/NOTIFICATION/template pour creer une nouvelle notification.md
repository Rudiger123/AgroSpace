# 📝 Template - Créer une Nouvelle Notification

Suivez ce template pour créer rapidement une notification pour n'importe quel module.

---

## 📌 PARAMÈTRES À DÉFINIR

```
Module: __________________ (ex: "Demandes", "Commandes", "Messages")
Event Name: __________________ (ex: "DemandCreated", "OrderPlaced")
Description: __________________ (ex: "Quand un utilisateur crée une nouvelle demande")
Payload: __________________ (ex: { demand, user, category })
Recipients: __________________ (ex: "tous les producteurs de la région")
Channels: ☐ mail  ☐ database  ☐ broadcast
```

---

## 1️⃣ EVENT

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
    // Ajoutez d'autres propriétés ici

    /**
     * Create a new event instance.
     */
    public function __construct($yourModel, $user)
    {
        $this->yourModel = $yourModel;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.' . $this->recipientUserId),
            // Ou: new PrivateChannel('admin.notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'your.event.name';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->yourModel->id,
            'title' => $this->yourModel->title,
            'user_name' => $this->user->name,
            'created_at' => now()->toIso8601String(),
        ];
    }
}
```

---

## 2️⃣ LISTENER

```php
<?php

namespace App\Listeners\Notifications;

use App\Events\Notifications\YourEventName;
use App\Notifications\YourNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendYourNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(YourEventName $event): void
    {
        // Définir les destinataires
        $recipients = $this->getRecipients($event);

        // Envoyer la notification à chaque destinataire
        foreach ($recipients as $recipient) {
            $recipient->notify(new YourNotification(
                $event->yourModel,
                $event->user
            ));
        }
    }

    /**
     * Get notification recipients.
     */
    protected function getRecipients(YourEventName $event)
    {
        // LOGIQUE MÉTIER ICI
        // Exemples:
        
        // Tous les admins
        // return User::where('role_id', 1)->get();
        
        // Tous les producteurs
        // return User::where('role_id', 2)->get();
        
        // Utilisateur spécifique
        // return collect([$event->yourModel->user]);
        
        // Utilisateurs avec préférences
        // return User::whereHas('preferences', function($q) use ($event) {
        //     $q->where('category_id', $event->yourModel->category_id);
        // })->get();
    }

    /**
     * Handle a job failure.
     */
    public function failed(YourEventName $event, $exception): void
    {
        logger()->error('Failed to send notification', [
            'event' => get_class($event),
            'error' => $exception->getMessage(),
        ]);
    }
}
```

---

## 3️⃣ NOTIFICATION

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class YourNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $yourModel;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($yourModel, $user)
    {
        $this->yourModel = $yourModel;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        $channels = ['database'];

        if ($notifiable->email_notifications_enabled ?? true) {
            $channels[] = 'mail';
        }

        if ($notifiable->push_notifications_enabled ?? true) {
            $channels[] = 'broadcast';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre Sujet en Français')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre message principal ici.')
            ->line('**Détail important**')
            ->action('Bouton d\'action', url('/votre-route'))
            ->line('Merci d\'utiliser AgroSpace !');
    }

    /**
     * Get the array representation for database.
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'your_notification_type',
            'title' => 'Titre de la notification',
            'message' => 'Message descriptif ici',
            'model_id' => $this->yourModel->id,
            'model_title' => $this->yourModel->title,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'action_url' => route('your.route', $this->yourModel->id),
            'icon' => 'bell', // Options: bell, shopping-bag, star, newspaper, user
            'color' => 'blue', // Options: green, blue, yellow, orange, red, purple, pink, indigo, gray
        ];
    }

    /**
     * Get the broadcastable representation.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => 'your_notification_type',
            'title' => 'Titre de la notification',
            'message' => 'Message descriptif',
            'action_url' => route('your.route', $this->yourModel->id),
            'icon' => 'bell',
            'color' => 'blue',
            'created_at' => now()->toIso8601String(),
        ]);
    }
}
```

---

## 4️⃣ ENREGISTRER L'EVENT

Dans `app/Providers/EventServiceProvider.php`:

```php
protected $listen = [
    // ... autres events

    YourEventName::class => [
        SendYourNotification::class,
    ],
];
```

---

## 5️⃣ DÉCLENCHER L'EVENT

Dans votre Controller/Service:

```php
use App\Events\Notifications\YourEventName;

public function yourMethod()
{
    // Votre logique métier
    $model = YourModel::create($data);

    // Déclencher l'événement
    event(new YourEventName($model, auth()->user()));

    return redirect()->back()
        ->with('success', 'Action réussie !');
}
```

---

## 6️⃣ TESTER

```php
use App\Events\Notifications\YourEventName;
use App\Notifications\YourNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

public function test_event_is_dispatched()
{
    Event::fake();

    // Votre action qui déclenche l'événement
    // ...

    Event::assertDispatched(YourEventName::class);
}

public function test_notification_is_sent()
{
    Notification::fake();

    // Votre action
    // ...

    Notification::assertSentTo($user, YourNotification::class);
}
```

---

## ✅ CHECKLIST

- [ ] Event créé dans `app/Events/Notifications/`
- [ ] Listener créé dans `app/Listeners/Notifications/`
- [ ] Notification créée dans `app/Notifications/`
- [ ] Event enregistré dans `EventServiceProvider`
- [ ] Logique de destinataires définie
- [ ] Textes en français pour l'UI
- [ ] Icône et couleur choisies
- [ ] Route d'action définie
- [ ] Event déclenché dans le code
- [ ] Tests écrits
- [ ] Documentation mise à jour

---

## 🎨 ICÔNES & COULEURS DISPONIBLES

### Icônes
- `bell` - Notification générale
- `shopping-bag` - Offres, produits
- `star` - Avis, évaluations
- `newspaper` - Articles, blog
- `user` - Utilisateurs, profil
- `message` - Messages, commentaires
- `check` - Validation, succès
- `warning` - Avertissement
- `info` - Information

### Couleurs
- `green` - Succès, validation
- `blue` - Information
- `yellow` - Avertissement
- `orange` - Attention
- `red` - Erreur, urgent
- `purple` - Blog, contenu
- `pink` - Social, communauté
- `indigo` - Utilisateurs
- `gray` - Neutre

---

## 📚 EXEMPLES DE DESTINATAIRES

```php
// Tous les admins
User::where('role_id', 1)->get();

// Tous les producteurs
User::where('role_id', 2)->get();

// Tous les consommateurs
User::where('role_id', 3)->get();

// Producteurs d'une région
User::where('role_id', 2)->where('region', $region)->get();

// Utilisateurs avec notifications activées
User::where('email_notifications_enabled', true)->get();

// Utilisateurs intéressés par une catégorie
User::whereHas('preferences', function($q) use ($categoryId) {
    $q->where('category_id', $categoryId);
})->get();

// Un utilisateur spécifique
collect([User::find($userId)]);

// Abonnés newsletter
NewsletterSubscriber::where('status', 'active')->get();
```
