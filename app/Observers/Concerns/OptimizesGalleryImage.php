<?php

namespace App\Observers\Concerns;

use App\Services\UploadedImageProcessor;
use Illuminate\Database\Eloquent\Model;

trait OptimizesGalleryImage
{
    protected function optimizeGalleryImage(Model $model, string $directory): void
    {
        if (! $model->isDirty('path')) {
            return;
        }

        $optimized = app(UploadedImageProcessor::class)->optimizeGalleryPath($model->path, $directory);

        $model->path = $optimized['path'];
        $model->thumbnail_path = $optimized['thumbnail_path'] ?? $model->thumbnail_path;
    }
}
