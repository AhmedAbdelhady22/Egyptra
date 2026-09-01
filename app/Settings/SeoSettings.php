<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SeoSettings extends Settings
{
    public ?string $default_title = null;

    public ?string $default_description = null;

    public ?string $default_og_image = null;

    public static function group(): string
    {
        return 'seo';
    }
}
