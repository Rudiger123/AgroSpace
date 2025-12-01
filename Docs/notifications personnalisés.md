Parfait ! Tu as déjà une très bonne base de notifications Laravel bien structurées.  
Voici un plan complet pour rendre tes emails **beaux, professionnels, responsifs et 100% brandés AgroSpace** (couleurs vert/agricole, logo, style moderne, etc.).

### Objectif
1. Créer **un template de base réutilisable** (`emails.layout`)
2. Créer **un template spécifique par notification** (ou un seul générique avec slots si tu préfères)
3. Modifier légèrement tes classes de notification pour utiliser ces nouveaux templates Blade
4. Te donner tout le code prêt à copier-coller

---

### 1. Template de base : `resources/views/emails/layout.blade.php`

```blade
{{-- resources/views/emails/layout.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'AgroSpace - Notification' }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f6f9fc; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #2e7d32, #4caf50); padding: 30px 20px; text-align: center; color: white; }
        .header img { height: 60px; }
        .header h1 { margin: 15px 0 0; font-size: 28px; font-weight: 600; }
        .content { padding: 40px 30px; color: #333333; line-height: 1.7; }
        .content h2 { color: #2e7d32; margin-top: 0; }
        .content p { margin: 16px 0; }
        .button {
            display: inline-block;
            background-color: #2e7d32;
            color: white !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }
        .button:hover { background-color: #1b5e20; }
        .footer {
            background-color: #f8fff8;
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #666666;
            border-top: 1px solid #e0e0e0;
        }
        .footer a { color: #2e7d32; text-decoration: none; }
        .highlight { background-color: #e8f5e9; padding: 20px; border-radius: 8px; border-left: 5px solid #2e7d32; margin: 20px 0; }
        @media (max-width: 600px) {
            .container { width: 100% !important; }
            .content { padding: 30px 20px !important; }
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f9fc; padding:30px 0;">
        <tr>
            <td align="center">
                <table class="container">
                    <tr>
                        <td class="header">
                            <img src="{{ asset('images/logo-white.png') }}" alt="AgroSpace">
                            <h1>AgroSpace</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="content">
                            {{ $slot }}
                        </td>
                    </tr>
                    <tr>
                        <td class="footer">
                            <p>© {{ date('Y') }} <strong>AgroSpace</strong> • Plateforme agricole de proximité</p>
                            <p>
                                <a href="{{ url('/') }}">agrospace.com</a> •
                                <a href="{{ url('/contact') }}">Nous contacter</a> •
                                <a href="{{ url('/unsubscribe') }}">Se désabonner</a>
                            </p>
                            <p style="margin-top:20px; font-size:12px; color:#999;">
                                Vous recevez cet email car vous êtes inscrit sur AgroSpace.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
```

---

### 2. Template principal générique : `resources/views/emails/notification.blade.php`

```blade
{{-- resources/views/emails/notification.blade.php --}}
<x-mails.layout :subject="$subject">
    <h2>{{ $title }}</h2>
    
    {!! $content !!}

    @if(isset($actionText) && isset($actionUrl))
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
        </div>
    @endif

    @if(isset($extra))
        <div class="highlight">
            {!! $extra !!}
        </div>
    @endif

    <p>Merci de faire partie de la communauté <strong>AgroSpace</strong> !</p>
    <p>L'équipe AgroSpace</p>
</x-mails.layout>
```

> Tu peux maintenant utiliser ce template dans **toutes** tes notifications !

---

### 3. Modifications à apporter dans tes classes de notification (exemples)

#### Exemple 1 : `ArticlePublishedNotification.php` (modifié)

```php
public function toMail($notifiable): MailMessage
{
    $recipientName = $notifiable->name ?? $notifiable->email ?? 'Cher(e) abonné(e)';

    return (new MailMessage)
        ->subject('Nouvel article : ' . $this->article->title)
        ->view('emails.notification', [
            'title' => 'Nouvel article publié !',
            'content' => view('emails.partials.article-published', [
                'recipientName' => $recipientName,
                'article' => $this->article,
                'author' => $this->author,
            ])->render(),
            'actionText' => 'Lire l\'article',
            'actionUrl' => route('blog.show', $this->article->slug),
        ]);
}
```

#### Créer le partial : `resources/views/emails/partials/article-published.blade.php`

