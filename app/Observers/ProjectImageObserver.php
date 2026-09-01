<?php

namespace App\Observers;

use App\Models\ProjectImage;
use App\Observers\Concerns\OptimizesGalleryImage;

class ProjectImageObserver
{
    use OptimizesGalleryImage;

    public function saving(ProjectImage $image): void
    {
        $this->optimizeGalleryImage($image, 'projects/gallery');
    }
}
