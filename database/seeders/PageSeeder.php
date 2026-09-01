<?php

namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::query()->updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => SeedTranslatable::make('About Egyptra', 'عن إيجيبترا', 'О Egyptra'),
                'content' => SeedTranslatable::make(
                    '<p>Egyptra is a Cairo-based real estate company helping clients buy, rent, finish, and manage premium properties across Egypt.</p><p>Our team combines local market expertise with transparent advisory and end-to-end project delivery.</p>',
                    '<p>إيجيبترا شركة عقارية مقرها القاهرة تساعد العملاء على شراء وإيجار وتشطيب وإدارة العقارات المميزة في مصر.</p><p>يجمع فريقنا بين خبرة السوق المحلي والاستشارات الشفافة والتنفيذ المتكامل للمشاريع.</p>',
                    '<p>Egyptra — каирская компания, которая помогает покупать, сдавать, отделывать и управлять недвижимостью премиум-класса в Египте.</p><p>Мы сочетаем знание локального рынка с прозрачным консалтингом и реализацией проектов под ключ.</p>'
                ),
                'seo_title' => SeedTranslatable::make(
                    'About Egyptra | Real estate in Egypt',
                    'عن إيجيبترا | عقارات في مصر',
                    'О Egyptra | Недвижимость в Египте'
                ),
                'seo_description' => SeedTranslatable::make(
                    'Learn about Egyptra, your partner for property sales, rentals, finishing, and management in Greater Cairo.',
                    'تعرف على إيجيبترا شريكك في بيع وإيجار وتشطيب وإدارة العقارات في القاهرة الكبرى.',
                    'Узнайте больше о Egyptra — партнёре по недвижимости в Большом Каире.'
                ),
                'is_published' => true,
            ]
        );
    }
}
