<?php

namespace Database\Seeders\Concerns;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

trait GeneratesPlaceholderImages
{
    /**
     * @return list<string> Stored paths relative to the public disk.
     */
    protected function seedPropertyPlaceholderImages(int $count = 4): array
    {
        $paths = [];
        $palette = ['#232C33', '#5A7D7C', '#A0C1D1', '#E8614A'];

        for ($index = 0; $index < $count; $index++) {
            $filename = 'properties/seed/placeholder-'.($index + 1).'.webp';
            $color = $palette[$index % count($palette)];

            if (! Storage::disk('public')->exists($filename)) {
                $image = Image::createImage(1280, 960)->fill($color);
                Storage::disk('public')->put($filename, (string) $image->encode(new WebpEncoder(quality: 85)));
            }

            $paths[] = $filename;
        }

        return $paths;
    }
}
