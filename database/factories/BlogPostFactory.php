<?php

namespace Database\Factories;

use App\Enums\PublishStatus;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    use MakesTranslations;

    protected $model = BlogPost::class;

    public function definition(): array
    {
        $titleEn = fake()->sentence(6);

        return [
            'blog_category_id' => BlogCategory::factory(),
            'title' => $this->translations(
                $titleEn,
                'دليلك لشراء عقار في مصر',
                'Гид по покупке недвижимости в Египте'
            ),
            'slug' => $this->uniqueSlugTranslations($titleEn),
            'content' => $this->translations(
                '<p>'.fake()->paragraphs(4, true).'</p>',
                '<p>نصائح عملية للمشترين والمستثمرين في السوق المصري.</p>',
                '<p>Практические советы для покупателей и инвесторов.</p>'
            ),
            'featured_image' => null,
            'seo_title' => $this->translations(
                $titleEn.' | Egyptra Blog',
                'مدونة إيجيبترا',
                'Блог Egyptra'
            ),
            'seo_description' => $this->translations(
                fake()->sentence(12),
                'آخر أخبار ونصائح العقارات في مصر.',
                'Новости и советы о недвижимости в Египте.'
            ),
            'og_image' => null,
            'status' => PublishStatus::Published,
            'published_at' => now()->subDays(fake()->numberBetween(1, 90)),
        ];
    }
}
