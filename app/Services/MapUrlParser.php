<?php

namespace App\Services;

class MapUrlParser
{
    public function parse(?string $url): array
    {
        if (! $url) {
            return ['latitude' => null, 'longitude' => null];
        }

        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2],
            ];
        }

        if (preg_match('/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2],
            ];
        }

        return ['latitude' => null, 'longitude' => null];
    }

    public function embedUrl(?string $url, ?float $lat, ?float $lng): ?string
    {
        if ($lat && $lng) {
            return "https://maps.google.com/maps?q={$lat},{$lng}&z=15&output=embed";
        }

        if ($url) {
            return str_replace('/maps/', '/maps/embed/', $url);
        }

        return null;
    }
}
