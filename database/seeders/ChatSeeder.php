<?php

// database/seeders/ChatSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        // Créer des utilisateurs de test
        $alice = User::factory()->create([
            'name' => 'Alice Agricultrice',
            'email' => 'alice@agrospace.test',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'bio' => 'Etude à la Fasa de la ville de Dschang',
            'location' => 'Douala, Cameroun',
            'activity' => 'ingenieur AgroPastorale',
        ]);

        $bob = User::factory()->create([
            'name' => 'Bob Producteur',
            'email' => 'bob@agrospace.test',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'bio' => 'Etude à la Fasa de la ville de Dschang',
            'location' => 'Douala, Cameroun',
            'activity' => 'ingenieur AgroPastorale',
        ]);

        $charlie = User::factory()->create([
            'name' => 'Charlie Acheteur',
            'email' => 'charlie@agrospace.test',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'bio' => 'Etude à la Fasa de la ville de Dschang',
            'location' => 'Douala, Cameroun',
            'activity' => 'ingenieur AgroPastorale',
        ]);

        // Conversation privée Alice <-> Bob
        $conv1 = Conversation::create(['type' => 'private']);
        $conv1->users()->attach([$alice->id, $bob->id]);

        Message::create([
            'conversation_id' => $conv1->id,
            'user_id' => $alice->id,
            'content' => 'Bonjour Bob, intéressé par vos tomates ?',
        ]);

        Message::create([
            'conversation_id' => $conv1->id,
            'user_id' => $bob->id,
            'content' => 'Oui Alice ! J\'ai 500kg disponibles cette semaine.',
        ]);

        // Conversation de groupe
        $convGroup = Conversation::create([
            'type' => 'group',
            'name' => 'Coopérative Locale',
        ]);
        $convGroup->users()->attach([$alice->id, $bob->id, $charlie->id]);

        Message::create([
            'conversation_id' => $convGroup->id,
            'user_id' => $charlie->id,
            'content' => 'Quelqu\'un a des pommes de terre bio ?',
        ]);

        $this->command->info('✅ Données de chat créées avec succès !');
    }
}
