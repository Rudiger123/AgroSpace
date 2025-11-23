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
        // Créer un utilisateur auteur si nécessaire
        $author = User::first() ?? User::factory()->create([
            'name' => 'Auteur Blog',
            'email' => 'auteur@agrospace.com',
            'password' => bcrypt('password'),
        ]);

        // Créer les catégories principales
        $categories = [
            [
                'name' => 'Conseils Techniques',
                'slug' => 'conseils-techniques',
                'description' => 'Conseils et astuces pour améliorer vos pratiques agricoles',
                'color' => '#10B981',
                'icon' => '🌱',
            ],
            [
                'name' => 'Innovations',
                'slug' => 'innovations',
                'description' => 'Les dernières innovations technologiques dans l\'agriculture',
                'color' => '#3B82F6',
                'icon' => '🌱',
            ],
            [
                'name' => 'Marché Agricole',
                'slug' => 'marche-agricole',
                'description' => 'Analyse du marché et tendances économiques',
                'color' => '#F59E0B',
                'icon' => '🌱',
            ],
            [
                'name' => 'Durabilité',
                'slug' => 'durabilite',
                'description' => 'Pratiques durables et agriculture responsable',
                'color' => '#059669',
                'icon' => '🌱',
            ],
            [
                'name' => 'Météo & Climat',
                'slug' => 'meteo-climat',
                'description' => 'Impact du climat sur l\'agriculture et prévisions',
                'color' => '#0EA5E9',
                'icon' => '🌱',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Créer les tags populaires
        $tags = [
            'maïs', 'blé', 'soja', 'riz', 'pomme de terre', 'tomate', 'carotte', 'laitue',
            'irrigation', 'engrais', 'pesticides', 'tracteur', 'moissonneuse', 'semoir',
            'biodiversité', 'agroécologie', 'permaculture', 'biologique', 'label rouge',
            'météo', 'saison', 'récolte', 'plantation', 'germination', 'culture',
            'économie', 'prix', 'marché', 'exportation', 'importation', 'commerce',
            'technologie', 'innovation', 'drone', 'capteur', 'iot', 'intelligence artificielle',
            'sécheresse', 'inondation', 'canicule', 'gel', 'précipitation', 'température'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
                'description' => 'Tag pour ' . $tagName,
                'color' => '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
            ]);
        }

        // Créer des articles de démonstration
        $demoPosts = [
            [
                'title' => 'Les 10 meilleures pratiques pour une irrigation efficace',
                'excerpt' => 'Découvrez comment optimiser votre système d\'irrigation pour économiser l\'eau tout en maximisant les rendements.',
                'category' => 'conseils-techniques',
                'tags' => ['irrigation', 'eau', 'rendement', 'technique'],
                'content' => $this->generateIrrigationContent(),
            ],
            [
                'title' => 'L\'intelligence artificielle révolutionne l\'agriculture moderne',
                'excerpt' => 'Comment l\'IA transforme les pratiques agricoles et aide les agriculteurs à prendre de meilleures décisions.',
                'category' => 'innovations',
                'tags' => ['intelligence-artificielle', 'technologie', 'innovation', 'drone'],
                'content' => $this->generateAIContent(),
            ],
            [
                'title' => 'Analyse du marché des céréales 2024',
                'excerpt' => 'Tendances du marché mondial des céréales et perspectives pour les agriculteurs.',
                'category' => 'marche-agricole',
                'tags' => ['marché', 'céréales', 'économie', 'prix'],
                'content' => $this->generateMarketContent(),
            ],
            [
                'title' => 'Agriculture régénérative : vers un modèle durable',
                'excerpt' => 'Les principes de l\'agriculture régénérative et ses bénéfices pour l\'environnement.',
                'category' => 'durabilite',
                'tags' => ['agriculture-régénérative', 'durabilité', 'environnement', 'sol'],
                'content' => $this->generateRegenerativeContent(),
            ],
            [
                'title' => 'Impact du changement climatique sur les récoltes',
                'excerpt' => 'Comment adapter vos pratiques agricoles face aux changements climatiques.',
                'category' => 'meteo-climat',
                'tags' => ['changement-climatique', 'météo', 'adaptation', 'récolte'],
                'content' => $this->generateClimateContent(),
            ],
        ];

        foreach ($demoPosts as $postData) {
            $post = Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'author_id' => $author->id,
                'category_id' => random_int(1, 4),
                'published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
                'views_count' => rand(100, 5000),
                'likes_count' => rand(10, 500),
                'comments_count' => rand(0, 50),
            ]);

            // Attacher les tags
            $tagIds = [];
            foreach ($postData['tags'] as $tagName) {
                $tag = Tag::where('slug', Str::slug($tagName))->first();
                if ($tag) {
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds);

            // Ajouter quelques commentaires
            $this->addCommentsToPost($post, rand(0, 5));
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

    private function addCommentsToPost($post, $count)
    {
        $commentContents = [
            'Article très intéressant ! Merci pour ces conseils.',
            'J\'ai appliqué ces méthodes et ça fonctionne très bien.',
            'Pourriez-vous développer un peu plus sur ce point ?',
            'Excellente analyse du marché, très utile pour ma planification.',
            'J\'ai une question concernant la mise en œuvre...',
            'Très bon article, j\'ai partagé avec mes collègues.',
            'Les données sont-elles à jour ? Je voudrais plus d\'informations.',
            'Merci pour cette synthèse claire et complète.',
        ];

        for ($i = 0; $i < $count; $i++) {
            Comment::create([
                'post_id' => $post->id,
                'user_id' => User::inRandomOrder()->first()->id,
                'content' => $commentContents[array_rand($commentContents)],
                'status' => 'approved',
                'ip_address' => '127.0.0.1',
            ]);
        }
    }
}
