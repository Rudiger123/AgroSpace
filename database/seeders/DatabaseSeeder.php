<?php

namespace Database\Seeders;

use App\Models\Avis;
use App\Models\Comment;
use App\Models\DemandResponse;
use App\Models\Post;
use App\Models\User;
use Database\Factories\CategoryFactory;
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
            CategorySeeder::class,
            BlogSeeder::class,
            NewsletterSuscriberSeeder::class
        ]);
        

        User::factory()->hasOffers(10)->create([
            'email' => 'rudi@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2
        ]);

        User::factory(5)->hasOffers(10)->create([
            'role_id' => 2
        ]);

        User::factory()->hasDemands(10)->create([
            'email' => 'rudi1@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3
        ]);

        User::factory()->create([
            'email' => 'rudi2@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);


        User::factory(5)->hasDemands(10)->create([
            'role_id' => 3
        ]);

        Post::factory(50)->create();
        Avis::factory(50)->create();
        DemandResponse::factory(30)->create();
        Comment::factory(50)->create();
    }
}
