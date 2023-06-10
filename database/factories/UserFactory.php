<?php

namespace Database\Factories;

use App\Models\Commune;
use App\Models\Region;
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
        $region = Region::inRandomOrder()->first();
        $commune = Commune::inRandomOrder()->first();

        return [
            'region_id' => $region->id,
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