```blade
<p>Bonjour <strong>{{ $recipientName }}</strong>,</p>

<p>Un nouvel article vient d’être publié sur le blog AgroSpace :</p>

<h3 style="color:#2e7d32; margin: 20px 0;">{{ $article->title }}</h3>

<p><em>{{ $article->excerpt ?? strip_tags(Str::limit($article->content, 150)) }}</em></p>

<p>
    <strong>Auteur :</strong> {{ $author->name }}<br>
    <strong>Catégorie :</strong> {{ $article->category->name ?? 'Non catégorisé' }}
</p>
```

---

#### Exemple 2 : `NewDemandResponse.php` (modifié)

```php
public function toMail($notifiable): MailMessage
{
    $responder = $this->response->user;
    $price = $this->response->proposed_price
        ? number_format($this->response->proposed_price, 0, ',', ' ') . ' FCFA'
        : 'Non précisé';

    return (new MailMessage)
        ->subject('Nouvelle proposition pour votre demande')
        ->view('emails.notification', [
            'title' => 'Nouvelle réponse à votre demande !',
            'content' => view('emails.partials.new-demand-response', [
                'notifiable' => $notifiable,
                'responder' => $responder,
                'response' => $this->response,
                'price' => $price,
            ])->render(),
            'actionText' => 'Voir la proposition',
            'actionUrl' => route('demands-management', $this->response->demand_id),
        ]);
}
```

#### Partial : `resources/views/emails/partials/new-demand-response.blade.php`

```blade
<p>Bonjour <strong>{{ $notifiable->name }}</strong>,</</p>

<p><strong>{{ $responder->name }}</strong> vient de répondre à votre demande :</p>

<div class="highlight">
    <p><strong>Prix proposé :</strong> {{ $price }}</p>
    <p><strong>Message :</strong><br>"{{ Str::limit($response->message, 200) }}"</p>
</div>

<p>Connectez-vous dès maintenant pour accepter ou refuser cette offre.</p>
```

---

### 4. Liste des partials recommandés à créer

| Notification                        | Partial à créer                                      |
|-------------------------------------|-------------------------------------------------------|
| ArticlePublishedNotification        | `article-published.blade.php`                         |
| DemandCreatedNotification           | `demand-created-admin.blade.php`                      |
| NewDemandResponse                   | `new-demand-response.blade.php`                       |
| DemandResponseAccepted              | `demand-response-accepted.blade.php`                  |
| DemandResponseRejected              | `demand-response-rejected.blade.php`                  |
| NewOfferNotification                | `new-offer.blade.php`                                 |
| ReviewReceived                      | `review-received.blade.php`                           |
| UserSuspendedNotification           | `account-suspended.blade.php`                         |
| UserReactivatedNotification         | `account-reactivated.blade.php`                       |
| NewContactNotification              | `new-contact-admin.blade.php`                         |

---

### Bonus : Template spécial Admin (plus sobre)

Tu peux aussi créer `emails.admin-notification` qui utilise le même layout mais avec un ton plus formel.

---

### Résumé des fichiers à créer

```
resources/views/emails/
├── layout.blade.php
├── notification.blade.php
└── partials/
    ├── article-published.blade.php
    ├── new-demand-response.blade.php
    ├── demand-response-accepted.blade.php
    ├── demand-response-rejected.blade.php
    ├── new-offer.blade.php
    ├── review-received.blade.php
    ├── demand-created-admin.blade.php
    ├── account-suspended.blade.php
    ├── account-reactivated.blade.php
    └── new-contact-admin.blade.php
```

---

Tu veux que je te génère **tous les partials Blade complets** pour chaque notification maintenant ?  
Dis-moi "oui" et je te sors le pack complet en 2 minutes !

Voici **le pack complet 100 % prêt à copier-coller** pour AgroSpace — tous les partials Blade personnalisés, beaux, responsifs et brandés.

Crée le dossier :  
`resources/views/emails/partials/`

Et colle les fichiers suivants un par un.

