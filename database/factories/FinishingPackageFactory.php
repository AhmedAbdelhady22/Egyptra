<?php

namespace Database\Factories;

use App\Models\FinishingPackage;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FinishingPackage>
 */
class FinishingPackageFactory extends Factory
{
    use MakesTranslations;

    protected $model = FinishingPackage::class;

    public function definition(): array
    {
        $nameEn = fake()->words(2, true);

        return [
            'name' => $this->translations(
                ucfirst($nameEn),
                'باقة تشطيب',
                'Пакет отделки'
            ),
            'slug' => $this->uniqueSlugTranslations($nameEn),
            'description' => $this->translations(
                fake()->paragraph(),
                'تشطيبات عالية الجودة بمواد ممتازة وفريق محترف.',
                'Качественная отделка с проверенными материалами.'
            ),
            'features' => $this->translations(
                '<ul><li>Flooring</li><li>Painting</li><li>Kitchen setup</li></ul>',
                '<ul><li>أرضيات</li><li>دهانات</li><li>مطبخ</li></ul>',
                '<ul><li>Напольные покрытия</li><li>Покраска</li><li>Кухня</li></ul>'
            ),
            'price_per_sqm' => fake()->numberBetween(3_500, 18_000),
            'currency' => 'EGP',
            'featured_image' => null,
            'seo_title' => $this->translations(
                ucfirst($nameEn).' finishing | Egyptra',
                'باقات التشطيب | إيجيبترا',
                'Пакеты отделки | Egyptra'
            ),
            'seo_description' => $this->translations(
                fake()->sentence(10),
                'باقات تشطيب مرنة تناسب جميع الميزانيات.',
                'Гибкие пакеты отделки под ваш бюджет.'
            ),
            'og_image' => null,
            'is_featured' => fake()->boolean(30),
            'is_published' => true,
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }
}
