<?php

namespace App\Observers;

use App\Models\Project;
use App\Observers\Concerns\OptimizesFeaturedImage;

class ProjectObserver
{
    use OptimizesFeaturedImage;

    public function saving(Project $project): void
    {
        $this->optimizeFeaturedImage($project, 'projects');
    }
}
