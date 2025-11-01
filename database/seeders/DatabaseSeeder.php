<?php

namespace Database\Seeders;

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
        ]);

        /*
        User::create(
            [
                'name' => 'rudiger',
                'email' => 'rudi@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role_id' => 1,
                'bio' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum est corrupti cumque rerum nulla, laborum alias nesciunt quibusdam eius amet vitae, molestiae illo nihil quo ab? Velit commodi dignissimos possimus in consequuntur? Esse mollitia facilis porro dolorem ab totam! Illum pariatur cupiditate asperiores rem officiis at libero eaque suscipit corrupti!',
                'location' => "Dschang, Cameroun",
                'activity' => 'Ingenieur Agropastorale',
            ]
        );
        */

        User::factory()->create([
            'email' => 'rudi@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::factory()->create([
            'email' => 'rudi1@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::factory(5)->hasOffers(10)->create();

        User::factory(5)->hasDemands(10)->create();
    }
}
