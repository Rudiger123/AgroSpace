<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->text(15);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'icon' => "🌾",
            'color' => "#f59e0b",
            'description' => $this->faker->text(50),
            'is_active' => true,
            'type' => $this->faker->randomElement(['post', 'offer', 'demand'])
        ];
    }
}
