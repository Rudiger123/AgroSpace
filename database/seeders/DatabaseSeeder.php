<?php

namespace Database\Seeders;

use App\Models\Avis;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\DemandResponse;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            RealUsersSeeder::class,
            CategorySeeder::class,
            BlogSeeder::class,
            // NewsletterSuscriberSeeder::class
        ]);

        // User::factory()->hasOffers(10)->create([
        //     'email' => 'rudi@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 2
        // ]);

        // User::factory(5)->hasOffers(10)->create([
        //     'role_id' => 2
        // ]);

        // User::factory()->hasDemands(10)->create([
        //     'email' => 'rudi1@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 3
        // ]);

        // User::factory()->create([
        //     'email' => 'rudi2@gmail.com',
        //     'password' => Hash::make('password'),
        //     'role_id' => 1
        // ]);


        // User::factory(5)->hasDemands(10)->create([
        //     'role_id' => 3
        // ]);

        // Post::factory(50)->create();
        // Avis::factory(50)->create();
        // DemandResponse::factory(30)->create();
        // Comment::factory(50)->create();

        // $contacts = [
        //     [
        //         'name' => 'Jean Dupont',
        //         'email' => 'jean.dupont@example.com',
        //         'subject' => 'Question sur les fonctionnalités',
        //         'message' => 'Bonjour, je souhaiterais en savoir plus sur les fonctionnalités de gestion des parcelles. Pouvez-vous m\'aider ?',
        //         'status' => 'new',
        //     ],
        //     [
        //         'name' => 'Marie Martin',
        //         'email' => 'marie.martin@example.com',
        //         'subject' => 'Problème de connexion',
        //         'message' => 'Je n\'arrive pas à me connecter à mon compte. Pouvez-vous vérifier ?',
        //         'status' => 'opened',
        //     ],
        //     [
        //         'name' => 'Pierre Durand',
        //         'email' => 'pierre.durand@example.com',
        //         'subject' => 'Demande de démo',
        //         'message' => 'Bonjour, je suis intéressé par une démonstration de votre plateforme. Quand êtes-vous disponible ?',
        //         'status' => 'replied',
        //         'reply_message' => 'Bonjour Pierre, nous serions ravis de vous faire une démonstration. Nous sommes disponibles cette semaine les mardis et jeudis après-midi.',
        //         'replied_at' => now()->subDays(2),
        //         'replied_by' => 1,
        //     ],
        //     [
        //         'name' => 'Sophie Bernard',
        //         'email' => 'sophie.bernard@example.com',
        //         'subject' => 'Tarifs et abonnements',
        //         'message' => 'Quels sont vos différents plans tarifaires ? Y a-t-il un essai gratuit ?',
        //         'status' => 'new',
        //     ],
        //     [
        //         'name' => 'Luc Petit',
        //         'email' => 'luc.petit@example.com',
        //         'subject' => 'Intégration API',
        //         'message' => 'Est-il possible d\'intégrer votre solution avec notre système existant via API ?',
        //         'status' => 'closed',
        //     ],
        // ];

        // foreach ($contacts as $contact) {
        //     Contact::create($contact);
        // }
    }
}
