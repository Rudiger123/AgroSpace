<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; padding: 12px 30px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
        .badge { display: inline-block; padding: 5px 10px; background: #d1fae5; color: #065f46; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">✅ Offre Validée</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $producerName }}</strong>,</p>
            
            <p>Nous avons le plaisir de vous informer que votre offre a été <span class="badge">VALIDÉE</span> par notre équipe de modération.</p>
            
            <p><strong>Offre concernée :</strong> {{ $offerTitle }}</p>
            
            @if($validationNote)
            <div style="background: #f3f4f6; padding: 15px; border-left: 4px solid #10b981; margin: 20px 0;">
                <strong>Note de validation :</strong><br>
                {{ $validationNote }}
            </div>
            @endif
            
            <p>Votre offre est maintenant visible par tous les acheteurs sur notre plateforme.</p>
            
            <center>
                <a href="{{ $offerUrl }}" class="button">Voir mon offre</a>
            </center>
            
            <p style="color: #6b7280; font-size: 14px;">Continuez à proposer des offres de qualité pour maximiser vos ventes !</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>