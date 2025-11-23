{{-- resources/views/emails/offer-deleted.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; padding: 12px 30px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
        .alert-box { background: #fef2f2; border: 2px solid #f87171; padding: 15px; border-radius: 6px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">🗑️ Offre Supprimée</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $producerName }}</strong>,</p>
            
            <p>Nous vous informons que votre offre <strong>{{ $offerTitle }}</strong> a été définitivement supprimée de notre plateforme.</p>
            
            <div class="alert-box">
                <strong>Raison de la suppression :</strong><br>
                {{ $deletionReason }}
            </div>
            
            <p style="color: #dc2626; font-weight: bold;">⚠️ Cette action est irréversible.</p>
            
            <p>Si vous pensez qu'il s'agit d'une erreur, veuillez contacter notre service support dans les plus brefs délais.</p>
            
            <center>
                <a href="{{ $supportUrl }}" class="button">Contacter le support</a>
            </center>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>