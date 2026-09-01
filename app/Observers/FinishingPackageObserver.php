<?php

namespace App\Observers;

use App\Models\FinishingPackage;
use App\Observers\Concerns\OptimizesFeaturedImage;

class FinishingPackageObserver
{
    use OptimizesFeaturedImage;

    public function saving(FinishingPackage $package): void
    {
        $this->optimizeFeaturedImage($package, 'packages');
    }
}