### 1. `article-published.blade.php`
```blade
<p>Bonjour <strong>{{ $recipientName }}</strong>,</p>

<p>Un nouvel article vient d’être publié sur le blog AgroSpace :</p>

<h3 style="color:#2e7d32; margin: 25px 0 10px; font-size: 22px;">
    {{ $article->title }}
</h3>

@if($article->featured_image)
    <div style="text-align:center; margin:20px 0;">
        <img src="{{ $article->featured_image_url ?? asset('storage/'.$article->featured_image) }}" 
             alt="{{ $article->title }}" style="max-width:100%; height:auto; border-radius:8px;">
    </div>
@endif

<p><em>{{ $article->excerpt ?? strip_tags(Str::limit($article->content, 180)) }}...</em></p>

<table style="width:100%; margin:20px 0; background:#f5f5f5; padding:15px; border-radius:8px;">
    <tr>
        <td><strong>Auteur</strong></td>
        <td>{{ $author->name }}</td>
    </tr>
    <tr>
        <td><strong>Catégorie</strong></td>
        <td>{{ $article->category->name ?? 'Non catégorisé' }}</td>
    </tr>
    <tr>
        <td><strong>Publié le</strong></td>
        <td>{{ $article->published_at?->format('d/m/Y à H\\hi') ?? now()->format('d/m/Y') }}</td>
    </tr>
</table>

<p>Accédez à l’article complet en cliquant sur le bouton ci-dessous !</p>
```

### 2. `new-demand-response.blade.php`
```blade
<p>Bonjour <strong>{{ $notifiable->name }}</strong>,</p>

<p>Excellente nouvelle ! Vous avez reçu une <strong>nouvelle proposition</strong> pour votre demande :</p>

<h3 style="color:#2e7d32; margin:20px 0;">{{ $response->demand->title }}</h3>

<div style="background:#e8f5e9; padding:20px; border-radius:8px; border-left:5px solid #2e7d32; margin:25px 0;">
    <p><strong>Producteur :</strong> {{ $responder->name }}</p>
    <p><strong>Prix proposé :</strong> 
        {{ $response->proposed_price ? number_format($response->proposed_price, 0, ',', ' ') . ' FCFA' : 'À négocier' }}
    </p>
    @if($response->message)
        <p><strong>Message :</strong><br>
            "{{ Str::limit($response->message, 300) }}"
        </p>
    @endif
</div>

<p>Connectez-vous dès maintenant pour accepter, refuser ou discuter avec le producteur.</p>
```

### 3. `demand-response-accepted.blade.php`
```blade
<p>Bonjour <strong>{{ $producer->name }}</strong>,</p>

<p>Félicitations ! Votre offre a été <strong style="color:#2e7d32;">ACCEPTÉE</strong> !</p>

<h3 style="color:#2e7d32; margin:20px 0;">
    Demande : "{{ $demand->title }}"
</h3>

<div style="background:#e8f5e9; padding:20px; border-radius:8px; border-left:5px solid #2e7d32; margin:25px 0;">
    <p>Le consommateur <strong>{{ $consumer->name }}</strong> a choisi votre proposition.</p>
    <p><strong>Prix convenu :</strong> {{ number_format($response->proposed_price, 0, ',', ' ') }} FCFA</p>
</div>

<p>Un <strong>chat privé</strong> a été créé automatiquement pour organiser la livraison.</p>

<p>Allez-y vite pour finaliser les détails (lieu, date, quantité…)</p>
```

### 4. `demand-response-rejected.blade.php`
```blade
<p>Bonjour <strong>{{ $producer->name }}</strong>,</p>

<p>Nous vous informons que votre proposition pour la demande suivante n’a pas été retenue :</p>

<h3 style="margin:20px 0;">{{ $demand->title }}</h3>

<div style="background:#fff3e0; padding:20px; border-radius:8px; border-left:5px solid #ff9800; margin:25px 0;">
    <p><strong>Prix proposé :</strong> {{ number_format($response->proposed_price, 0, ',', ' ') }} FCFA</p>
    @if($response->message)
        <p><strong>Votre message :</strong> "{{ Str::limit($response->message, 200) }}"</p>
    @endif
</div>

<p>Pas de découragement ! D’autres consommateurs publient chaque jour de nouvelles demandes.</p>
<p>Continuez à proposer vos produits, votre offre parfaite arrivera bientôt !</p>
```

