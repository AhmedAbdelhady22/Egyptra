<?php

namespace App\Enums;

enum VideoType: string
{
    case Url = 'url';
    case File = 'file';

    public function label(): string
    {
        return match ($this) {
            self::Url => __('Video URL'),
            self::File => __('Uploaded Video'),
        };
    }
}
