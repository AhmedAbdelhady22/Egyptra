<?php

namespace Database\Seeders\Concerns;

final class SeedTranslatable
{
    /**
     * @return array{en: string, ar: string, ru: string}
     */
    public static function make(string $en, string $ar, string $ru): array
    {
        return [
            'en' => $en,
            'ar' => $ar,
            'ru' => $ru,
        ];
    }
}
