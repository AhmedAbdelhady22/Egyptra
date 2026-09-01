<?php

namespace App\Observers;

use App\Models\PropertyImage;
use App\Observers\Concerns\OptimizesGalleryImage;

class PropertyImageObserver
{
    use OptimizesGalleryImage;

    public function saving(PropertyImage $image): void
    {
        $this->optimizeGalleryImage($image, 'properties/gallery');
    }
}
