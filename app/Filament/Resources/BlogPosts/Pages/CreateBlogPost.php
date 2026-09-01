<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\BlogPosts\BlogPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPost extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = BlogPostResource::class;

    protected function translatableFields(): array
    {
        return ['title', 'slug', 'content', 'seo_title', 'seo_description'];
    }
}
