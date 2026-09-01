<?php

namespace App\Observers;

use App\Models\ServiceImage;
use App\Observers\Concerns\OptimizesGalleryImage;

class ServiceImageObserver
{
    use OptimizesGalleryImage;

    public function saving(ServiceImage $image): void
    {
        $this->optimizeGalleryImage($image, 'services/gallery');
    }
}
