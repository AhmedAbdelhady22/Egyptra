<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use App\Models\Compound;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $cairo = City::query()->updateOrCreate(
            ['slug' => 'cairo'],
            [
                'name' => SeedTranslatable::make('Cairo', 'القاهرة', 'Каир'),
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        City::query()->updateOrCreate(
            ['slug' => 'new-capital'],
            [
                'name' => SeedTranslatable::make('New Capital', 'العاصمة الإدارية', 'Новая столица'),
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        City::query()->updateOrCreate(
            ['slug' => 'north-coast'],
            [
                'name' => SeedTranslatable::make('North Coast', 'الساحل الشمالي', 'Северное побережье'),
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        City::query()->updateOrCreate(
            ['slug' => 'sheikh-zayed'],
            [
                'name' => SeedTranslatable::make('Sheikh Zayed', 'الشيخ زايد', 'Шейх Зayed'),
                'sort_order' => 4,
                'is_active' => true,
            ]
        );

        $newCairo = Area::query()->updateOrCreate(
            ['city_id' => $cairo->id, 'slug' => 'new-cairo'],
            [
                'name' => SeedTranslatable::make('New Cairo', 'القاهرة الجديدة', 'Новый Каир'),
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $maadi = Area::query()->updateOrCreate(
            ['city_id' => $cairo->id, 'slug' => 'maadi'],
            [
                'name' => SeedTranslatable::make('Maadi', 'المعادي', 'Маади'),
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $newCairoCompounds = [
            ['slug' => 'madinaty', 'name' => SeedTranslatable::make('Madinaty', 'مدينتي', 'Мадинати')],
            ['slug' => 'cairo-festival-city', 'name' => SeedTranslatable::make('Cairo Festival City', 'كايرو فستيفال سيتي', 'Cairo Festival City')],
            ['slug' => 'katameya-heights', 'name' => SeedTranslatable::make('Katameya Heights', 'قطامية هايتس', 'Katameya Heights')],
        ];

        foreach ($newCairoCompounds as $index => $compound) {
            Compound::query()->updateOrCreate(
                ['area_id' => $newCairo->id, 'slug' => $compound['slug']],
                [
                    'name' => $compound['name'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $maadiCompounds = [
            ['slug' => 'degla', 'name' => SeedTranslatable::make('Degla', 'دجلة', 'Дегла')],
            ['slug' => 'suncity', 'name' => SeedTranslatable::make('Suncity', 'صن سيتي', 'Suncity')],
        ];

        foreach ($maadiCompounds as $index => $compound) {
            Compound::query()->updateOrCreate(
                ['area_id' => $maadi->id, 'slug' => $compound['slug']],
                [
                    'name' => $compound['name'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
