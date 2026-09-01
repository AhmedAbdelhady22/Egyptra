<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name = 'Egyptra';

    public ?string $logo = null;

    public ?string $favicon = null;

    public ?string $whatsapp_number = null;

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $address = null;

    public ?string $google_maps_url = null;

    public ?string $facebook_url = null;

    public ?string $instagram_url = null;

    public ?string $linkedin_url = null;

    public ?string $youtube_url = null;

    public static function group(): string
    {
        return 'general';
    }
}