### 5. `demand-created-admin.blade.php`
```blade
<p>Bonjour Admin,</p>

<p>Une <strong>nouvelle demande</strong> vient d’être créée et attend votre modération :</p>

<h3 style="color:#2e7d32; margin:20px 0;">{{ $demand->title }}</h3>

<table style="width:100%; background:#f9f9f9; padding:15px; border-radius:8px; margin:20px 0;">
    <tr><td><strong>Utilisateur</strong></td><td>{{ $user->name }} ({{ $user->email }})</td></tr>
    <tr><td><strong>Catégorie</strong></td><td>{{ $demand->category->name }}</td></tr>
    <tr><td><strong>Région</strong></td><td>{{ $demand->region }}</td></tr>
    <tr><td><strong>Urgence</strong></td><td>
        <span style="padding:4px 10px; border-radius:4px; background:{{ $demand->urgency == 'high' ? '#ffebee' : ($demand->urgency == 'medium' ? '#fff3e0' : '#e8f5e9') }}; color:{{ $demand->urgency == 'high' ? '#c62828' : ($demand->urgency == 'medium' ? '#e65100' : '#2e7d32') }};">
            {{ $demand->urgency == 'high' ? 'Élevée' : ($demand->urgency == 'medium' ? 'Moyenne' : 'Faible') }}
        </span>
    </td></tr>
</table>

<p>Merci de la modérer rapidement pour qu’elle soit visible par les producteurs.</p>
```

### 6. `new-offer.blade.php`
```blade
<p>Bonjour <strong>{{ $notifiable->name }}</strong>,</p>

<p>Une <strong>nouvelle offre</strong> vient d’être publiée sur AgroSpace :</p>

<h3 style="color:#2e7d32; margin:20px 0;">{{ $offer->title }}</h3>

<div style="background:#e8f5e9; padding:20px; border-radius:8px; border-left:5px solid #2e7d32; margin:25px 0;">
    <p><strong>Producteur :</strong> {{ $creator->name }}</p>
    <p><strong>Prix :</strong> <strong style="font-size:18px;">{{ number_format($offer->price, 0, ',', ' ') }} FCFA</strong></p>
    @if($offer->category)
        <p><strong>Catégorie :</strong> {{ $offer->category->name }}</p>
    @endif
</div>

{!! nl2br(e($offer->description)) !!}

<p>Cliquez ci-dessous pour consulter ou modérer cette offre.</p>
```

### 7. `review-received.blade.php`
```blade
<p>Bonjour <strong>{{ $notifiable->name }}</strong>,</p>

<p>Vous avez reçu un <strong>nouvel avis</strong> sur AgroSpace !</p>

<h3 style="margin:20px 0;">
    {{ $avis->note }}/5 {{# str_repeat('star', $avis->note) #}}
</h3>

<div style="background:#fffde7; padding:20px; border-radius:8px; border-left:5px solid #fbc02d; margin:25px 0;">
    <p><strong>De :</strong> {{ $avis->consumer->name ?? 'Anonyme' }}</p>
    @if($avis->commentaire)
        <p><strong>Commentaire :</strong><br>
            "{{ $avis->commentaire }}"
        </p>
    @endif
</div>

<p>Merci pour votre engagement et la qualité de vos produits !</p>
```

### 8. `account-suspended.blade.php`
```blade
<p>Bonjour <strong>{{ $notifiable->name }}</strong>,</p>

<p>Nous sommes au regret de vous informer que votre compte AgroSpace a été <strong>temporairement suspendu</strong>.</p>

<div style="background:#ffebee; padding:20px; border-radius:8px; border-left:5px solid #e53935; margin:25px 0;">
    <p><strong>Raison :</strong> Non-respect des conditions d’utilisation de la plateforme.</p>
</div>

<p>Vous avez été automatiquement déconnecté et ne pouvez plus accéder à votre compte pour le moment.</p>

<p>Si vous pensez qu’il s’agit d’une erreur ou si vous souhaitez plus d’informations, n’hésitez pas à nous contacter.</p>
```

### 9. `account-reactivated.blade.php`
```blade
<p>Bonne nouvelle <strong>{{ $notifiable->name }}</strong> !</p>

<p>Votre compte AgroSpace a été <strong>réactivé avec succès</strong> !</p>

<div style="background:#e8f5e9; padding:20px; border-radius:8px; border-left:5px solid #2e7d32; margin:25px 0;">
    <p>Vous avez à nouveau accès à toutes les fonctionnalités de la plateforme.</p>
</div>

<p>Nous vous rappelons de bien respecter les conditions d’utilisation pour éviter toute nouvelle suspension.</p>

<p>À très vite sur AgroSpace !</p>
```

