<?php

namespace Database\Factories;

use App\Models\Category;
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
            'titre' => $this->faker->text,
            'description' => $this->faker->text(50),
            'category_id' => Category::inRandomOrder()->first()->id,
            'prix' => $this->faker->numberBetween(2000, 500000),
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
            'contact' => $this->faker->phoneNumber(),
            'quantite' => $this->faker->numberBetween(100, 1000),
            'unite' => 'kg',
            'localisation' => 'Douala, Littoral',
            'ville' => $this->faker->city(),
            'date_publication' => now(),
            'statut' => $this->faker->randomElement(['validé', 'expirée', 'vendue', 'suspendue', 'en attente', 'rejeté']),
            'contact' => $this->faker->phoneNumber(),
        ];
    }
}
