<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsletterSubject }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; }
        .header { background: #1B5E20; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px; }
        .footer { background: #f9f9f9; padding: 20px; text-align: center; font-size: 14px; color: #666; border-top: 1px solid #eee; }
        .btn { display: inline-block; padding: 12px 24px; background: #1B5E20; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .btn:hover { background: #14532d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>AgroSpace Newsletter</h1>
        </div>
        
        <div class="content">
            <h2 style="color: #1B5E20;">Bonjour {{ $subscriberName }},</h2>
            
            <div style="margin: 20px 0;">
                {!! nl2br(e($messageContent)) !!} 
            </div>
        </div>

        <div class="footer">
            <p>
                Pour vous désabonner de cette newsletter, 
                <a href="{{ $unsubscribeUrl }}" style="color: #1B5E20; font-weight: bold;">cliquez ici</a>.
            </p>
            <p style="margin-top: 15px;">
                <strong>AgroSpace</strong> - Tous droits réservés © {{ date('Y') }}<br>
                <small>Vous recevez cet email car vous êtes abonné à notre newsletter.</small>
            </p>
        </div>
    </div>
</body>
</html>