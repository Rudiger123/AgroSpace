<?php

namespace Database\Factories;

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
            'product' => $this->faker->text(5),
            'description' => $this->faker->text(50),
            'category' => $this->faker->colorName(),
            'quantity' => $this->faker->numberBetween(500, 100000),
            'region' => $this->faker->streetName(),
            'contact' => $this->faker->phoneNumber(),
        ];
    }
}
