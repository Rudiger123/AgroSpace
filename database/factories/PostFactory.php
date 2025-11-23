<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->text;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' =>  $this->faker->sentence,
            'content' =>  $this->faker->sentence(100, 15),
            'author_id' => User::where('role_id', 1)->inRandomOrder()->first()->id,
            'category_id' => random_int(1, 4),
            'published' => true,
            'published_at' => now()->subDays(rand(1, 30)),
            'views_count' => rand(100, 5000),
            'likes_count' => rand(10, 500),
            'comments_count' => rand(0, 50),
        ];
    }
}
