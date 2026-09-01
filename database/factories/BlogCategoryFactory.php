<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BlogCategory>
 */
class BlogCategoryFactory extends Factory
{
    use MakesTranslations;

    protected $model = BlogCategory::class;

    public function definition(): array
    {
        $nameEn = fake()->unique()->words(2, true);

        return [
            'name' => $this->translations(
                ucfirst($nameEn),
                'تصنيف '.fake()->word(),
                'Категория '.ucfirst($nameEn)
            ),
            'slug' => $this->uniqueSlugTranslations($nameEn),
        ];
    }
}
