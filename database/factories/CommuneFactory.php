<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commune>
 */
class CommuneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $region = Region::inRandomOrder()->first();

        return [
            'region_id' => $region->id,
            'name' => fake()->city,
            'description' => fake()->sentence(2),
            'status' => fake()->randomElement(['A', 'I', 'trash']),
        ];
    }
}
