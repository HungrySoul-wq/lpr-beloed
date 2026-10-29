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
        // PARENTS = 3
        $countries = Country::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Турция', 'visa_required' => false],
                ['name' => 'Египет', 'visa_required' => false],
                ['name' => 'Таиланд', 'visa_required' => true],
            )
            ->create();

        // Дополнительные услуги (связь «многие-ко-многим», задание повышенного уровня)
        $extras = collect([
            'Трансфер из аэропорта',
            'Медицинская страховка',
            'Экскурсионная программа',
        ])->map(fn (string $name) => Extra::create(['name' => $name]));

        // SEED = 18
        Tour::factory()
            ->count(18)
            ->recycle($countries)          // только созданные страны
            ->create()
            ->each(fn (Tour $tour) => $tour->extras()->attach(
                $extras->random(rand(1, 2))->pluck('id')->all()
            ));
    }
}
