<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponse à votre message - AgroSpace</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .email-header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .email-body {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .original-message {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .original-message-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .original-message-content {
            color: #495057;
            font-size: 14px;
        }
        .reply-message {
            background-color: #e7f3ff;
            border-left: 4px solid #4a90e2;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .reply-message-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #4a90e2;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .reply-content {
            color: #2c3e50;
            font-size: 15px;
            white-space: pre-line;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer-text {
            color: #6c757d;
            font-size: 13px;
            margin: 5px 0;
        }
        .footer-links {
            margin-top: 15px;
        }
        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
            transition: transform 0.2s;
        }
        .button:hover {
            transform: scale(1.05);
        }
        .divider {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, #e9ecef, transparent);
            margin: 30px 0;
        }
        .info-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info-box p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        {{-- Header --}}
        <div class="email-header">
            <h1>🌾 AgroSpace</h1>
            <p>Réponse à votre message</p>
        </div>

        {{-- Body --}}
        <div class="email-body">
            <div class="greeting">
                Bonjour {{ $contact->name }},
            </div>

            <p style="color: #555; font-size: 15px;">
                Nous avons bien reçu votre message et nous vous remercions de nous avoir contactés. 
                Voici notre réponse à votre demande :
            </p>

            {{-- Message de réponse --}}
            <div class="reply-message">
                <div class="reply-message-title">Notre réponse</div>
                <div class="reply-content">{{ $replyMessage }}</div>
            </div>

            <hr class="divider">

            {{-- Message original --}}
            <div class="original-message">
                <div class="original-message-title">Votre message original</div>
                <div class="original-message-content">
                    <strong style="display: block; margin-bottom: 5px;">Sujet : {{ $contact->subject }}</strong>
                    {{ $contact->message }}
                </div>
            </div>

            {{-- Info box --}}
            <div class="info-box">
                <p>
                    💡 <strong>Besoin d'aide supplémentaire ?</strong><br>
                    N'hésitez pas à répondre directement à cet email si vous avez d'autres questions.
                </p>
            </div>

            {{-- CTA Button --}}
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/') }}" class="button">
                    Visiter notre site web
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="email-footer">
            <p class="footer-text" style="font-weight: 600; color: #333;">AgroSpace</p>
            <p class="footer-text">Votre partenaire pour une agriculture intelligente</p>
            
            <div class="footer-links">
                <a href="{{ url('/') }}">Accueil</a>
                <a href="{{ url('/contact') }}">Contact</a>
                <a href="{{ url('/about') }}">À propos</a>
            </div>

            <p class="footer-text" style="margin-top: 20px; font-size: 12px;">
                © {{ date('Y') }} AgroSpace. Tous droits réservés.
            </p>

            <p class="footer-text" style="font-size: 11px; color: #adb5bd; margin-top: 10px;">
                Cet email a été envoyé le {{ now()->format('d/m/Y à H:i') }}
            </p>
        </div>
    </div>
</body>
</html>