<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Compound;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Compound>
 */
class CompoundFactory extends Factory
{
    use MakesTranslations;

    protected $model = Compound::class;

    public function definition(): array
    {
        $en = fake()->unique()->company().' Compound';

        return [
            'area_id' => Area::factory(),
            'name' => $this->translations($en, 'كمبوند '.fake()->word(), 'Комплекс '.$en),
            'slug' => Str::slug($en).'-'.fake()->unique()->numerify('###'),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
