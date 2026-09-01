<?php

namespace App\Observers;

use App\Models\Service;
use App\Observers\Concerns\OptimizesFeaturedImage;

class ServiceObserver
{
    use OptimizesFeaturedImage;

    public function saving(Service $service): void
    {
        $this->optimizeFeaturedImage($service, 'services');
    }
}
