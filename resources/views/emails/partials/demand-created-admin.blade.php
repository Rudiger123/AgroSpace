<p>Bonjour Admin,</p>

<p>Une <strong>nouvelle demande</strong> vient d’être créée et attend votre modération :</p>

<h3 style="color:#2e7d32; margin:20px 0;">{{ $demand->title }}</h3>

<table style="width:100%; background:#f9f9f9; padding:15px; border-radius:8px; margin:20px 0;">
    <tr><td><strong>Utilisateur</strong></td><td>{{ $user->name }} ({{ $user->email }})</td></tr>
    <tr><td><strong>Catégorie</strong></td><td>{{ $demand->category->name }}</td></tr>
    <tr><td><strong>Région</strong></td><td>{{ $demand->region }}</td></tr>
    <tr><td><strong>Urgence</strong></td><td>
        <span style="padding:4px 10px; border-radius:4px; background:{{ $demand->urgency == 'high' ? '#ffebee' : ($demand->urgency == 'medium' ? '#fff3e0' : '#e8f5e9') }}; color:{{ $demand->urgency == 'high' ? '#c62828' : ($demand->urgency == 'medium' ? '#e65100' : '#2e7d32') }};">
            {{ $demand->urgency == 'high' ? 'Élevée' : ($demand->urgency == 'medium' ? 'Moyenne' : 'Faible') }}
        </span>
    </td></tr>
</table>

<p>Merci de la modérer rapidement pour qu’elle soit visible par les producteurs.</p>