<?php

namespace App\Enums;

enum FurnishedType: string
{
    case Furnished = 'furnished';
    case Unfurnished = 'unfurnished';

    public function label(): string
    {
        return match ($this) {
            self::Furnished => __('Furnished'),
            self::Unfurnished => __('Unfurnished'),
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [$case->value => $case->label()])
            ->all();
    }
}
