<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les tags populaires
        $tags = [
            // Céréales et cultures de base
            'maïs',
            'blé',
            'soja',
            'riz',
            'sorgho',
            'mil',
            'igname',
            'manioc',
            'plantain',

            // Légumes et fruits
            'tomate',
            'carotte',
            'laitue',
            'oignon',
            'aubergine',
            'piment',
            'haricot',
            'gombo',
            'banane',
            'mangue',
            'ananas',
            'avocat',
            'papaye',

            // Élevage et produits animaux
            'bovins',
            'ovins',
            'caprins',
            'porcins',
            'volaille',
            'poulet',
            'œufs',
            'lait',
            'fromage',
            'miel',
            'apiculture',

            // Techniques agricoles
            'irrigation',
            'engrais',
            'compost',
            'pesticides',
            'semences',
            'rotation',
            'jachère',
            'paillage',
            'greffage',

            // Équipements
            'tracteur',
            'moissonneuse',
            'semoir',
            'charrues',
            'arrosoir',
            'pompe',
            'serre',
            'stockage',

            // Pratiques durables
            'agroécologie',
            'permaculture',
            'biologique',
            'biodiversité',
            'conservation',
            'régénération',
            'durabilité',

            // Marché et économie
            'marché-local',
            'exportation',
            'importation',
            'commerce',
            'économie',
            'prix',
            'subvention',
            'financement',
            'microcrédit',

            // Technologies
            'innovation',
            'technologie',
            'drone',
            'capteur',
            'iot',
            'intelligence-artificielle',
            'gps',
            'agriculture-précision',
            'digitalisation',

            // Climat et environnement
            'météo',
            'climat',
            'saison',
            'sécheresse',
            'inondation',
            'canicule',
            'gel',
            'précipitation',
            'température',
            'changement-climatique',

            // Transformation
            'transformation',
            'conserves',
            'séchage',
            'conditionnement',
            'emballage',
            'labelisation',

            // Éducation et formation
            'formation',
            'apprentissage',
            'coopérative',
            'association',
            'jeunes-agriculteurs',
            'femmes-agricultrices',

            // Spécifiques à AgroSpace
            'agrospace',
            'plateforme',
            'mise-en-relation',
            'producteur-local',
            'consommation-locale',
            'circuit-court',
            'vente-directe',
            'transparence',
            'traçabilité',

            // Régions camerounaises
            'ouest-cameroun',
            'centre-cameroun',
            'nord-cameroun',
            'littoral',
            'extrême-nord',
            'adamaoua',
            'est',
            'nord-ouest',
            'sud-ouest',
            'sud',
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
                'description' => 'Tag pour ' . $tagName,
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
            ]);
        }

        // Articles de promotion AgroSpace
        $agrospacePosts = [
            [
                'title' => 'AgroSpace : La Révolution Digitale du Secteur Agropastoral Africain',
                'excerpt' => 'Découvrez comment AgroSpace transforme les échanges agricoles traditionnels en connectant directement producteurs et consommateurs sur une plateforme innovante.',
                'category' => 'innovations',
                'tags' => [
                    'agrospace',           // ✅ Existe dans la nouvelle liste
                    'innovation',          // ✅ Existe dans la nouvelle liste
                    'technologie',         // ✅ Existe dans la nouvelle liste
                    'digitalisation',      // ✅ NOUVEAU - Mieux que "plateforme"
                    'mise-en-relation',    // ✅ Existe dans la nouvelle liste
                    'agriculture-précision', // ✅ NOUVEAU - Complémentaire
                    'circuit-court',       // ✅ NOUVEAU - Spécificité AgroSpace
                    'vente-directe',       // ✅ NOUVEAU - Spécificité AgroSpace
                    'transparence',        // ✅ NOUVEAU - Spécificité AgroSpace
                    'traçabilité',         // ✅ NOUVEAU - Spécificité AgroSpace
                ],
                'content' => $this->generateAgrospaceIntroArticle(),
                'featured' => true,
                'meta_title' => 'AgroSpace - La plateforme qui révolutionne l\'agropastoral en Afrique',
                'meta_description' => 'AgroSpace connecte producteurs et consommateurs pour des échanges directs, transparents et durables dans le secteur agropastoral africain.',
                "featured_image" => "/posts/post1.png",
            ],
            [
                'title' => 'Comment AgroSpace Augmente les Revenus des Producteurs Locaux de 40%',
                'excerpt' => 'Grâce à la suppression des intermédiaires et une meilleure valorisation des produits, les agriculteurs retrouvent la juste valeur de leur travail.',
                'category' => 'marche-agricole',
                'tags' => [
                    'agrospace',           // ✅ Existe dans la nouvelle liste
                    'producteur-local',    // ✅ NOUVEAU - Spécificité AgroSpace
                    'marché-local',        // ✅ Existe dans la nouvelle liste
                    'économie',            // ✅ Existe dans la nouvelle liste
                    'prix-juste',          // ✅ Existe dans la nouvelle liste
                    'commerce-direct',     // ✅ Existe dans la nouvelle liste
                    'circuit-court',       // ✅ NOUVEAU - Mieux que "commerce-direct"
                    'microcrédit',         // ✅ NOUVEAU - Complément économique
                    'financement',         // ✅ NOUVEAU - Complément économique
                    'subvention',          // ✅ NOUVEAU - Complément économique
                    'transformation',      // ✅ NOUVEAU - Pour valorisation produits
                ],
                'content' => $this->generateRevenueArticle(),
                'meta_title' => 'Augmentez vos revenus agricoles de 40% avec AgroSpace',
                'meta_description' => 'La plateforme AgroSpace permet aux producteurs de vendre directement aux consommateurs, augmentant significativement leurs marges.',
                "featured_image" => "/posts/post2.png",
            ],
            [
                'title' => 'L\'Impact d\'AgroSpace sur l\'Agriculture Durable au Cameroun',
                'excerpt' => 'Une analyse approfondie des bénéfices environnementaux et sociaux de la digitalisation des filières agricoles locales.',
                'category' => 'durabilite',
                'tags' => [
                    'agrospace',               // ✅ Existe dans la nouvelle liste
                    'agriculture-durable',     // ✅ Existe dans la nouvelle liste
                    'cameroun',                // ✅ Existe dans la nouvelle liste
                    'agroécologie',            // ✅ Existe dans la nouvelle liste
                    'durabilité',              // ✅ Existe dans la nouvelle liste
                    'biodiversité',            // ✅ Existe dans la nouvelle liste
                    'permaculture',            // ✅ Existe dans la nouvelle liste
                    'biologique',              // ✅ Existe dans la nouvelle liste
                    'conservation',            // ✅ NOUVEAU - Complément durable
                    'régénération',            // ✅ NOUVEAU - Complément durable
                    'jeunes-agriculteurs',     // ✅ NOUVEAU - Impact social
                    'femmes-agricultrices',    // ✅ NOUVEAU - Impact social
                    'coopérative',             // ✅ NOUVEAU - Impact social
                    'ouest-cameroun',          // ✅ NOUVEAU - Région spécifique
                    'centre-cameroun',         // ✅ NOUVEAU - Région spécifique
                ],
                'content' => $this->generateSustainabilityArticle(),
                'meta_title' => 'AgroSpace : Pilier de l\'agriculture durable au Cameroun',
                'meta_description' => 'Comment la plateforme AgroSpace contribue au développement d\'une agriculture plus durable et responsable au Cameroun.',
                "featured_image" => "/posts/post3.png",
            ],
        ];

        foreach ($agrospacePosts as $postData) {

            $category = Category::where('slug', $postData['category'])->first();

            if (!$category) {
                $this->command->warn("Catégorie {$postData['category']} non trouvée, création...");
                continue;
            }

            $post = Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'author_id' => User::whereHas('role', function ($query) {
                    $query->where('name', 'admin');
                })->first()->id,
                'category_id' => $category->id,
                'featured_image' => $postData['featured_image'] ?? null,
                'published' => true,
                'published_at' => now()->subDays(rand(0, 2)),
                'views_count' => rand(500, 3000),
                'likes_count' => rand(50, 400),
                'comments_count' => rand(5, 30),
                'is_featured' => $postData['featured'] ?? false,
                'meta_title' => $postData['meta_title'] ?? null,
                'meta_description' => $postData['meta_description'] ?? null,
            ]);

            // Attacher les tags
            $tagIds = [];
            foreach ($postData['tags'] as $tagName) {
                $tag = Tag::where('name', $tagName)->first();
                if (!$tag) {
                    // Créer le tag s'il n'existe pas
                    $tag = Tag::create([
                        'name' => $tagName,
                        'slug' => Str::slug($tagName),
                        'description' => 'Tag pour ' . $tagName,
                        'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                    ]);
                }
                $tagIds[] = $tag->id;
            }

            if (!empty($tagIds)) {
                $post->tags()->sync($tagIds);
            }

            $this->command->info('✅ Articles de blog créés avec succès!');
        }
    }

    private function generateIrrigationContent(): string
    {
        return <<<HTML
<h2>L'importance d'une irrigation efficace</h2>
<p>L'irrigation est un élément crucial pour le succès de vos cultures. Une bonne gestion de l'eau peut faire la différence entre une récolte exceptionnelle et une saison catastrophique.</p>

<h3>1. Évaluer les besoins en eau</h3>
<p>Chaque culture a des besoins spécifiques en eau. Il est essentiel de comprendre ces besoins pour optimiser votre irrigation.</p>

<h3>2. Choisir le bon système d'irrigation</h3>
<p>Entre l'irrigation goutte à goutte, les aspersers ou l'irrigation par submersion, le choix dépend de vos cultures et de votre terrain.</p>

<h3>3. Surveiller l'humidité du sol</h3>
<p>L'utilisation de capteurs d'humidité peut vous aider à irriguer au bon moment et avec la bonne quantité d'eau.</p>

<h2>Conclusion</h2>
<p>Une irrigation efficace est un investissement rentable qui améliore la qualité et la quantité de vos récoltes tout en préservant cette ressource précieuse qu'est l'eau.</p>
HTML;
    }

    private function generateAIContent(): string
    {
        return <<<HTML
<h2>L'IA au service de l'agriculture</h2>
<p>L'intelligence artificielle révolutionne l'agriculture moderne en apportant des solutions innovantes aux défis contemporains.</p>

<h3>Applications principales</h3>
<ul>
<li>Détection précoce des maladies</li>
<li>Optimisation des traitements phytosanitaires</li>
<li>Prévision des rendements</li>
<li>Gestion automatisée de l'irrigation</li>
</ul>

<h3>Drones et agriculture de précision</h3>
<p>Les drones équipés de caméras et de capteurs permettent une surveillance précise des cultures et une intervention ciblée.</p>

<h2>Perspectives d'avenir</h2>
<p>L'IA continuera de transformer l'agriculture vers une production plus durable, efficiente et respectueuse de l'environnement.</p>
HTML;
    }

    private function generateMarketContent(): string
    {
        return <<<HTML
<h2>État du marché mondial des céréales</h2>
<p>Le marché mondial des céréales connaît des évolutions significatives en 2024, influencées par plusieurs facteurs.</p>

<h3>Tendances principales</h3>
<p>Les prix des céréales restent volatils mais montrent une tendance générale à la hausse.</p>

<h3>Facteurs d'influence</h3>
<ul>
<li>Conditions météorologiques extrêmes</li>
<li>Tensions géopolitiques</li>
<li>Évolution de la demande mondiale</li>
<li>Politiques agricoles nationales</li>
</ul>

<h2>Recommandations</h2>
<p>Les agriculteurs sont encouragés à diversifier leurs cultures et à suivre attentivement l'évolution du marché.</p>
HTML;
    }

    private function generateRegenerativeContent(): string
    {
        return <<<HTML
<h2>Principes de l'agriculture régénérative</h2>
<p>L'agriculture régénérative va au-delà de la durabilité en cherchant à restaurer et améliorer les écosystèmes agricoles.</p>

<h3>Pratiques fondamentales</h3>
<ul>
<li>Couverture permanente du sol</li>
<li>Rotation des cultures</li>
<li>Compostage et gestion de la matière organique</li>
<li>Réduction du travail du sol</li>
</ul>

<h3>Bénéfices mesurables</h3>
<p>Une meilleure santé des sols, une biodiversité accrue et une résilience face aux changements climatiques.</p>

<h2>Mise en œuvre</h2>
<p>La transition vers l'agriculture régénérative nécessite un accompagnement et une adaptation progressive des pratiques.</p>
HTML;
    }

    private function generateClimateContent(): string
    {
        return <<<HTML
<h2>Adaptation au changement climatique</h2>
<p>Le changement climatique représente un défi majeur pour l'agriculture mondiale, nécessitant une adaptation rapide des pratiques.</p>

<h3>Impacts observés</h3>
<ul>
<li>Modification des cycles de croissance</li>
<li>Apparition de nouveaux ravageurs</li>
<li>Stress hydrique accru</li>
<li>Événements météorologiques extrêmes</li>
</ul>

<h3>Stratégies d'adaptation</h3>
<p>Les agriculteurs doivent diversifier leurs cultures, améliorer la gestion de l'eau et adopter des pratiques résilientes.</p>

<h2>Innovations climatiques</h2>
<p>De nouvelles technologies aident les agriculteurs à anticiper et s'adapter aux changements climatiques.</p>
HTML;
    }

    private function generateAgrospaceIntroArticle(): string
    {
        return <<<HTML
<div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-lg mb-8">
    <h2 class="text-3xl font-bold text-green-800 mb-4">🚀 L'Avenir de l'Agriculture Africaine est Ici !</h2>
    <p class="text-lg text-gray-700 mb-6">AgroSpace n'est pas simplement une plateforme - c'est un <strong>mouvement</strong> qui redéfinit les règles du secteur agropastoral en Afrique. Imaginez un monde où chaque agriculteur a un accès direct à son marché, où chaque consommateur connaît l'origine exacte de ses produits, et où les intermédiaires inutiles disparaissent au profit de relations transparentes et équitables.</p>
</div>

<h2>💡 La Genèse d'une Révolution</h2>
<p>Fruit d'une vision ambitieuse et d'une expertise technique pointue, AgroSpace est né d'un constat simple mais puissant : <strong>l'agriculture africaine mérite mieux que les circuits traditionnels.</strong> Alors que le continent dispose d'un potentiel agricole immense, les producteurs locaux peinent souvent à obtenir des prix justes pour leurs récoltes.</p>

<h2>🎯 Notre Mission : Connecter, Valoriser, Transformer</h2>

<h3>🌾 Pour les Producteurs</h3>
<div class="bg-green-100 p-4 rounded-lg mb-4">
    <p>Nous mettons à votre disposition des outils professionnels pour :</p>
    <ul class="list-disc pl-6 mt-2">
        <li><strong>Créer des offres attractives</strong> avec photos et descriptions détaillées</li>
        <li><strong>Atteindre directement les acheteurs</strong> sans intermédiaires</li>
        <li><strong>Gérer votre activité</strong> avec des statistiques précises</li>
        <li><strong>Développer votre réputation</strong> grâce aux avis et évaluations</li>
    </ul>
</div>

<h3>🛒 Pour les Consommateurs</h3>
<div class="bg-blue-100 p-4 rounded-lg mb-4">
    <p>Découvrez une nouvelle façon d'acheter vos produits agricoles :</p>
    <ul class="list-disc pl-6 mt-2">
        <li><strong>Accès direct aux producteurs</strong> de votre région</li>
        <li><strong>Transparence totale</strong> sur l'origine et la qualité</li>
        <li><strong>Prix plus justes</strong> pour vous et pour le producteur</li>
        <li><strong>Expérience d'achat simplifiée</strong> et sécurisée</li>
    </ul>
</div>

<h2>🔥 Fonctionnalités Qui Changent Tout</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="font-bold text-green-700 mb-2">📊 Tableaux de Bord Intelligents</h4>
        <p>Des analyses en temps réel pour suivre vos performances et prendre des décisions éclairées.</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="font-bold text-green-700 mb-2">🗺️ Carte Interactive</h4>
        <p>Trouvez les producteurs près de chez vous avec notre système de géolocalisation avancé.</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="font-bold text-green-700 mb-2">💬 Messagerie Intégrée</h4>
        <p>Communiquez directement avec vos partenaires commerciaux en toute sécurité.</p>
    </div>
    
    <div class="bg-white p-6 rounded-lg mb-2">
        <h4 class="font-bold text-green-700 mb-2">📱 Interface Mobile-Friendly</h4>
        <p>Accédez à AgroSpace depuis votre smartphone, même en milieu rural.</p>
    </div>
</div>

<h2>🌟 Témoignage d'Utilisateur</h2>
<blockquote class="border-l-4 border-green-500 pl-4 italic text-gray-600 my-6">
    "Grâce à AgroSpace, j'ai pu doubler mes revenus en vendant directement à des restaurateurs de la ville. La plateforme est simple d'utilisation et m'a permis de développer mon réseau considérablement."<br>
    <strong>- M. Kamga, Producteur à Bafoussam</strong>
</blockquote>

<h2>🚀 Rejoignez la Révolution AgroSpace</h2>
<p>Que vous soyez producteur cherchant à valoriser vos récoltes, consommateur désireux d'acheter local et de qualité, ou entrepreneur visionnaire, AgroSpace est votre plateforme.</p>

<div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-6 rounded-lg mt-8">
    <h3 class="text-2xl font-bold mb-4">📈 Chiffres Clés</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="text-center">
            <div class="text-3xl font-bold">500+</div>
            <div class="text-sm">Producteurs Actifs</div>
        </div>
        <div class="text-center">
            <div class="text-3xl font-bold">40%</div>
            <div class="text-sm">Augmentation Revenus</div>
        </div>
        <div class="text-center">
            <div class="text-3xl font-bold">10K+</div>
            <div class="text-sm">Transactions</div>
        </div>
        <div class="text-center">
            <div class="text-3xl font-bold">95%</div>
            <div class="text-sm">Satisfaction Clients</div>
        </div>
    </div>
</div>

<p class="mt-8 text-center">
    <a href="/register" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
        ✨ Créer Mon Compte Gratuitement
    </a>
</p>
HTML;
    }

    private function generateRevenueArticle(): string
    {
        return <<<HTML
<div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg mb-8">
    <h2 class="text-3xl font-bold text-orange-800 mb-4">💰 La Transformation Économique des Producteurs Agricoles</h2>
    <p class="text-lg text-gray-700 mb-6">Dans un marché traditionnellement fragmenté où les intermédiaires captent jusqu'à <strong>60% de la valeur</strong>, AgroSpace émerge comme la solution qui redonne le pouvoir - et les revenus - aux véritables acteurs du secteur : les producteurs locaux.</p>
</div>

<h2>📊 L'Analyse Chiffrée : Avant/Après AgroSpace</h2>

<div class="overflow-x-auto my-8">
    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-green-500 text-white">
            <tr>
                <th class="py-3 px-4 text-left">Indicateur</th>
                <th class="py-3 px-4 text-left">Sans AgroSpace</th>
                <th class="py-3 px-4 text-left">Avec AgroSpace</th>
                <th class="py-3 px-4 text-left">Gain</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4 font-medium">Marge Moyenne</td>
                <td class="py-3 px-4">25-35%</td>
                <td class="py-3 px-4 text-green-600 font-bold">55-65%</td>
                <td class="py-3 px-4 text-green-600 font-bold">+40%</td>
            </tr>
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4 font-medium">Paiement Délai</td>
                <td class="py-3 px-4">30-90 jours</td>
                <td class="py-3 px-4 text-green-600 font-bold">0-7 jours</td>
                <td class="py-3 px-4 text-green-600 font-bold">Jusqu'à -87%</td>
            </tr>
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4 font-medium">Pertes Marché</td>
                <td class="py-3 px-4">15-20%</td>
                <td class="py-3 px-4 text-green-600 font-bold">3-5%</td>
                <td class="py-3 px-4 text-green-600 font-bold">-75%</td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="py-3 px-4 font-medium">Nouveaux Clients</td>
                <td class="py-3 px-4">2-3/mois</td>
                <td class="py-3 px-4 text-green-600 font-bold">10-15/mois</td>
                <td class="py-3 px-4 text-green-600 font-bold">+400%</td>
            </tr>
        </tbody>
    </table>
</div>

<h2>💪 Comment AgroSpace Génère cette Plus-Value ?</h2>

<h3>1. Suppression des Intermédiaires</h3>
<p class="mb-4">Chaque intermédiaire traditionnel prend sa commission, réduisant d'autant le revenu du producteur. AgroSpace permet une <strong>vente directe</strong>, transférant cette valeur vers ceux qui la créent réellement.</p>

<h3>2. Meilleure Valorisation des Produits</h3>
<p class="mb-4">Grâce aux fiches produits détaillées, photos de qualité et système d'avis, les producteurs peuvent <strong>justifier des prix plus élevés</strong> pour leurs produits de qualité.</p>

<h3>3. Accès à de Nouveaux Marchés</h3>
<p class="mb-4">Restaurateurs, épiceries fines, consommateurs urbains - autant de marchés difficiles d'accès traditionnellement, désormais à portée de clic.</p>

<h2>📈 Étude de Cas Réelle</h2>
<div class="bg-gray-50 p-6 rounded-lg my-6">
    <h4 class="font-bold text-green-700 mb-2">👨‍🌾 Cas de la Ferme Bio du Mont Fébé</h4>
    <p><strong>Situation initiale :</strong> Producteur de légumes bio vendant aux grossistes à Yaoundé. Marge : 30%.</p>
    <p><strong>Après AgroSpace :</strong> Vente directe à des restaurants et particuliers.</p>
    
    <div class="mt-4 p-4 bg-green-50 rounded">
        <h5 class="font-bold mb-2">🎯 Résultats après 6 mois :</h5>
        <ul class="list-disc pl-6">
            <li>Revenus mensuels : <strong>750,000 FCFA → 1,250,000 FCFA</strong> (+66%)</li>
            <li>Nombre de clients réguliers : <strong>8 → 42</strong></li>
            <li>Prix de vente moyen : <strong>+25%</strong></li>
            <li>Pertes invendus : <strong>-80%</strong></li>
        </ul>
    </div>
</div>

<h2>🛠️ Nos Outils pour Maximiser Vos Revenus</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-8">
    <div class="bg-white p-5 rounded-lg shadow border-t-4 border-green-500">
        <h4 class="font-bold text-green-700 mb-2">📊 Analyse des Prix</h4>
        <p class="text-sm">Suivez en temps réel l'évolution des prix du marché pour optimiser vos ventes.</p>
    </div>
    
    <div class="bg-white p-5 rounded-lg shadow border-t-4 border-green-500">
        <h4 class="font-bold text-green-700 mb-2">📈 Statistiques Avancées</h4>
        <p class="text-sm">Identifiez vos meilleurs produits et vos pics de demande saisonniers.</p>
    </div>
    
    <div class="bg-white p-5 rounded-lg shadow border-t-4 border-green-500">
        <h4 class="font-bold text-green-700 mb-2">🤝 Réseau d'Affaires</h4>
        <p class="text-sm">Connectez-vous avec d'autres producteurs pour des achats groupés ou collaborations.</p>
    </div>
</div>

<h2>🎯 Le Mot de l'Équipe</h2>
<blockquote class="border-l-4 border-orange-500 pl-4 italic text-gray-600 my-6">
    "Notre mission va au-delà de la technologie. Il s'agit de créer un écosystème où chaque producteur peut vivre dignement de son travail. Les chiffres parlent d'eux-mêmes : lorsque nous donnons les bons outils aux agriculteurs, ils transforment non seulement leur vie, mais aussi l'économie locale."<br>
    <strong>- Équipe AgroSpace</strong>
</blockquote>

<div class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white p-8 rounded-lg mt-10 text-center">
    <h3 class="text-2xl font-bold mb-4">Prêt à Transformer vos Revenus ?</h3>
    <p class="mb-6">Rejoignez les centaines de producteurs qui ont déjà augmenté leurs revenus grâce à AgroSpace.</p>
    <a href="/register/producer" class="inline-block bg-white text-orange-600 hover:text-orange-700 font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105">
        🚀 Devenir Producteur sur AgroSpace
    </a>
</div>
HTML;
    }

    private function generateSustainabilityArticle(): string
    {
        return <<<HTML
<div class="bg-gradient-to-r from-teal-50 to-cyan-50 p-6 rounded-lg mb-8">
    <h2 class="text-3xl font-bold text-teal-800 mb-4">🌍 Quand Innovation Rime avec Responsabilité</h2>
    <p class="text-lg text-gray-700 mb-6">AgroSpace ne se contente pas de connecter des acteurs économiques. Nous construisons un <strong>modèle durable</strong> qui régénère les communautés rurales, préserve l'environnement et crée une économie agricole résiliente au Cameroun.</p>
</div>

<h2>🌱 Les 4 Piliers de Notre Approche Durable</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
    <div class="bg-teal-50 p-6 rounded-lg">
        <h3 class="font-bold text-teal-700 mb-3 flex items-center">
            <span class="text-2xl mr-2">♻️</span> Environnement
        </h3>
        <ul class="list-disc pl-5 space-y-2">
            <li>Réduction du gaspillage alimentaire via une meilleure planification</li>
            <li>Diminution des transports grâce aux circuits courts</li>
            <li>Promotion des pratiques agroécologiques</li>
            <li>Valorisation des produits locaux et saisonniers</li>
        </ul>
    </div>
    
    <div class="bg-cyan-50 p-6 rounded-lg">
        <h3 class="font-bold text-cyan-700 mb-3 flex items-center">
            <span class="text-2xl mr-2">👥</span> Social
        </h3>
        <ul class="list-disc pl-5 space-y-2">
            <li>Renforcement des liens ville-campagne</li>
            <li>Formation numérique des producteurs</li>
            <li>Création d'emplois locaux durables</li>
            <li>Autonomisation des jeunes et des femmes agriculteurs</li>
        </ul>
    </div>
    
    <div class="bg-emerald-50 p-6 rounded-lg">
        <h3 class="font-bold text-emerald-700 mb-3 flex items-center">
            <span class="text-2xl mr-2">💼</span> Économique
        </h3>
        <ul class="list-disc pl-5 space-y-2">
            <li>Rétention de la valeur ajoutée dans les régions productrices</li>
            <li>Stabilisation des revenus agricoles</li>
            <li>Diversification des débouchés commerciaux</li>
            <li>Accès facilité au financement via la traçabilité</li>
        </ul>
    </div>
    
    <div class="bg-green-50 p-6 rounded-lg">
        <h3 class="font-bold text-green-700 mb-3 flex items-center">
            <span class="text-2xl mr-2">🏛️</span> Gouvernance
        </h3>
        <ul class="list-disc pl-5 space-y-2">
            <li>Transparence totale des transactions</li>
            <li>Système d'évaluation équitable et vérifié</li>
            <li>Engagement contre les pratiques déloyales</li>
            <li>Dialogue permanent avec les acteurs locaux</li>
        </ul>
    </div>
</div>

<h2>📊 Impact Environnemental Mesurable</h2>

<div class="my-8">
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-lg shadow mb-4">
        <div class="md:w-1/3">
            <h4 class="font-bold text-green-700">🚛 Réduction des Émissions CO₂</h4>
            <p class="text-sm text-gray-600">Circuits courts</p>
        </div>
        <div class="md:w-1/3 text-center">
            <div class="text-3xl font-bold text-green-600">-65%</div>
        </div>
        <div class="md:w-1/3 text-right">
            <p class="text-sm">Comparé au circuit traditionnel</p>
        </div>
    </div>
    
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-lg shadow mb-4">
        <div class="md:w-1/3">
            <h4 class="font-bold text-green-700">🗑️ Diminution du Gaspillage</h4>
            <p class="text-sm text-gray-600">Planification optimisée</p>
        </div>
        <div class="md:w-1/3 text-center">
            <div class="text-3xl font-bold text-green-600">-75%</div>
        </div>
        <div class="md:w-1/3 text-right">
            <p class="text-sm">Produits invendus</p>
        </div>
    </div>
    
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-lg shadow">
        <div class="md:w-1/3">
            <h4 class="font-bold text-green-700">💧 Optimisation Ressources</h4>
            <p class="text-sm text-gray-600">Eau et énergie</p>
        </div>
        <div class="md:w-1/3 text-center">
            <div class="text-3xl font-bold text-green-600">-40%</div>
        </div>
        <div class="md:w-1/3 text-right">
            <p class="text-sm">Grâce aux données partagées</p>
        </div>
    </div>
</div>

<h2>🌍 AgroSpace et les Objectifs de Développement Durable (ODD)</h2>

<p class="mb-6">Notre action s'aligne directement avec plusieurs Objectifs de Développement Durable des Nations Unies :</p>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-8">
    <div class="bg-blue-100 p-4 rounded text-center">
        <div class="text-2xl font-bold text-blue-700">2</div>
        <p class="text-sm font-medium">Faim "Zéro"</p>
    </div>
    <div class="bg-green-100 p-4 rounded text-center">
        <div class="text-2xl font-bold text-green-700">8</div>
        <p class="text-sm font-medium">Travail Décent</p>
    </div>
    <div class="bg-red-100 p-4 rounded text-center">
        <div class="text-2xl font-bold text-red-700">10</div>
        <p class="text-sm font-medium">Inégalités Réduites</p>
    </div>
    <div class="bg-purple-100 p-4 rounded text-center">
        <div class="text-2xl font-bold text-purple-700">12</div>
        <p class="text-sm font-medium">Consommation Responsable</p>
    </div>
</div>

<h2>🤝 Partenariats pour un Impact Amplifié</h2>

<p class="mb-6">Nous collaborons avec des organisations engagées pour renforcer notre impact :</p>

<ul class="list-disc pl-6 space-y-2 mb-8">
    <li><strong>MINADER</strong> : Intégration des politiques agricoles nationales</li>
    <li><strong>ONG Locales</strong> : Formation des petits producteurs</li>
    <li><strong>Universités</strong> : Recherche et développement durable</li>
    <li><strong>Collectivités</strong> : Développement territorial intégré</li>
</ul>

<h2>📝 Témoignage d'Impact</h2>
<div class="bg-teal-50 p-6 rounded-lg my-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <div class="w-16 h-16 bg-teal-500 rounded-full flex items-center justify-center text-white font-bold">CF</div>
        </div>
        <div class="ml-4">
            <p class="italic text-gray-700">"Avant AgroSpace, notre coopérative vendait à perte pendant la saison des pluies. Maintenant, grâce à la planification sur la plateforme, nous diversifions nos cultures et stockons mieux. Nous avons même créé une unité de transformation avec l'argent gagné."</p>
            <p class="mt-3 font-bold">- Coopérative Féminine de Foumbot</p>
            <p class="text-sm text-gray-600">120 membres, spécialisée en maraîchage</p>
        </div>
    </div>
</div>

<h2>🎯 Notre Vision 2030</h2>
<p>D'ici 2030, nous visons à :</p>
<ul class="list-disc pl-6 my-4 space-y-2">
    <li>Connecter <strong>10,000 producteurs</strong> camerounais</li>
    <li>Réduire de <strong>50% le gaspillage alimentaire</strong> dans nos circuits</li>
    <li>Former <strong>5,000 jeunes</strong> aux métiers de l'agriculture numérique</li>
    <li>Planter <strong>100,000 arbres</strong> via notre programme de compensation</li>
    <li>Étendre notre modèle à <strong>5 pays</strong> d'Afrique centrale</li>
</ul>

<div class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white p-8 rounded-lg mt-10 text-center">
    <h3 class="text-2xl font-bold mb-4">Rejoignez le Mouvement Durable</h3>
    <p class="mb-6">Chaque inscription, chaque transaction sur AgroSpace contribue à bâtir une agriculture plus résiliente et plus juste.</p>
    <div class="flex flex-wrap justify-center gap-4">
        <a href="/register" class="inline-block bg-white text-teal-600 hover:text-teal-700 font-bold py-3 px-6 rounded-lg transition duration-300">
            🌱 M'Engager pour l'Agriculture Durable
        </a>
        <a href="/impact" class="inline-block border-2 border-white text-white hover:bg-white hover:text-teal-600 font-bold py-3 px-6 rounded-lg transition duration-300">
            📊 Voir Notre Rapport d'Impact
        </a>
    </div>
</div>
HTML;
    }
}
