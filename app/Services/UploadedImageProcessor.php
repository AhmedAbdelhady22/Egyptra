<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class UploadedImageProcessor
{
    public function __construct(protected ImageOptimizer $optimizer) {}

    /**
     * Optimize a stored public-disk image path in place.
     */
    public function optimizePath(?string $path, string $directory): ?string
    {
        if (! $path || $this->isAlreadyOptimized($path)) {
            return $path;
        }

        if (! Storage::disk('public')->exists($path)) {
            return $path;
        }

        $optimized = $this->optimizer->storeFromPath($path, $directory);

        Storage::disk('public')->delete($path);

        return $optimized['path'];
    }

    /**
     * @return array{path: string|null, thumbnail_path: string|null}
     */
    public function optimizeGalleryPath(?string $path, string $directory): array
    {
        if (! $path || $this->isAlreadyOptimized($path)) {
            return [
                'path' => $path,
                'thumbnail_path' => null,
            ];
        }

        if (! Storage::disk('public')->exists($path)) {
            return [
                'path' => $path,
                'thumbnail_path' => null,
            ];
        }

        $optimized = $this->optimizer->storeFromPath($path, $directory);

        Storage::disk('public')->delete($path);

        return [
            'path' => $optimized['path'],
            'thumbnail_path' => $optimized['thumbnail_path'],
        ];
    }

    protected function isAlreadyOptimized(string $path): bool
    {
        return str_ends_with(strtolower($path), '.webp')
            && str_contains($path, '/thumbs/') === false;
    }
}
