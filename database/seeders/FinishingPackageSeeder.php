<?php

namespace Database\Seeders;

use App\Models\FinishingPackage;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class FinishingPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'slug' => SeedTranslatable::make('basic', 'basic-ar', 'basic-ru'),
                'price' => 4500,
                'sort' => 1,
                'name' => SeedTranslatable::make('Basic', 'أساسي', 'Базовый'),
                'description' => SeedTranslatable::make(
                    'Essential finishes for rental-ready units with durable materials and clear scope.',
                    'تشطيبات أساسية للوحدات الجاهزة للإيجار بمواد متينة ونطاق عمل واضح.',
                    'Базовая отделка для сдачи в аренду с надёжными материалами и чётким объёмом работ.'
                ),
            ],
            [
                'slug' => SeedTranslatable::make('standard', 'standard-ar', 'standard-ru'),
                'price' => 7200,
                'sort' => 2,
                'name' => SeedTranslatable::make('Standard', 'ستاندارد', 'Стандарт'),
                'description' => SeedTranslatable::make(
                    'Balanced specification with upgraded flooring, kitchen, and bathroom fittings.',
                    'مواصفات متوازنة مع أرضيات ومطبخ وحمامات بمستوى أعلى.',
                    'Сбалансированная комплектация с улучшенными полами, кухней и санузлами.'
                ),
            ],
            [
                'slug' => SeedTranslatable::make('premium', 'premium-ar', 'premium-ru'),
                'price' => 10500,
                'sort' => 3,
                'name' => SeedTranslatable::make('Premium', 'بريميوم', 'Премиум'),
                'description' => SeedTranslatable::make(
                    'Tailored finishing scope with transparent BOQ and milestone-based payments.',
                    'نطاق تشطيب واضح مع جدول دفعات حسب مراحل التنفيذ.',
                    'Прозрачная смета и поэтапная оплата работ.'
                ),
            ],
            [
                'slug' => SeedTranslatable::make('luxury', 'luxury-ar', 'luxury-ru'),
                'price' => 15000,
                'sort' => 4,
                'name' => SeedTranslatable::make('Luxury', 'فاخر', 'Люкс'),
                'description' => SeedTranslatable::make(
                    'High-end materials, custom joinery, and dedicated project manager throughout.',
                    'مواد فاخرة ونجارة مخصصة ومدير مشروع مخصص طوال التنفيذ.',
                    'Премиальные материалы, мебель на заказ и персональный менеджер проекта.'
                ),
            ],
        ];

        foreach ($packages as $index => $package) {
            FinishingPackage::query()->updateOrCreate(
                ['slug->en' => $package['slug']['en']],
                [
                    'name' => $package['name'],
                    'slug' => $package['slug'],
                    'description' => $package['description'],
                    'features' => SeedTranslatable::make(
                        '<ul><li>Material options catalog</li><li>Supervision visits</li><li>Warranty</li></ul>',
                        '<ul><li>كتالوج مواد</li><li>زيارات إشراف</li><li>ضمان</li></ul>',
                        '<ul><li>Каталог материалов</li><li>Надзор</li><li>Гарантия</li></ul>'
                    ),
                    'price_per_sqm' => $package['price'],
                    'currency' => 'EGP',
                    'is_featured' => $index >= 2,
                    'is_published' => true,
                    'sort_order' => $package['sort'],
                ]
            );
        }
    }
}
