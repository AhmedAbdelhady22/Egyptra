<?php

namespace App\Enums;

enum ListingType: string
{
    case Sale = 'sale';
    case Rent = 'rent';

    public function label(): string
    {
        return match ($this) {
            self::Sale => __('For Sale'),
            self::Rent => __('For Rent'),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [$case->value => $case->label()])
            ->all();
    }
}
