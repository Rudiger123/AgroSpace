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