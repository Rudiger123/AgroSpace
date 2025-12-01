{{-- resources/views/emails/layout.blade.php --}}
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'AgroSpace - Notification' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f6f9fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .header {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }

        .header img {
            height: 60px;
        }

        .header h1 {
            margin: 15px 0 0;
            font-size: 28px;
            font-weight: 600;
        }

        .content {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.7;
        }

        .content h2 {
            color: #2e7d32;
            margin-top: 0;
        }

        .content p {
            margin: 16px 0;
        }

        .button {
            display: inline-block;
            background-color: #2e7d32;
            color: white !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(46, 125, 50, 0.3);
        }

        .button:hover {
            background-color: #1b5e20;
        }

        .footer {
            background-color: #f8fff8;
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #666666;
            border-top: 1px solid #e0e0e0;
        }

        .footer a {
            color: #2e7d32;
            text-decoration: none;
        }

        .highlight {
            background-color: #e8f5e9;
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid #2e7d32;
            margin: 20px 0;
        }

        @media (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .content {
                padding: 30px 20px !important;
            }
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f9fc; padding:30px 0;">
        <tr>
            <td align="center">
                <table class="container">
                    <tr>
                        <td class="header">
                            <img src="{{ asset('images/logo.png') }}" alt="AgroSpace">
                            <h1>AgroSpace</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="content">
                            {{ $slot }}
                        </td>
                    </tr>
                    <tr>
                        <td class="footer">
                            <p>© {{ date('Y') }} <strong>AgroSpace</strong> • Plateforme agricole de proximité</p>
                            <p>
                                <a href="{{ url('/') }}">agrospace.com</a> •
                                <a href="{{ url('/contact') }}">Nous contacter</a> •
                                <a href="{{ url('/unsubscribe') }}">Se désabonner</a>
                            </p>
                            <p style="margin-top:20px; font-size:12px; color:#999;">
                                Vous recevez cet email car vous êtes inscrit sur AgroSpace.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
