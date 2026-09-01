<?php

namespace Tests\Feature;

use App\Models\Area;
use App\Models\BlogPost;
use App\Models\City;
use App\Models\FinishingPackage;
use App\Models\Project;
use App\Models\Property;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DetailRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_property_detail_page_loads_by_localized_slug(): void
    {
        $city = City::factory()->create();
        $area = Area::factory()->create(['city_id' => $city->id]);

        $property = Property::factory()->forLocation($city, $area)->create([
            'title' => ['en' => 'Test Villa', 'ar' => 'فيلا تجريبية', 'ru' => 'Тестовая вилла'],
            'slug' => ['en' => 'test-villa-en', 'ar' => 'test-villa-ar', 'ru' => 'test-villa-ru'],
            'is_published' => true,
        ]);

        $response = $this->get('/en/properties/test-villa-en');

        $response->assertOk();
        $response->assertSee('Test Villa');
        $response->assertSee((string) $property->id, false);
    }

    public function test_service_detail_page_loads(): void
    {
        $service = Service::factory()->create([
            'name' => ['en' => 'Property Sales', 'ar' => 'مبيعات', 'ru' => 'Продажи'],
            'slug' => ['en' => 'property-sales', 'ar' => 'property-sales-ar', 'ru' => 'property-sales-ru'],
            'is_published' => true,
        ]);

        $this->get('/en/services/property-sales')
            ->assertOk()
            ->assertSee('Property Sales');
    }

    public function test_finishing_package_detail_page_loads(): void
    {
        FinishingPackage::factory()->create([
            'name' => ['en' => 'Luxury Package', 'ar' => 'باقة فاخرة', 'ru' => 'Люкс пакет'],
            'slug' => ['en' => 'luxury-package', 'ar' => 'luxury-ar', 'ru' => 'luxury-ru'],
            'is_published' => true,
        ]);

        $this->get('/en/finishing-packages/luxury-package')
            ->assertOk()
            ->assertSee('Luxury Package');
    }

    public function test_project_detail_page_loads(): void
    {
        Project::factory()->create([
            'title' => ['en' => 'Palm Residence', 'ar' => 'بالـم ريزيدنس', 'ru' => 'Palm Residence RU'],
            'slug' => ['en' => 'palm-residence', 'ar' => 'palm-residence-ar', 'ru' => 'palm-residence-ru'],
            'is_published' => true,
        ]);

        $this->get('/en/projects/palm-residence')
            ->assertOk()
            ->assertSee('Palm Residence');
    }

    public function test_blog_post_detail_page_loads(): void
    {
        BlogPost::factory()->create([
            'title' => ['en' => 'Market Update', 'ar' => 'تحديث السوق', 'ru' => 'Обзор рынка'],
            'slug' => ['en' => 'market-update', 'ar' => 'market-update-ar', 'ru' => 'market-update-ru'],
        ]);

        $this->get('/en/blog/market-update')
            ->assertOk()
            ->assertSee('Market Update');
    }

    public function test_unpublished_property_detail_returns_not_found(): void
    {
        $city = City::factory()->create();
        $area = Area::factory()->create(['city_id' => $city->id]);

        Property::factory()->forLocation($city, $area)->create([
            'slug' => ['en' => 'draft-property', 'ar' => 'draft-ar', 'ru' => 'draft-ru'],
            'is_published' => false,
        ]);

        $this->get('/en/properties/draft-property')->assertNotFound();
    }

    public function test_property_detail_loads_with_localized_russian_slug(): void
    {
        $city = City::factory()->create();
        $area = Area::factory()->create(['city_id' => $city->id]);

        Property::factory()->forLocation($city, $area)->create([
            'title' => ['en' => 'Test Villa', 'ar' => 'فيلا', 'ru' => 'Тестовая вилла'],
            'slug' => ['en' => 'test-villa-en', 'ar' => 'test-villa-ar', 'ru' => 'test-villa-ru'],
            'is_published' => true,
        ]);

        $this->get('/ru/properties/test-villa-ru')
            ->assertOk()
            ->assertSee('Тестовая вилла');
    }
}
