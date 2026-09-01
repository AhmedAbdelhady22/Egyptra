<?php

namespace Database\Factories;

use App\Models\PropertyType;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PropertyType>
 */
class PropertyTypeFactory extends Factory
{
    use MakesTranslations;

    protected $model = PropertyType::class;

    public function definition(): array
    {
        $en = fake()->unique()->words(2, true);

        return [
            'name' => $this->translations(
                ucfirst($en),
                'نوع '.fake()->word(),
                'Тип '.Str::slug($en, ' ')
            ),
            'slug' => Str::slug($en).'-'.fake()->unique()->numerify('###'),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
