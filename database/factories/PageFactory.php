<?php

namespace Database\Factories;

use App\Models\Page;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    use MakesTranslations;

    protected $model = Page::class;

    public function definition(): array
    {
        $titleEn = fake()->words(2, true);

        return [
            'slug' => Str::slug($titleEn).'-'.fake()->unique()->numerify('###'),
            'title' => $this->translations(
                ucfirst($titleEn),
                'صفحة '.fake()->word(),
                'Страница '.ucfirst($titleEn)
            ),
            'content' => $this->translations(
                '<p>'.fake()->paragraphs(3, true).'</p>',
                '<p>محتوى الصفحة باللغة العربية.</p>',
                '<p>Содержание страницы на русском языке.</p>'
            ),
            'seo_title' => $this->translations(
                ucfirst($titleEn).' | Egyptra',
                'إيجيبترا',
                'Egyptra'
            ),
            'seo_description' => $this->translations(
                fake()->sentence(10),
                'تعرف على إيجيبترا.',
                'О компании Egyptra.'
            ),
            'og_image' => null,
            'is_published' => true,
        ];
    }
}
