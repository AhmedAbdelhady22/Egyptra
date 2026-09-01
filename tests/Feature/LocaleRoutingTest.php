<?php

namespace Tests\Feature;

use App\Support\Locale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleRoutingTest extends TestCase
{
    use RefreshDatabase;

    public function test_arabic_route_sets_rtl_locale_and_direction(): void
    {
        $response = $this->get('/ar');

        $response->assertOk();
        $response->assertSee('lang="ar"', false);
        $response->assertSee('dir="rtl"', false);
    }

    public function test_english_route_sets_ltr_direction(): void
    {
        $response = $this->get('/en');

        $response->assertOk();
        $response->assertSee('lang="en"', false);
        $response->assertSee('dir="ltr"', false);
    }

    public function test_locale_helper_identifies_rtl_for_arabic(): void
    {
        $this->assertTrue(Locale::isRtl('ar'));
        $this->assertSame('rtl', Locale::direction('ar'));
        $this->assertFalse(Locale::isRtl('en'));
        $this->assertSame('ltr', Locale::direction('en'));
    }
}
