{{-- resources/views/emails/notification.blade.php --}}
<x-emails.layout :subject="$subject">
    <h2>{{ $title }}</h2>
    
    {!! $content !!}

    @if(isset($actionText) && isset($actionUrl))
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
        </div>
    @endif

    @if(isset($extra))
        <div class="highlight">
            {!! $extra !!}
        </div>
    @endif

    <p>Merci de faire partie de la communauté <strong>AgroSpace</strong> !</p>
    <p>L'équipe AgroSpace</p>
</x-emails.layout>