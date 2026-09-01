<?php

namespace Database\Factories;

use App\Models\Service;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    use MakesTranslations;

    protected $model = Service::class;

    public function definition(): array
    {
        $nameEn = fake()->words(3, true);

        return [
            'name' => $this->translations(
                ucfirst($nameEn),
                'خدمة '.fake()->word(),
                'Услуга '.ucfirst($nameEn)
            ),
            'slug' => $this->uniqueSlugTranslations($nameEn),
            'description' => $this->translations(
                fake()->paragraph(),
                'نقدم حلولاً متكاملة لإدارة العقارات والتشطيبات.',
                'Комплексные решения для недвижимости и отделки.'
            ),
            'features' => $this->translations(
                '<ul><li>Consultation</li><li>Site visits</li><li>After-sales support</li></ul>',
                '<ul><li>استشارات</li><li>معاينات</li><li>دعم ما بعد البيع</li></ul>',
                '<ul><li>Консультации</li><li>Выезды</li><li>Поддержка</li></ul>'
            ),
            'price_info' => $this->translations(
                'Custom quote based on property size',
                'عرض سعر حسب مساحة العقار',
                'Индивидуальный расчёт по площади'
            ),
            'featured_image' => null,
            'seo_title' => $this->translations(
                ucfirst($nameEn).' | Egyptra Services',
                'خدمات إيجيبترا',
                'Услуги Egyptra'
            ),
            'seo_description' => $this->translations(
                fake()->sentence(10),
                'خدمات عقارية احترافية في مصر.',
                'Профессиональные услуги в Египте.'
            ),
            'og_image' => null,
            'is_published' => true,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
