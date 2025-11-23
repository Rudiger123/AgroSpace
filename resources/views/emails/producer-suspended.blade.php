{{-- resources/views/emails/producer-suspended.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; padding: 12px 30px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
        .warning-box { background: #fff7ed; border: 2px solid #fb923c; padding: 20px; border-radius: 8px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">🚫 Compte Suspendu</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $producerName }}</strong>,</p>
            
            <div class="warning-box">
                <h3 style="margin-top: 0; color: #ea580c;">⚠️ Suspension de compte</h3>
                <p style="margin-bottom: 0;">Votre compte a été temporairement suspendu par notre équipe de modération.</p>
            </div>
            
            <p><strong>Conséquences de cette suspension :</strong></p>
            <ul>
                <li>Vous ne pouvez plus publier de nouvelles offres</li>
                <li>{{ $suspendedOffersCount }} de vos offre(s) ont été désactivées</li>
                <li>Votre profil n'est plus visible publiquement</li>
            </ul>
            
            <p>Cette suspension peut être levée après examen de votre situation par notre équipe.</p>
            
            <center>
                <a href="{{ $supportUrl }}" class="button">Contacter le support</a>
            </center>
            
            <p style="color: #6b7280; font-size: 14px;">Pour faire appel de cette décision ou obtenir plus d'informations, veuillez contacter notre service support.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>