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
            'titre' => $this->faker->text(5),
            'description' => $this->faker->text(50),
            'category_id' => 1,
            'prix' => $this->faker->numberBetween(2000, 500000),
            'region' => $this->faker->country(),
            'contact' => $this->faker->phoneNumber(),
            'quantite' => $this->faker->numberBetween(100, 1000),
            'unite' => 'kg',
            'localisation' => 'Douala, Littoral',
            'ville' => $this->faker->city(),
            'date_publication' => now(),
            'statut' => 'en attente',
            'contact' => $this->faker->phoneNumber(),
        ];
    }
}
