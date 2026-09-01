<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'slug' => 'villa',
                'sort_order' => 1,
                'name' => SeedTranslatable::make('Villa', 'فيلا', 'Вилла'),
            ],
            [
                'slug' => 'chalet',
                'sort_order' => 2,
                'name' => SeedTranslatable::make('Chalet', 'شاليه', 'Шале'),
            ],
            [
                'slug' => 'studio',
                'sort_order' => 3,
                'name' => SeedTranslatable::make('Studio', 'استوديو', 'Студия'),
            ],
            [
                'slug' => 'commercial',
                'sort_order' => 4,
                'name' => SeedTranslatable::make('Commercial', 'تجاري', 'Коммерческая'),
            ],
        ];

        foreach ($types as $type) {
            PropertyType::query()->updateOrCreate(
                ['slug' => $type['slug']],
                [
                    'name' => $type['name'],
                    'sort_order' => $type['sort_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
