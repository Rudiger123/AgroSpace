<?php

namespace Database\Factories;

use App\Models\Demand;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DemandResponse>
 */
class DemandResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('role_id', 2)->orWhere('role_id', 1)->inRandomOrder()->first();
        return [
            'demand_id' => Demand::inRandomOrder()->first()->id,
            'user_id' => $user->id,
            'message' => $this->faker->sentence(20),
            'proposed_price' => $this->faker->numberBetween(1000, 100000),
            'contact_phone' => $user->phone,
            'contact_email' => $user->email,
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected'])
        ];
    }
}
