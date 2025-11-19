@component('mail::message')
# Nouvelle offre disponible

Bonjour {{ $notifiable->name }},

Une nouvelle offre vient d'être publiée sur **AgroSpace** qui pourrait vous intéresser.

## {{ $offer->titre }}

{{ $offer->description }}

**Détails de l'offre :**
- **Producteur :** {{ $creator->name }}
- **Prix :** {{ number_format($offer->prix, 0, ',', ' ') }} FCFA
- **Catégorie :** {{ $offer->category->name ?? 'Non spécifiée' }}
- **Quantité disponible :** {{ $offer->quantite_disponible ?? 'Non spécifiée' }}

@component('mail::button', ['url' => route('offers-management', $offer->id)])
Voir l'offre
@endcomponent

Merci d'utiliser AgroSpace !

Cordialement,<br>
{{ config('app.name') }}

---

<small style="color: #718096;">
Vous recevez cet email parce que vous êtes inscrit aux notifications d'offres sur AgroSpace.
<a href="{{ route('profile') }}" style="color: #4299e1;">Gérer mes préférences</a>
</small>
@endcomponent