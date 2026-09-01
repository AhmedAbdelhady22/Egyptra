<?php

namespace Database\Seeders;

use App\Settings\GeneralSettings;
use App\Settings\SeoSettings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $general = app(GeneralSettings::class);
        $general->site_name = 'Egyptra';
        $general->logo = null;
        $general->favicon = null;
        $general->whatsapp_number = env('SEED_WHATSAPP_NUMBER', '+201000000000');
        $general->phone = env('SEED_PHONE', '+20 100 000 0000');
        $general->email = env('SEED_EMAIL', 'info@egyptra.com');
        $general->address = 'Cairo, Egypt';
        $general->google_maps_url = null;
        $general->facebook_url = null;
        $general->instagram_url = null;
        $general->linkedin_url = null;
        $general->youtube_url = null;
        $general->save();

        $seo = app(SeoSettings::class);
        $seo->default_title = 'Egyptra | Premium Real Estate in Egypt';
        $seo->default_description = 'Browse premium properties for sale and rent, finishing packages, and real estate services across Egypt.';
        $seo->default_og_image = null;
        $seo->save();
    }
}
