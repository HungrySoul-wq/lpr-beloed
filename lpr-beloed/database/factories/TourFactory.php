<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tour>
 */
class TourFactory extends Factory
{
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 week', '+1 year');
        $type = fake()->randomElement([
            'Пляжный отдых',
            'Экскурсионный тур',
            'Семейный отдых',
            'Романтическая поездка',
            'Активный отдых',
            'Гастрономический тур',
        ]);

        return [
            'country_id'  => Country::factory(),
            'title'       => $type . ', ' . Carbon::instance($start)->translatedFormat('F Y'),
            'description' => fake()->optional()->realText(120),
            'start_date'  => $start->format('Y-m-d'),
            'days'        => fake()->numberBetween(3, 21),
            'price'       => fake()->randomFloat(2, 15000, 250000),
            'is_hot'      => fake()->boolean(25),
        ];
    }
}
