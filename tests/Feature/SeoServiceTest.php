<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Services\SeoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_seo_title_falls_back_to_title_and_site_name(): void
    {
        $property = Property::factory()->create([
            'seo_title' => ['en' => '', 'ar' => '', 'ru' => ''],
            'title' => ['en' => 'Luxury Villa', 'ar' => 'فيلا فاخرة', 'ru' => 'Роскошная вилла'],
        ]);

        $title = app(SeoService::class)->title($property, 'en');

        $this->assertSame('Luxury Villa | Egyptra', $title);
    }

    public function test_seo_title_uses_explicit_seo_title_when_present(): void
    {
        $property = Property::factory()->create([
            'seo_title' => ['en' => 'Custom SEO Title', 'ar' => 'عنوان مخصص', 'ru' => 'Пользовательский заголовок'],
            'title' => ['en' => 'Luxury Villa', 'ar' => 'فيلا فاخرة', 'ru' => 'Роскошная вилла'],
        ]);

        $title = app(SeoService::class)->title($property, 'en');

        $this->assertSame('Custom SEO Title', $title);
    }

    public function test_seo_title_falls_back_to_default_site_name_without_entity_title(): void
    {
        $property = Property::factory()->create([
            'seo_title' => ['en' => '', 'ar' => '', 'ru' => ''],
            'title' => ['en' => '', 'ar' => '', 'ru' => ''],
        ]);

        $title = app(SeoService::class)->title($property, 'en');

        $this->assertSame('Egyptra', $title);
    }
}
