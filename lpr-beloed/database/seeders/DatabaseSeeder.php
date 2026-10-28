<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Extra;
use App\Models\Tour;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Country::factory(3)->create();

        Extra::factory(3)->create();

        Tour::factory(5)->create()->each(function (Tour $tour) {
            $tour->extras()->attach(
                Extra::query()->inRandomOrder()->limit(2)->pluck('id')
            );
        });

    }
}