<?php

namespace Database\Seeders;

use App\Enums\FurnishedType;
use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Models\Area;
use App\Models\City;
use App\Models\Compound;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use Database\Seeders\Concerns\GeneratesPlaceholderImages;
use Database\Seeders\Concerns\SeedTranslatable;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    use GeneratesPlaceholderImages;

    public function run(): void
    {
        $cairo = City::query()->where('slug', 'cairo')->firstOrFail();
        $newCairo = Area::query()->where('slug', 'new-cairo')->where('city_id', $cairo->id)->firstOrFail();
        $maadi = Area::query()->where('slug', 'maadi')->where('city_id', $cairo->id)->firstOrFail();

        $compounds = Compound::query()
            ->whereIn('area_id', [$newCairo->id, $maadi->id])
            ->get()
            ->keyBy('slug');

        $types = PropertyType::query()->get()->keyBy('slug');

        $properties = [
            [
                'type' => 'villa',
                'area' => $newCairo,
                'compound' => 'madinaty',
                'listing' => ListingType::Sale,
                'price' => 18500000,
                'sqm' => 380,
                'beds' => 5,
                'baths' => 4,
                'title' => SeedTranslatable::make(
                    'Standalone villa with private garden in Madinaty',
                    'فيلا مستقلة بحديقة خاصة في مدينتي',
                    'Отдельная вилла с садом в Madinaty'
                ),
                'slug' => SeedTranslatable::make('madinaty-standalone-villa', 'madinaty-standalone-villa-ar', 'madinaty-standalone-villa-ru'),
            ],
            [
                'type' => 'villa',
                'area' => $newCairo,
                'compound' => 'katameya-heights',
                'listing' => ListingType::Sale,
                'price' => 32000000,
                'sqm' => 520,
                'beds' => 6,
                'baths' => 5,
                'title' => SeedTranslatable::make(
                    'Golf-view villa in Katameya Heights',
                    'فيلا بإطلالة على الجولف في قطامية هايتس',
                    'Вилла с видом на гольф в Katameya Heights'
                ),
                'slug' => SeedTranslatable::make('katameya-golf-villa', 'katameya-golf-villa-ar', 'katameya-golf-villa-ru'),
            ],
            [
                'type' => 'chalet',
                'area' => $newCairo,
                'compound' => 'cairo-festival-city',
                'listing' => ListingType::Rent,
                'price' => 45000,
                'sqm' => 165,
                'beds' => 3,
                'baths' => 2,
                'title' => SeedTranslatable::make(
                    'Furnished chalet near Cairo Festival Mall',
                    'شاليه مفروش بالقرب من كايرو فستيفال مول',
                    'Меблированное шале рядом с Cairo Festival Mall'
                ),
                'slug' => SeedTranslatable::make('cfc-furnished-chalet', 'cfc-furnished-chalet-ar', 'cfc-furnished-chalet-ru'),
            ],
            [
                'type' => 'studio',
                'area' => $maadi,
                'compound' => 'degla',
                'listing' => ListingType::Rent,
                'price' => 18000,
                'sqm' => 75,
                'beds' => 1,
                'baths' => 1,
                'title' => SeedTranslatable::make(
                    'Modern studio in Degla with metro access',
                    'استوديو حديث في دجلة قريب من المترو',
                    'Современная студия в Дегла с доступом к метро'
                ),
                'slug' => SeedTranslatable::make('degla-metro-studio', 'degla-metro-studio-ar', 'degla-metro-studio-ru'),
            ],
            [
                'type' => 'commercial',
                'area' => $newCairo,
                'compound' => 'cairo-festival-city',
                'listing' => ListingType::Sale,
                'price' => 9800000,
                'sqm' => 210,
                'beds' => null,
                'baths' => 2,
                'title' => SeedTranslatable::make(
                    'Retail unit on main boulevard in Festival City',
                    'وحدة تجارية على البوليفارد الرئيسي',
                    'Торговое помещение на главном бульваре'
                ),
                'slug' => SeedTranslatable::make('cfc-retail-unit', 'cfc-retail-unit-ar', 'cfc-retail-unit-ru'),
            ],
            [
                'type' => 'villa',
                'area' => $maadi,
                'compound' => 'suncity',
                'listing' => ListingType::Sale,
                'price' => 14500000,
                'sqm' => 310,
                'beds' => 4,
                'baths' => 3,
                'title' => SeedTranslatable::make(
                    'Family villa with pool in Suncity Maadi',
                    'فيلا عائلية بحمام سباحة في صن سيتي',
                    'Семейная вилла с бассейном в Suncity'
                ),
                'slug' => SeedTranslatable::make('suncity-pool-villa', 'suncity-pool-villa-ar', 'suncity-pool-villa-ru'),
            ],
            [
                'type' => 'chalet',
                'area' => $newCairo,
                'compound' => 'madinaty',
                'listing' => ListingType::Sale,
                'price' => 6200000,
                'sqm' => 190,
                'beds' => 3,
                'baths' => 2,
                'title' => SeedTranslatable::make(
                    'Corner chalet with landscaped terrace',
                    'شاليه ناصية بتراس منسق',
                    'Угловое шале с ландшафтной террасой'
                ),
                'slug' => SeedTranslatable::make('madinaty-corner-chalet', 'madinaty-corner-chalet-ar', 'madinaty-corner-chalet-ru'),
            ],
            [
                'type' => 'studio',
                'area' => $newCairo,
                'compound' => 'katameya-heights',
                'listing' => ListingType::Rent,
                'price' => 22000,
                'sqm' => 68,
                'beds' => 1,
                'baths' => 1,
                'title' => SeedTranslatable::make(
                    'Compact studio for young professionals',
                    'استوديو عملي للشباب',
                    'Компактная студия для молодых специалистов'
                ),
                'slug' => SeedTranslatable::make('katameya-compact-studio', 'katameya-compact-studio-ar', 'katameya-compact-studio-ru'),
            ],
            [
                'type' => 'villa',
                'area' => $newCairo,
                'compound' => 'cairo-festival-city',
                'listing' => ListingType::Rent,
                'price' => 85000,
                'sqm' => 340,
                'beds' => 4,
                'baths' => 4,
                'title' => SeedTranslatable::make(
                    'Semi-furnished villa close to international schools',
                    'فيلا شبه مفروشة قريبة من المدارس الدولية',
                    'Частично меблированная вилла рядом со школами'
                ),
                'slug' => SeedTranslatable::make('cfc-schools-villa', 'cfc-schools-villa-ar', 'cfc-schools-villa-ru'),
            ],
            [
                'type' => 'commercial',
                'area' => $maadi,
                'compound' => 'degla',
                'listing' => ListingType::Rent,
                'price' => 55000,
                'sqm' => 145,
                'beds' => null,
                'baths' => 1,
                'title' => SeedTranslatable::make(
                    'Medical clinic space in Degla',
                    'مساحة عيادة طبية في دجلة',
                    'Помещение под медицинскую клинику в Дегла'
                ),
                'slug' => SeedTranslatable::make('degla-clinic-space', 'degla-clinic-space-ar', 'degla-clinic-space-ru'),
            ],
            [
                'type' => 'chalet',
                'area' => $maadi,
                'compound' => 'suncity',
                'listing' => ListingType::Rent,
                'price' => 32000,
                'sqm' => 155,
                'beds' => 2,
                'baths' => 2,
                'title' => SeedTranslatable::make(
                    'Bright chalet with Nile proximity',
                    'شاليه مشرق قريب من النيل',
                    'Светлое шале недалеко от Нила'
                ),
                'slug' => SeedTranslatable::make('suncity-nile-chalet', 'suncity-nile-chalet-ar', 'suncity-nile-chalet-ru'),
            ],
            [
                'type' => 'studio',
                'area' => $newCairo,
                'compound' => 'madinaty',
                'listing' => ListingType::Sale,
                'price' => 3100000,
                'sqm' => 72,
                'beds' => 1,
                'baths' => 1,
                'title' => SeedTranslatable::make(
                    'Investment studio in Madinaty Open Air Mall district',
                    'استوديو استثماري قرب مول مدينتي',
                    'Инвестиционная студия рядом с торговым центром'
                ),
                'slug' => SeedTranslatable::make('madinaty-investment-studio', 'madinaty-investment-studio-ar', 'madinaty-investment-studio-ru'),
            ],
        ];

        $placeholderImages = $this->seedPropertyPlaceholderImages();

        foreach ($properties as $index => $data) {
            $compound = $compounds->get($data['compound']);

            Property::query()->updateOrCreate(
                ['slug->en' => $data['slug']['en']],
                [
                    'property_type_id' => $types->get($data['type'])->id,
                    'city_id' => $cairo->id,
                    'area_id' => $data['area']->id,
                    'compound_id' => $compound?->id,
                    'title' => $data['title'],
                    'slug' => $data['slug'],
                    'description' => SeedTranslatable::make(
                        'Spacious layout with premium finishes, natural light, and access to compound amenities including pools, parks, and retail.',
                        'تصميم واسع بتشطيبات راقية وإضاءة طبيعية مع خدمات الكمبوند من مسابح وحدائق ومناطق تجارية.',
                        'Просторная планировка, качественная отделка, естественное освещение и инфраструктура комплекса.'
                    ),
                    'features' => SeedTranslatable::make(
                        '<ul><li>Central AC</li><li>Built-in wardrobes</li><li>Private parking</li></ul>',
                        '<ul><li>تكييف مركزي</li><li>دولاب مدمج</li><li>موقف خاص</li></ul>',
                        '<ul><li>Центральный кондиционер</li><li>Встроенные шкафы</li><li>Парковка</li></ul>'
                    ),
                    'listing_type' => $data['listing'],
                    'price' => $data['price'],
                    'currency' => 'EGP',
                    'property_area_sqm' => $data['sqm'],
                    'bedrooms' => $data['beds'],
                    'bathrooms' => $data['baths'],
                    'floor' => (string) ($index % 5),
                    'furnished' => $data['listing'] === ListingType::Rent
                        ? FurnishedType::Furnished
                        : FurnishedType::Unfurnished,
                    'status' => PropertyStatus::Available,
                    'latitude' => 30.03 + ($index * 0.01),
                    'longitude' => 31.42 + ($index * 0.008),
                    'is_featured' => $index < 4,
                    'is_published' => true,
                    'published_at' => now()->subDays(15 - $index),
                    'featured_image' => $placeholderImages[$index % count($placeholderImages)],
                ]
            );
        }

        Property::query()->each(function (Property $property, int $index) use ($placeholderImages): void {
            if ($property->images()->exists()) {
                return;
            }

            PropertyImage::query()->create([
                'property_id' => $property->id,
                'path' => $placeholderImages[$index % count($placeholderImages)],
                'sort_order' => 0,
            ]);

            $secondary = $placeholderImages[($index + 1) % count($placeholderImages)];

            if ($secondary !== $placeholderImages[$index % count($placeholderImages)]) {
                PropertyImage::query()->create([
                    'property_id' => $property->id,
                    'path' => $secondary,
                    'sort_order' => 1,
                ]);
            }
        });
    }
}
