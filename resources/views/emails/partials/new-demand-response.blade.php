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