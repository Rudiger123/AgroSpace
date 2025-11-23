<?php

namespace Database\Factories;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Avis>
 */
class AvisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producer_id' => User::where('role_id', 2)->inRandomOrder()->first()->id,
            'consumer_id' => User::where('role_id', 2)->inRandomOrder()->first()->id,
            'offer_id' => Offer::inRandomOrder()->first()->id,
            'note' => $this->faker->numberBetween(1, 5),
            'commentaire' => $this->faker->sentence(20, 13),
            'is_verified' => $this->faker->boolean,
            'is_visible' => $this->faker->boolean,
            'date_creation' => $this->faker->date,
        ];
    }
}
