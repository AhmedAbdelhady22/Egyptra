<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\City;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Area>
 */
class AreaFactory extends Factory
{
    use MakesTranslations;

    protected $model = Area::class;

    public function definition(): array
    {
        $en = fake()->unique()->streetName();

        return [
            'city_id' => City::factory(),
            'name' => $this->translations($en, 'منطقة '.fake()->word(), 'Район '.$en),
            'slug' => Str::slug($en).'-'.fake()->unique()->numerify('###'),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
