<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tour>
 */
class TourFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'title' => fake()->sentence(3),
            'start_date' => fake()->dateTimeBetween('+1 week', '+1 year')->format('Y-m-d'),
            'days' => fake()->numberBetween(3, 21),
            'price' => fake()->randomFloat(2, 10000, 500000),
            'is_hot' => fake()->boolean(25),
        ];
    }
}