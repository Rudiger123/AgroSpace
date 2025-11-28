<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Réponse à votre message</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0;">AgroSpace</h1>
        <p style="color: #f0f0f0; margin: 10px 0 0 0;">Réponse à votre message</p>
    </div>
    
    <div style="background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px;">
        <p style="font-size: 16px;">Bonjour <strong>{{ $contact->name }}</strong>,</p>
        
        <p>Merci pour votre message concernant : <strong>{{ $contact->subject }}</strong></p>
        
        <div style="background: white; padding: 20px; border-left: 4px solid #667eea; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; color: #666; font-size: 14px; font-weight: bold;">Votre message :</p>
            <p style="margin: 10px 0 0 0;">{{ $contact->message }}</p>
        </div>
        
        <div style="background: white; padding: 20px; border-left: 4px solid #10b981; margin: 20px 0; border-radius: 5px;">
            <p style="margin: 0; color: #666; font-size: 14px; font-weight: bold;">Notre réponse :</p>
            <p style="margin: 10px 0 0 0; white-space: pre-line;">{{ $contact->reply_message }}</p>
        </div>
        
        <p>Si vous avez d'autres questions, n'hésitez pas à nous recontacter.</p>
        
        <p style="margin-top: 30px;">Cordialement,<br><strong>L'équipe AgroSpace</strong></p>
        
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;">
        
        <p style="font-size: 12px; color: #9ca3af; text-align: center;">
            © {{ date('Y') }} AgroSpace. Tous droits réservés.<br>
            Cet email a été envoyé automatiquement, merci de ne pas y répondre.
        </p>
    </div>
</body>
</html>