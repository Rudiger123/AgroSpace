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