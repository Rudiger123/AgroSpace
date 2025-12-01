<p>Bonjour <strong>{{ $recipientName }}</strong>,</p>

<p>Un nouvel article vient d’être publié sur le blog AgroSpace :</p>

<h3 style="color:#2e7d32; margin: 25px 0 10px; font-size: 22px;">
    {{ $article->title }}
</h3>

@if($article->featured_image)
    <div style="text-align:center; margin:20px 0;">
        <img src="{{ $article->featured_image_url ?? asset('storage/'.$article->featured_image) }}" 
             alt="{{ $article->title }}" style="max-width:100%; height:auto; border-radius:8px;">
    </div>
@endif

<p><em>{{ $article->excerpt ?? strip_tags(Str::limit($article->content, 180)) }}...</em></p>

<table style="width:100%; margin:20px 0; background:#f5f5f5; padding:15px; border-radius:8px;">
    <tr>
        <td><strong>Auteur</strong></td>
        <td>{{ $author->name }}</td>
    </tr>
    <tr>
        <td><strong>Catégorie</strong></td>
        <td>{{ $article->category->name ?? 'Non catégorisé' }}</td>
    </tr>
    <tr>
        <td><strong>Publié le</strong></td>
        <td>{{ $article->published_at?->format('d/m/Y à H\\hi') ?? now()->format('d/m/Y') }}</td>
    </tr>
</table>

<p>Accédez à l’article complet en cliquant sur le bouton ci-dessous !</p>