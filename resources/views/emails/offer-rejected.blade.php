{{-- resources/views/emails/offer-rejected.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; padding: 12px 30px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 12px; }
        .alert-box { background: #fef2f2; border: 1px solid #fecaca; padding: 15px; border-radius: 6px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0;">❌ Offre Rejetée</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $producerName }}</strong>,</p>
            
            <p>Nous regrettons de vous informer que votre offre <strong>{{ $offerTitle }}</strong> n'a pas été approuvée.</p>
            
            <div class="alert-box">
                <strong>Raison du rejet :</strong><br>
                {{ $rejectionReason }}
            </div>
            
            <p>Nous vous invitons à corriger les points mentionnés et à soumettre une nouvelle offre conforme à nos conditions d'utilisation.</p>
            
            <center>
                <a href="{{ $supportUrl }}" class="button">Contacter le support</a>
            </center>
            
            <p style="color: #6b7280; font-size: 14px;">Notre équipe reste à votre disposition pour toute question.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        </div>
    </div>
</body>
</html>