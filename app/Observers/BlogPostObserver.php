<?php

namespace App\Observers;

use App\Models\BlogPost;
use App\Observers\Concerns\OptimizesFeaturedImage;

class BlogPostObserver
{
    use OptimizesFeaturedImage;

    public function saving(BlogPost $blogPost): void
    {
        $this->optimizeFeaturedImage($blogPost, 'blog');
    }
}
