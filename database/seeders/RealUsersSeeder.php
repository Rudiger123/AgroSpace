<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RealUsersSeeder extends Seeder
{
    public function run(): void
    {
     
            $rudiger = User::create([
                'name' => 'Feutsop Rudiger',
                'email' => 'feutsoprudiger@gmail.com',
                'password' => Hash::make('password123'),
                'role_id' => 1,
                'avatar' => null,
                'status' => 'active',
                'bio' => 'Fondateur et CEO d\'AgroSpace. Passionné par l\'innovation agricole et la transformation digitale du secteur agropastoral en Afrique.',
                'phone' => '+237 690 123 456',
                'region' => 'Ouest',
                'city' => 'Dschang',
                'activity' => 'CEO & Fondateur AgroSpace',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'last_active_at' => now(),
                'last_login_at' => now(),
                'suspended_at' => null,
                'suspended_by' => null,
                'reactivated_at' => null,
                'reactivated_by' => null,
                'email_verified_at' => now(),
                'created_at' => Carbon::now()->subMonths(3),
            ]);
            
            $this->command->info('✅ Feutsop Rudiger (Admin) créé avec succès!');
        

        // 1. PRODUCTEUR - Samuel Kamga
        $samuel = User::firstOrCreate(
            ['email' => 'samuel.kamga@example.com'],
            [
                'name' => 'Samuel Kamga',
                'password' => Hash::make('produire123'),
                'role_id' => 2, // Producteur
                'avatar' => null,
                'status' => 'active',
                'bio' => 'Agriculteur bio depuis 15 ans à Bafoussam. Spécialiste en maraîchage et cultures vivrières. Passionné par les méthodes agroécologiques.',
                'phone' => '+237 677 890 123',
                'region' => 'Ouest',
                'city' => 'Bafoussam',
                'activity' => 'Producteur maraîcher bio',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'last_active_at' => now()->subHours(2),
                'last_login_at' => now()->subHours(2),
                'suspended_at' => null,
                'suspended_by' => null,
                'reactivated_at' => null,
                'reactivated_by' => null,
                'email_verified_at' => now()->subMonths(2),
                'created_at' => Carbon::now()->subMonths(2),
            ]
        );

        // 2. CONSOMMATEUR - Fatima Ngo
        $fatima = User::firstOrCreate(
            ['email' => 'fatima.ngo@example.com'],
            [
                'name' => 'Fatima Ngo',
                'password' => Hash::make('consommer123'),
                'role_id' => 3, // Consommateur
                'avatar' => null,
                'status' => 'active',
                'bio' => 'Cheffe cuisinière au restaurant "Saveurs Locales" à Yaoundé. Je recherche des produits frais et de qualité pour mes plats.',
                'phone' => '+237 699 456 789',
                'region' => 'Centre',
                'city' => 'Yaoundé',
                'activity' => 'Cheffe cuisinière & Restauratrice',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'last_active_at' => now()->subHours(5),
                'last_login_at' => now()->subHours(5),
                'suspended_at' => null,
                'suspended_by' => null,
                'reactivated_at' => null,
                'reactivated_by' => null,
                'email_verified_at' => now()->subMonths(1),
                'created_at' => Carbon::now()->subMonths(1),
            ]
        );

        // 3. PRODUCTEUR - Marie Kouam
        $marie = User::firstOrCreate(
            ['email' => 'marie.kouam@example.com'],
            [
                'name' => 'Marie Kouam',
                'password' => Hash::make('transformer123'),
                'role_id' => 2, // Producteur
                'avatar' => null,
                'status' => 'active',
                'bio' => 'Présidente de la Coopérative Féminine de Foumbot. Nous transformons les produits agricoles locaux en produits à valeur ajoutée.',
                'phone' => '+237 678 123 456',
                'region' => 'Ouest',
                'city' => 'Foumbot',
                'activity' => 'Présidente de coopérative & Transformateur',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'last_active_at' => now()->subDays(1),
                'last_login_at' => now()->subDays(1),
                'suspended_at' => null,
                'suspended_by' => null,
                'reactivated_at' => null,
                'reactivated_by' => null,
                'email_verified_at' => now()->subWeeks(2),
                'created_at' => Carbon::now()->subMonths(2),
            ]
        );

        // 4. CONSOMMATEUR - Jean Mbarga (Épicier)
        $jean = User::firstOrCreate(
            ['email' => 'jean.mbarga@example.com'],
            [
                'name' => 'Jean Mbarga',
                'password' => Hash::make('epicier123'),
                'role_id' => 3, // Consommateur
                'avatar' => null,
                'status' => 'active',
                'bio' => 'Gérant de l\'épicerie "Le Marché Vert" à Douala. Je fournis des produits frais et locaux à ma clientèle depuis 10 ans.',
                'phone' => '+237 690 789 012',
                'region' => 'Littoral',
                'city' => 'Douala',
                'activity' => 'Épicier & Distributeur',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'last_active_at' => now()->subHours(8),
                'last_login_at' => now()->subHours(8),
                'suspended_at' => null,
                'suspended_by' => null,
                'reactivated_at' => null,
                'reactivated_by' => null,
                'email_verified_at' => now()->subWeeks(3),
                'created_at' => Carbon::now()->subMonths(3),
            ]
        );

        $this->command->info('✅ 4 utilisateurs réels créés avec succès!');

        // Ajouter des commentaires authentiques sur les articles AgroSpace
        $this->addRealisticComments();
    }

    private function addRealisticComments(): void
    {
        // Récupérer les articles AgroSpace
        $agrospaceArticles = Post::where('title', 'like', '%AgroSpace%')->get();
        
        if ($agrospaceArticles->isEmpty()) {
            $this->command->warn('⚠️  Aucun article AgroSpace trouvé. Exécutez d\'abord le BlogSeeder.');
            return;
        }

        // Récupérer les utilisateurs réels (sauf Rudiger)
        $users = User::where('email', '!=', 'feutsoprudiger@gmail.com')->get();

        foreach ($agrospaceArticles as $article) {
            // Vider les anciens commentaires (optionnel)
            // Comment::where('post_id', $article->id)->delete();

            // Commentaires spécifiques pour chaque article
            $articleSpecificComments = $this->getArticleSpecificComments($article->title);

            // Ajouter les commentaires
            foreach ($articleSpecificComments as $commentData) {
                $user = $users->where('email', $commentData['user_email'])->first();
                
                if ($user) {
                    Comment::create([
                        'post_id' => $article->id,
                        'user_id' => $user->id,
                        'content' => $commentData['content'],
                        'status' => 'approved',
                        'ip_address' => '127.0.0.1',
                        'created_at' => Carbon::now()->subDays(rand(1, 14)),
                    ]);
                }
            }
        }

        $this->command->info('✅ Commentaires réalistes ajoutés aux articles AgroSpace!');
    }

    private function getArticleSpecificComments(string $articleTitle): array
    {
        if (str_contains($articleTitle, 'Révolution Digitale')) {
            return [
                [
                    'user_email' => 'samuel.kamga@example.com',
                    'content' => 'En tant qu\'agriculteur traditionnel, j\'étais sceptique au début. Mais après 2 mois sur AgroSpace, j\'ai découvert un marché que je ne connaissais pas : des restaurants qui veulent acheter directement du producteur. Le système est intuitif, même pour quelqu\'un qui n\'est pas très à l\'aise avec la technologie.',
                ],
                [
                    'user_email' => 'fatima.ngo@example.com',
                    'content' => 'Exactement ce dont j\'avais besoin ! Avant, je passais des heures à appeler différents fournisseurs. Maintenant, je vois directement les producteurs disponibles dans ma région, leurs produits, leurs prix. La transparence est totale. Mon restaurant a gagné en qualité et en authenticité.',
                ],
                [
                    'user_email' => 'marie.kouam@example.com',
                    'content' => 'Notre coopérative féminine a été parmi les premières à tester la plateforme. Les résultats sont impressionnants : 65% d\'augmentation de nos ventes en 3 mois ! Le système de messagerie intégré nous permet de négocier directement avec les acheteurs.',
                ],
                [
                    'user_email' => 'jean.mbarga@example.com',
                    'content' => 'Je gère une épicerie à Douala et j\'avais du mal à trouver des fournisseurs fiables en province. AgroSpace m\'a permis de créer des relations directes avec des producteurs de l\'Ouest. La qualité est meilleure et les prix plus compétitifs sans les intermédiaires.',
                ],
            ];
        }

        if (str_contains($articleTitle, 'Augmente les Revenus')) {
            return [
                [
                    'user_email' => 'samuel.kamga@example.com',
                    'content' => 'Les chiffres présentés sont exacts ! Avant AgroSpace, je vendais mon maïs à 300F/kg au grossiste. Maintenant, je le vends à 450F/kg directement au consommateur. Sur une récolte de 5 tonnes, ça fait une différence énorme. Je peux enfin investir dans du matériel d\'irrigation.',
                ],
                [
                    'user_email' => 'marie.kouam@example.com',
                    'content' => 'Notre coopérative de 15 femmes peut en témoigner : notre revenu mensuel est passé de 750.000 FCFA à 1,3 million en 6 mois. Ce n\'est pas juste une augmentation de revenu, c\'est une transformation de vie. Nous avons pu acheter un moulin et créer une unité de transformation.',
                ],
                [
                    'user_email' => 'fatima.ngo@example.com',
                    'content' => 'En tant qu\'acheteuse, je confirme que les prix sont plus justes. Avant, je payais 500F pour une botte de légumes qui valait réellement 300F. Maintenant, je paie 350F et le producteur reçoit 300F. Tout le monde y gagne, sauf les intermédiaires.',
                ],
                [
                    'user_email' => 'jean.mbarga@example.com',
                    'content' => 'Ma marge a légèrement diminué (de 40% à 25%), mais mon volume de vente a triplé. Au final, je gagne plus. Et mes clients sont ravis de la qualité et de la fraîcheur des produits. C\'est un modèle plus durable pour tout le monde.',
                ],
            ];
        }

        if (str_contains($articleTitle, 'Agriculture Durable')) {
            return [
                [
                    'user_email' => 'samuel.kamga@example.com',
                    'content' => 'L\'aspect environnemental est crucial. Avant, 20% de ma récolte pourrissait faute de débouchés. Maintenant, grâce à la planification sur AgroSpace, je ne produis que ce que je peux vendre. Moins de gaspillage, moins de ressources utilisées inutilement.',
                ],
                [
                    'user_email' => 'marie.kouam@example.com',
                    'content' => 'Notre coopérative a réduit de 80% ses pertes post-récolte. Mais surtout, nous avons diversifié nos cultures grâce aux retours des consommateurs sur la plateforme. Maintenant, nous pratiquons la rotation des cultures et l\'agroforesterie.',
                ],
                [
                    'user_email' => 'fatima.ngo@example.com',
                    'content' => 'Je suis fière de participer à cette chaîne de valeur durable. Mes clients apprécient de savoir d\'où viennent leurs aliments. Certains viennent même visiter les fermes de mes fournisseurs. C\'est un retour aux sources qui a du sens.',
                ],
                [
                    'user_email' => 'jean.mbarga@example.com',
                    'content' => 'Les circuits courts réduisent considérablement l\'empreinte carbone. Avant, les produits faisaient Yaoundé-Douala-Yaoundé-Douala avec plusieurs intermédiaires. Maintenant, c\'est producteur-épicerie-client. Simple, efficace, écologique.',
                ],
            ];
        }

        // Commentaires génériques pour les autres articles
        return [
            [
                'user_email' => 'samuel.kamga@example.com',
                'content' => 'Article très intéressant ! J\'applique déjà certaines de ces techniques dans ma ferme.',
            ],
            [
                'user_email' => 'fatima.ngo@example.com',
                'content' => 'Merci pour ces conseils pratiques. Je vais les partager avec mes fournisseurs.',
            ],
        ];
    }
}