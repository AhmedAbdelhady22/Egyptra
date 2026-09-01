<?php

namespace Database\Factories;

use App\Models\City;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    use MakesTranslations;

    protected $model = City::class;

    public function definition(): array
    {
        $en = fake()->unique()->city();

        return [
            'name' => $this->translations($en, 'مدينة '.fake()->word(), 'Город '.$en),
            'slug' => Str::slug($en).'-'.fake()->unique()->numerify('###'),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
