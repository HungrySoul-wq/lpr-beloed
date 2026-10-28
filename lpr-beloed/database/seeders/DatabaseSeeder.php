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
        $countries = [
            'Турция',
            'Египет',
            'Таиланд',
            'ОАЭ',
            'Китай',
            'Италия',
            'Испания',
            'Грузия',
            'Мальдивы',
            'Вьетнам',
        ];

        foreach ($countries as $name) {
            Country::firstOrCreate(
                ['name' => $name],
                ['visa_required' => in_array($name, ['Китай', 'Италия', 'Испания'])]
            );
        }

        $extraNames = [
            'Трансфер из аэропорта',
            'Медицинская страховка',
            'Экскурсионная программа',
        ];

        foreach ($extraNames as $name) {
            Extra::firstOrCreate(['name' => $name]);
        }

        $tourData = [
            ['title' => 'Отдых на побережье Антальи', 'country' => 'Турция', 'days' => 7, 'price' => 185000, 'hot' => true],
            ['title' => 'Путешествие к пирамидам', 'country' => 'Египет', 'days' => 8, 'price' => 220000, 'hot' => false],
            ['title' => 'Тропический отдых в Пхукете', 'country' => 'Таиланд', 'days' => 10, 'price' => 320000, 'hot' => true],
            ['title' => 'Роскошный отдых в Дубае', 'country' => 'ОАЭ', 'days' => 6, 'price' => 275000, 'hot' => false],
            ['title' => 'Знакомство с Пекином', 'country' => 'Китай', 'days' => 9, 'price' => 240000, 'hot' => false],
            ['title' => 'Итальянские каникулы', 'country' => 'Италия', 'days' => 7, 'price' => 350000, 'hot' => true],
            ['title' => 'Пляжи и города Испании', 'country' => 'Испания', 'days' => 8, 'price' => 330000, 'hot' => false],
            ['title' => 'Отдых в гостеприимной Грузии', 'country' => 'Грузия', 'days' => 5, 'price' => 160000, 'hot' => false],
            ['title' => 'Неделя на Мальдивах', 'country' => 'Мальдивы', 'days' => 7, 'price' => 480000, 'hot' => true],
            ['title' => 'Приключение во Вьетнаме', 'country' => 'Вьетнам', 'days' => 10, 'price' => 290000, 'hot' => false],
        ];

        $extras = Extra::query()->pluck('id')->all();

        foreach ($tourData as $index => $data) {
            $tour = Tour::updateOrCreate(
                ['title' => $data['title']],
                [
                    'country_id' => Country::where('name', $data['country'])->value('id'),
                    'start_date' => now()->addDays(30 + $index * 14)->toDateString(),
                    'days' => $data['days'],
                    'price' => $data['price'],
                    'is_hot' => $data['hot'],
                ]
            );

            if ($extras !== []) {
                $tour->extras()->sync(array_slice($extras, 0, 2));
            }
        }
    }
}