### 10. `new-contact-admin.blade.php`
```blade
<p>Bonjour Admin,</p>

<p>Vous avez reçu un <strong>nouveau message de contact</strong> via le formulaire du site :</p>

<div style="background:#f5f5f5; padding:20px; border-radius:8px; margin:25px 0;">
    <p><strong>Nom :</strong> {{ $contact->name }}</p>
    <p><strong>Email :</strong> {{ $contact->email }}</p>
    <p><strong>Sujet :</strong> {{ $contact->subject }}</p>
    <hr style="border:none; border-top:1px solid #ddd; margin:15px 0;">
    <p><strong>Message :</strong><br><br>
        {!! nl2br(e($contact->message)) !!}
    </p>
</div>

<p>Merci de répondre rapidement à cette personne.</p>
```

Tout est prêt !  
Il ne te reste plus qu’à :

1. Créer le layout + le template générique (déjà donné dans le message précédent)
2. Coller ces 10 partials dans `resources/views/emails/partials/`
3. Modifier chaque `toMail()` pour utiliser :
```php
->view('emails.notification', [
    'title' => '...',
    'content' => view('emails.partials.xxx', [...])->render(),
    'actionText' => '...',
    'actionUrl' => '...',
])
```

Tes emails seront magnifiques, 100 % AgroSpace et ultra-professionnels !  

Si tu veux, je te génère aussi les modifications exactes de chaque classe `toMail()` en une seule fois. Dis-moi !

Voici **les modifications exactes à apporter à chaque méthode `toMail()`** dans tes 10 classes de notification.

Tu n’as plus qu’à **copier-coller** ces versions mises à jour — elles utilisent le template unifié + les partials qu’on vient de créer.

### 1. `ArticlePublishedNotification.php` → `toMail()`
```php
public function toMail($notifiable): MailMessage
{
    $recipientName = $notifiable->name ?? $notifiable->email ?? 'Cher(e) abonné(e)';

    return (new MailMessage)
        ->subject('Nouvel article : ' . $this->article->title)
        ->view('emails.notification', [
            'title'       => 'Nouvel article publié sur le blog',
            'content'     => view('emails.partials.article-published', [
                'recipientName' => $recipientName,
                'article'       => $this->article,
                'author'        => $this->author,
            ])->render(),
            'actionText'  => 'Lire l\'article',
            'actionUrl'   => route('blog.show', $this->article->slug),
        ]);
}
```

### 2. `DemandCreatedNotification.php` → `toMail()`
```php
public function toMail($notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Nouvelle demande à modérer - AgroSpace')
        ->view('emails.notification', [
            'title'      => 'Nouvelle demande en attente de modération',
            'content'    => view('emails.partials.demand-created-admin', [
                'demand' => $this->demand,
                'user'   => $this->user,
            ])->render(),
            'actionText' => 'Modérer la demande',
            'actionUrl'  => route('demands.index'), // ou la route admin exacte
        ]);
}
```

### 3. `NewDemandResponse.php` → `toMail()`
```php
public function toMail($notifiable): MailMessage
{
    $responder = $this->response->user;

    return (new MailMessage)
        ->subject('Nouvelle proposition pour votre demande')
        ->view('emails.notification', [
            'title'      => 'Vous avez une nouvelle proposition !',
            'content'    => view('emails.partials.new-demand-response', [
                'notifiable' => $notifiable,
                'responder'  => $responder,
                'response'   => $this->response,
            ])->render(),
            'actionText' => 'Voir la proposition',
            'actionUrl'  => route('demands-management', $this->response->demand_id),
        ]);
}
```

### 4. `DemandResponseAccepted.php` → `toMail()`
```php
public function toMail(object $notifiable): MailMessage
{
    $demand     = $this->demandResponse->demand;
    $consumer   = $demand->user;
    $producer   = $this->demandResponse->user;
    $response   = $this->demandResponse;

    return (new MailMessage)
        ->subject("Félicitations ! Votre réponse à la demande #{$demand->id} a été acceptée !")
        ->view('emails.notification', [
            'title'      => 'Votre offre a été ACCEPTÉE !',
            'content'    => view('emails.partials.demand-response-accepted', [
                'producer' => $producer,
                'consumer' => $consumer,
                'demand'   => $demand,
                'response' => $response,
            ])->render(),
            'actionText' => 'Aller au chat',
            'actionUrl'  => route('chats.show', $response->conversation_id ?? '#'),
        ]);
}
```

