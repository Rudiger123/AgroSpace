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