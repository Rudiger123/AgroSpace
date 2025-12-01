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