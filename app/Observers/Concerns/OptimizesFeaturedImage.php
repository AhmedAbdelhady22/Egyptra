<?php

namespace App\Observers\Concerns;

use App\Services\UploadedImageProcessor;
use Illuminate\Database\Eloquent\Model;

trait OptimizesFeaturedImage
{
    protected function optimizeFeaturedImage(Model $model, string $directory): void
    {
        if (! $model->isDirty('featured_image')) {
            return;
        }

        $model->featured_image = app(UploadedImageProcessor::class)->optimizePath(
            $model->featured_image,
            $directory,
        );
    }
}
