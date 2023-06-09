<?php

namespace Database\Factories;

use App\Enums\GeneralStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text,
            'description' => fake()->sentence(2),
            'status' => fake()->randomElement([
                GeneralStatusEnum::Active,
                GeneralStatusEnum::Inactive
            ]),
        ];
    }
}
