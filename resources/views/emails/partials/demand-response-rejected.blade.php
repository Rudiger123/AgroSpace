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