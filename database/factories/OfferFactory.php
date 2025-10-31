<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(5),
            'description' => $this->faker->text(50),
            'category' => $this->faker->colorName(),
            'price' => $this->faker->numberBetween(2000, 500000),
            'region' => $this->faker->country(),
            'contact' => $this->faker->e164PhoneNumber(),
        ];
    }
}
