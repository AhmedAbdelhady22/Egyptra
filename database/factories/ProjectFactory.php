<?php

namespace Database\Factories;

use App\Models\Project;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    use MakesTranslations;

    protected $model = Project::class;

    public function definition(): array
    {
        $titleEn = fake()->words(3, true);

        return [
            'title' => $this->translations(
                ucfirst($titleEn),
                'مشروع سكني متميز',
                'Жилой проект премиум-класса'
            ),
            'slug' => $this->uniqueSlugTranslations($titleEn),
            'description' => $this->translations(
                fake()->paragraphs(2, true),
                'مشروع يجمع بين التصميم العصري والموقع الاستراتيجي.',
                'Современный проект в удобной локации.'
            ),
            'location' => $this->translations(
                'New Cairo, Egypt',
                'القاهرة الجديدة، مصر',
                'Новый Каир, Египет'
            ),
            'features' => $this->translations(
                '<ul><li>Landscape design</li><li>Clubhouse</li><li>Retail area</li></ul>',
                '<ul><li>تنسيق حدائق</li><li>نادي اجتماعي</li><li>منطقة تجارية</li></ul>',
                '<ul><li>Ландшафт</li><li>Клуб</li><li>Торговая зона</li></ul>'
            ),
            'completed_at' => fake()->dateTimeBetween('-3 years', '-3 months'),
            'featured_image' => null,
            'seo_title' => $this->translations(
                ucfirst($titleEn).' | Egyptra Projects',
                'مشاريع إيجيبترا',
                'Проекты Egyptra'
            ),
            'seo_description' => $this->translations(
                fake()->sentence(10),
                'استكشف مشاريعنا المنجزة في مصر.',
                'Реализованные проекты в Египте.'
            ),
            'og_image' => null,
            'is_published' => true,
        ];
    }
}
