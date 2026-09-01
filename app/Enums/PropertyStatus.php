<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case Available = 'available';
    case Reserved = 'reserved';
    case Sold = 'sold';
    case Rented = 'rented';

    public function label(): string
    {
        return match ($this) {
            self::Available => __('Available'),
            self::Reserved => __('Reserved'),
            self::Sold => __('Sold'),
            self::Rented => __('Rented'),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [$case->value => $case->label()])
            ->all();
    }
}
