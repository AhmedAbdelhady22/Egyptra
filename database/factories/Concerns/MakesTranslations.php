<?php

namespace Database\Factories\Concerns;

use Illuminate\Support\Str;

trait MakesTranslations
{
    /**
     * @return array{en: string, ar: string, ru: string}
     */
    protected function translations(string $en, string $ar, string $ru): array
    {
        return [
            'en' => $en,
            'ar' => $ar,
            'ru' => $ru,
        ];
    }

    /**
     * @return array{en: string, ar: string, ru: string}
     */
    protected function uniqueSlugTranslations(string $englishBase): array
    {
        $en = Str::slug($englishBase).'-'.fake()->unique()->numerify('####');

        return [
            'en' => $en,
            'ar' => $en.'-ar',
            'ru' => $en.'-ru',
        ];
    }
}