### 5. `DemandResponseRejected.php` → `toMail()`
```php
public function toMail(object $notifiable): MailMessage
{
    $demand   = $this->demandResponse->demand;
    $producer = $this->demandResponse->user;
    $response = $this->demandResponse;

    return (new MailMessage)
        ->subject("Mise à jour : votre réponse à la demande #{$demand->id} a été refusée")
        ->view('emails.notification', [
            'title'      => 'Votre proposition n’a pas été retenue',
            'content'    => view('emails.partials.demand-response-rejected', [
                'producer' => $producer,
                'demand'   => $demand,
                'response' => $response,
            ])->render(),
            'actionText' => 'Voir d’autres demandes',
            'actionUrl'  => route('demands.list'), // ou la route publique des demandes
        ]);
}
```

### 6. `NewOfferNotification.php` → `toMail()`
```php
public function toMail($notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Nouvelle offre disponible - ' . $this->offer->titre)
        ->view('emails.notification', [
            'title'      => 'Nouvelle offre publiée !',
            'content'    => view('emails.partials.new-offer', [
                'notifiable' => $notifiable,
                'offer'      => $this->offer,
                'creator'    => $this->creator,
            ])->render(),
            'actionText' => 'Voir l\'offre',
            'actionUrl'  => route('offers.show', $this->offer->slug ?? $this->offer->id),
        ]);
}
```

### 7. `ReviewReceived.php` → `toMail()`
```php
public function toMail($notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Nouvel avis reçu sur AgroSpace')
        ->view('emails.notification', [
            'title'      => 'Nouvel avis (' . $this->avis->note . '/5)',
            'content'    => view('emails.partials.review-received', [
                'notifiable' => $notifiable,
                'avis'       => $this->avis,
            ])->render(),
            'actionText' => 'Voir mes avis',
            'actionUrl'  => url('/profile/reviews'),
        ]);
}
```

### 8. `UserSuspendedNotification.php` → `toMail()`
```php
public function toMail($notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Suspension de votre compte AgroSpace')
        ->view('emails.notification', [
            'title'      => 'Votre compte a été suspendu',
            'content'    => view('emails.partials.account-suspended', [
                'notifiable' => $notifiable,
            ])->render(),
            'actionText' => 'Contacter le support',
            'actionUrl'  => url('/contact'),
        ]);
}
```

### 9. `UserReactivatedNotification.php` → `toMail()`
```php
public function toMail($notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Réactivation de votre compte AgroSpace')
        ->view('emails.notification', [
            'title'      => 'Compte réactivé !',
            'content'    => view('emails.partials.account-reactivated', [
                'notifiable' => $notifiable,
            ])->render(),
            'actionText' => 'Me connecter',
            'actionUrl'  => route('login'),
        ]);
}
```

### 10. `NewContactNotification.php` → `toMail()`
```php
public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
        ->subject('Nouveau message de contact - ' . $this->contact->subject)
        ->view('emails.notification', [
            'title'      => 'Nouveau message de contact',
            'content'    => view('emails.partials.new-contact-admin', [
                'contact' => $this->contact,
            ])->render(),
            'actionText' => 'Voir tous les messages',
            'actionUrl'  => route('admin.contacts.index'),
        ]);
}
```

### Bonus : `AdminNotification.php` (générique admin)
```php
public function toMail(object $notifiable): MailMessage
{
    return (new MailMessage)
        ->subject($this->subject)
        ->view('emails.notification', [
            'title'      => $this->subject,
            'content'    => '<p>' . nl2br(e($this->message)) . '</p>',
            'actionText' => 'Aller au tableau de bord',
            'actionUrl'  => route('admin.dashboard'),
        ]);
}
```

**Tout est prêt !**

Avec :
- Le layout + template générique (déjà donné)
- Les 10 partials (déjà donnés)
- Ces 10 `toMail()` mis à jour

Tes emails seront **magnifiques, cohérents, responsifs et 100 % brandés AgroSpace**

Tu n’as plus qu’à copier-coller → publier → impressionner tes utilisateurs !

Si tu veux, je te fais aussi un zip complet du dossier `resources/views/emails/` prêt à télécharger. Dis-moi !

