<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Laravel\Facades\Image;

class ImageOptimizer
{
    public function store(UploadedFile $file, string $directory): array
    {
        $filename = uniqid().'.webp';
        $path = "{$directory}/{$filename}";
        $thumbPath = "{$directory}/thumbs/{$filename}";

        $image = Image::decodePath($file->getRealPath());
        $encoded = $image->scaleDown(width: 1920)->encode(new WebpEncoder(quality: 85));
        Storage::disk('public')->put($path, (string) $encoded);

        $thumb = Image::decodePath($file->getRealPath());
        $thumbEncoded = $thumb->cover(400, 300)->encode(new WebpEncoder(quality: 80));
        Storage::disk('public')->put($thumbPath, (string) $thumbEncoded);

        return [
            'path' => $path,
            'thumbnail_path' => $thumbPath,
        ];
    }

    public function storeFromPath(string $sourcePath, string $directory): array
    {
        $filename = uniqid().'.webp';
        $path = "{$directory}/{$filename}";
        $thumbPath = "{$directory}/thumbs/{$filename}";

        $image = Image::decodePath(Storage::disk('public')->path($sourcePath));
        $encoded = $image->scaleDown(width: 1920)->encode(new WebpEncoder(quality: 85));
        Storage::disk('public')->put($path, (string) $encoded);

        $thumb = Image::decodePath(Storage::disk('public')->path($sourcePath));
        $thumbEncoded = $thumb->cover(400, 300)->encode(new WebpEncoder(quality: 80));
        Storage::disk('public')->put($thumbPath, (string) $thumbEncoded);

        return [
            'path' => $path,
            'thumbnail_path' => $thumbPath,
        ];
    }
}
