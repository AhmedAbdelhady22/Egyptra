<?php

namespace Database\Factories;

use App\Enums\FurnishedType;
use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Models\Area;
use App\Models\City;
use App\Models\Compound;
use App\Models\Property;
use App\Models\PropertyType;
use Database\Factories\Concerns\MakesTranslations;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    use MakesTranslations;

    protected $model = Property::class;

    public function definition(): array
    {
        $listingType = fake()->randomElement(ListingType::cases());
        $titleEn = fake()->words(4, true);
        $slug = $this->uniqueSlugTranslations($titleEn);
        $price = $listingType === ListingType::Sale
            ? fake()->numberBetween(2_500_000, 25_000_000)
            : fake()->numberBetween(15_000, 120_000);

        return [
            'property_type_id' => PropertyType::factory(),
            'city_id' => City::factory(),
            'area_id' => Area::factory(),
            'compound_id' => null,
            'title' => $this->translations(
                ucfirst($titleEn),
                'عقار فاخر في القاهرة الجديدة',
                'Премиальная недвижимость в Каире'
            ),
            'slug' => $slug,
            'description' => $this->translations(
                fake()->paragraphs(2, true),
                'وصف تفصيلي للعقار مع إطلالة مميزة وخدمات متكاملة.',
                'Подробное описание объекта с отличной планировкой и инфраструктурой.'
            ),
            'features' => $this->translations(
                '<ul><li>Private garden</li><li>Covered parking</li><li>24/7 security</li></ul>',
                '<ul><li>حديقة خاصة</li><li>موقف سيارات</li><li>أمن على مدار الساعة</li></ul>',
                '<ul><li>Частный сад</li><li>Парковка</li><li>Охрана 24/7</li></ul>'
            ),
            'listing_type' => $listingType,
            'price' => $price,
            'currency' => 'EGP',
            'property_area_sqm' => fake()->randomFloat(2, 85, 450),
            'bedrooms' => fake()->numberBetween(1, 5),
            'bathrooms' => fake()->numberBetween(1, 4),
            'floor' => (string) fake()->numberBetween(0, 12),
            'furnished' => fake()->randomElement(FurnishedType::cases()),
            'status' => PropertyStatus::Available,
            'google_maps_url' => fake()->optional()->url(),
            'latitude' => fake()->latitude(29.9, 30.2),
            'longitude' => fake()->longitude(31.2, 31.6),
            'featured_image' => null,
            'seo_title' => $this->translations(
                ucfirst($titleEn).' | Egyptra',
                'عقار للبيع في مصر | إيجيبترا',
                'Недвижимость в Египте | Egyptra'
            ),
            'seo_description' => $this->translations(
                fake()->sentence(12),
                'اكتشف أفضل العقارات في القاهرة والساحل الشمالي مع إيجيبترا.',
                'Лучшие объекты недвижимости в Египте с Egyptra.'
            ),
            'og_image' => null,
            'is_featured' => fake()->boolean(25),
            'is_published' => true,
            'published_at' => now()->subDays(fake()->numberBetween(1, 60)),
        ];
    }

    public function forLocation(City $city, Area $area, ?Compound $compound = null): static
    {
        return $this->state(fn (): array => [
            'city_id' => $city->id,
            'area_id' => $area->id,
            'compound_id' => $compound?->id,
        ]);
    }
}
