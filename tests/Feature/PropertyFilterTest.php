<?php

namespace Tests\Feature;

use App\Enums\ListingType;
use App\Models\Area;
use App\Models\City;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_scope_applies_listing_type_and_price_range(): void
    {
        $city = City::factory()->create();

        Property::factory()->forLocation($city, Area::factory()->create(['city_id' => $city->id]))->create([
            'listing_type' => ListingType::Sale,
            'price' => 2_000_000,
            'is_published' => true,
        ]);

        Property::factory()->forLocation($city, Area::factory()->create(['city_id' => $city->id]))->create([
            'listing_type' => ListingType::Rent,
            'price' => 25_000,
            'is_published' => true,
        ]);

        Property::factory()->forLocation($city, Area::factory()->create(['city_id' => $city->id]))->create([
            'listing_type' => ListingType::Sale,
            'price' => 5_000_000,
            'is_published' => true,
        ]);

        $results = Property::query()
            ->filter([
                'listing_type' => ListingType::Sale->value,
                'price_min' => 3_000_000,
            ])
            ->get();

        $this->assertCount(1, $results);
        $this->assertSame(ListingType::Sale, $results->first()->listing_type);
        $this->assertSame('5000000.00', $results->first()->price);
    }

    public function test_filter_scope_applies_city_id(): void
    {
        $cairo = City::factory()->create(['name' => ['en' => 'Cairo', 'ar' => 'القاهرة', 'ru' => 'Каир']]);
        $giza = City::factory()->create(['name' => ['en' => 'Giza', 'ar' => 'الجيزة', 'ru' => 'Гиза']]);

        Property::factory()->forLocation($cairo, Area::factory()->create(['city_id' => $cairo->id]))->create([
            'is_published' => true,
        ]);

        Property::factory()->forLocation($giza, Area::factory()->create(['city_id' => $giza->id]))->create([
            'is_published' => true,
        ]);

        $results = Property::query()
            ->published()
            ->filter(['city_id' => $cairo->id])
            ->get();

        $this->assertCount(1, $results);
        $this->assertSame($cairo->id, $results->first()->city_id);
    }

    public function test_property_listing_page_shows_only_matching_published_properties(): void
    {
        $city = City::factory()->create();

        $matching = Property::factory()->forLocation($city, Area::factory()->create(['city_id' => $city->id]))->create([
            'listing_type' => ListingType::Sale,
            'title' => ['en' => 'Matching Villa', 'ar' => 'فيلا مطابقة', 'ru' => 'Подходящая вилла'],
            'is_published' => true,
        ]);

        Property::factory()->forLocation($city, Area::factory()->create(['city_id' => $city->id]))->create([
            'listing_type' => ListingType::Rent,
            'title' => ['en' => 'Rental Apartment', 'ar' => 'شقة للإيجار', 'ru' => 'Квартира в аренду'],
            'is_published' => true,
        ]);

        Property::factory()->forLocation($city, Area::factory()->create(['city_id' => $city->id]))->create([
            'listing_type' => ListingType::Sale,
            'title' => ['en' => 'Draft Villa', 'ar' => 'فيلا مسودة', 'ru' => 'Черновик виллы'],
            'is_published' => false,
        ]);

        $response = $this->get('/en/properties?listing_type=sale');

        $response->assertOk();
        $response->assertSee('Matching Villa');
        $response->assertDontSee('Rental Apartment');
        $response->assertDontSee('Draft Villa');
        $response->assertSee((string) $matching->id, false);
    }
}
