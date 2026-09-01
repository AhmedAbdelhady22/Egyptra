<?php

namespace Database\Seeders;

use App\Models\Project;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'slug' => SeedTranslatable::make('palm-residence-new-cairo', 'palm-residence-new-cairo-ar', 'palm-residence-new-cairo-ru'),
                'title' => SeedTranslatable::make('Palm Residence New Cairo', 'بالم ريزيدنس القاهرة الجديدة', 'Palm Residence Новый Каир'),
                'completed_at' => '2024-06-15',
            ],
            [
                'slug' => SeedTranslatable::make('maadi-gardens-complex', 'maadi-gardens-complex-ar', 'maadi-gardens-complex-ru'),
                'title' => SeedTranslatable::make('Maadi Gardens Complex', 'مجمع حدائق المعادي', 'Комплекс Maadi Gardens'),
                'completed_at' => '2023-11-20',
            ],
            [
                'slug' => SeedTranslatable::make('cfc-business-hub', 'cfc-business-hub-ar', 'cfc-business-hub-ru'),
                'title' => SeedTranslatable::make('CFC Business Hub', 'مركز أعمال كايرو فستيفال', 'Деловой центр CFC'),
                'completed_at' => '2025-02-01',
            ],
        ];

        foreach ($projects as $project) {
            Project::query()->updateOrCreate(
                ['slug->en' => $project['slug']['en']],
                [
                    'title' => $project['title'],
                    'slug' => $project['slug'],
                    'description' => SeedTranslatable::make(
                        'A delivered project showcasing Egyptra quality standards from concept to handover.',
                        'مشروع منجز يعكس معايير جودة إيجيبترا من التصميم حتى التسليم.',
                        'Реализованный проект, демонстрирующий стандарты качества Egyptra.'
                    ),
                    'location' => SeedTranslatable::make(
                        'Greater Cairo, Egypt',
                        'القاهرة الكبرى، مصر',
                        'Большой Каир, Египет'
                    ),
                    'features' => SeedTranslatable::make(
                        '<ul><li>Turnkey delivery</li><li>Energy-efficient systems</li><li>Community amenities</li></ul>',
                        '<ul><li>تسليم متكامل</li><li>أنظمة موفرة للطاقة</li><li>مرافق مجتمعية</li></ul>',
                        '<ul><li>Под ключ</li><li>Энергоэффективные системы</li><li>Инфраструктура</li></ul>'
                    ),
                    'completed_at' => $project['completed_at'],
                    'is_published' => true,
                ]
            );
        }
    }
}
