<?php

namespace Database\Factories;

use App\Models\Commune;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commune = Commune::inRandomOrder()->first();

        return [
            'commune_id' => $commune->id,
            'dni' => Str::random(10),
            'name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'address' => fake()->address,
            'email' => fake()->unique()->safeEmail,
            'password' => 'password', // You may adjust this as needed
            'status' => fake()->randomElement(['A', 'I', 'trash']),
        ];
    }
}
