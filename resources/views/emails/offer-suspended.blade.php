{{-- resources/views/emails/offer-suspended.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; padding: 12px 30px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">🚫 Offre Suspendue</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $producerName }}</strong>,</p>
            
            <p>Votre offre <strong>{{ $offerTitle }}</strong> a été temporairement suspendue par notre équipe de modération.</p>
            
            <p>Votre offre n'est plus visible sur la plateforme jusqu'à nouvel ordre.</p>
            
            <center>
                <a href="{{ $supportUrl }}" class="button">Contacter le support</a>
            </center>
            
            <p style="color: #6b7280; font-size: 14px;">Pour plus d'informations, veuillez contacter notre service support.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>