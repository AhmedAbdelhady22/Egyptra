<?php

namespace App\Support;

class Locale
{
    public const DEFAULT = 'en';

    /** @var list<string> */
    public const PUBLIC = ['en', 'ar', 'ru'];

    /** @var list<string> */
    public const ADMIN = ['en', 'ar'];

    public static function isRtl(?string $locale = null): bool
    {
        return ($locale ?? app()->getLocale()) === 'ar';
    }

    public static function direction(?string $locale = null): string
    {
        return self::isRtl($locale) ? 'rtl' : 'ltr';
    }

    public static function label(string $locale): string
    {
        return match ($locale) {
            'en' => 'English',
            'ar' => 'العربية',
            'ru' => 'Русский',
            default => $locale,
        };
    }
}
