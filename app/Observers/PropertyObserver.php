<?php

namespace App\Observers;

use App\Models\Property;
use App\Observers\Concerns\OptimizesFeaturedImage;

class PropertyObserver
{
    use OptimizesFeaturedImage;

    public function saving(Property $property): void
    {
        $this->optimizeFeaturedImage($property, 'properties');
    }
}
