<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Demand>
 */
class DemandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'title' => $this->faker->text,
            'description' => $this->faker->text(100),
            'quantity' => $this->faker->numberBetween(1, 100),
            'city' => $this->faker->city,
            'region' => $this->faker->randomElement([
                'Adamaoua',
                'Centre',
                'Est',
                'Extrême-Nord',
                'Littoral',
                'Nord',
                'Nord-Ouest',
                'Ouest',
                'Sud',
                'Sud-Ouest'
            ]),
            'validity_date' => $this->faker->date(),
            'budget' => $this->faker->numberBetween(500, 10000),
            'views_count' => $this->faker->numberBetween(10, 50),
        ];
    }
}
