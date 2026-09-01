<?php

namespace Database\Seeders;

use App\Enums\PublishStatus;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $marketInsights = BlogCategory::query()->updateOrCreate(
            ['slug->en' => 'market-insights'],
            [
                'name' => SeedTranslatable::make('Market Insights', 'رؤى السوق', 'Аналитика рынка'),
                'slug' => SeedTranslatable::make('market-insights', 'market-insights-ar', 'market-insights-ru'),
            ]
        );

        $buyingGuides = BlogCategory::query()->updateOrCreate(
            ['slug->en' => 'buying-guides'],
            [
                'name' => SeedTranslatable::make('Buying Guides', 'أدلة الشراء', 'Гиды по покупке'),
                'slug' => SeedTranslatable::make('buying-guides', 'buying-guides-ar', 'buying-guides-ru'),
            ]
        );

        $posts = [
            [
                'category' => $marketInsights,
                'slug' => SeedTranslatable::make('cairo-property-market-2026', 'cairo-property-market-2026-ar', 'cairo-property-market-2026-ru'),
                'title' => SeedTranslatable::make(
                    'Cairo property market outlook for 2026',
                    'توقعات سوق العقارات في القاهرة لعام 2026',
                    'Прогноз рынка недвижимости Каира на 2026 год'
                ),
            ],
            [
                'category' => $buyingGuides,
                'slug' => SeedTranslatable::make('first-time-buyer-checklist', 'first-time-buyer-checklist-ar', 'first-time-buyer-checklist-ru'),
                'title' => SeedTranslatable::make(
                    'First-time buyer checklist in Egypt',
                    'قائمة تحقق للمشترين لأول مرة في مصر',
                    'Чек-лист для первой покупки в Египте'
                ),
            ],
            [
                'category' => $marketInsights,
                'slug' => SeedTranslatable::make('new-cairo-price-trends', 'new-cairo-price-trends-ar', 'new-cairo-price-trends-ru'),
                'title' => SeedTranslatable::make(
                    'New Cairo price trends and demand drivers',
                    'اتجاهات الأسعار في القاهرة الجديدة',
                    'Динамика цен в Новом Каире'
                ),
            ],
            [
                'category' => $buyingGuides,
                'slug' => SeedTranslatable::make('rent-vs-buy-cairo', 'rent-vs-buy-cairo-ar', 'rent-vs-buy-cairo-ru'),
                'title' => SeedTranslatable::make(
                    'Rent vs buy: what makes sense in Cairo today',
                    'الإيجار أم الشراء: ما الأنسب في القاهرة اليوم',
                    'Аренда или покупка: что выгоднее в Каире'
                ),
            ],
            [
                'category' => $marketInsights,
                'slug' => SeedTranslatable::make('finishing-costs-egypt', 'finishing-costs-egypt-ar', 'finishing-costs-egypt-ru'),
                'title' => SeedTranslatable::make(
                    'How finishing costs are calculated in Egypt',
                    'كيف تُحسب تكاليف التشطيب في مصر',
                    'Как рассчитывается стоимость отделки в Египте'
                ),
            ],
        ];

        foreach ($posts as $index => $post) {
            BlogPost::query()->updateOrCreate(
                ['slug->en' => $post['slug']['en']],
                [
                    'blog_category_id' => $post['category']->id,
                    'title' => $post['title'],
                    'slug' => $post['slug'],
                    'content' => SeedTranslatable::make(
                        '<p>'.str_repeat('Practical insights for property owners and investors. ', 8).'</p>',
                        '<p>'.str_repeat('نصائح عملية للملاك والمستثمرين في السوق المصري. ', 8).'</p>',
                        '<p>'.str_repeat('Практические рекомендации для владельцев и инвесторов. ', 8).'</p>'
                    ),
                    'status' => PublishStatus::Published,
                    'published_at' => now()->subDays(30 - ($index * 5)),
                ]
            );
        }
    }
}
