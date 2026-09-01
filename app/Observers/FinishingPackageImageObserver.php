<?php

namespace App\Observers;

use App\Models\FinishingPackageImage;
use App\Observers\Concerns\OptimizesGalleryImage;

class FinishingPackageImageObserver
{
    use OptimizesGalleryImage;

    public function saving(FinishingPackageImage $image): void
    {
        $this->optimizeGalleryImage($image, 'packages/gallery');
    }
}
