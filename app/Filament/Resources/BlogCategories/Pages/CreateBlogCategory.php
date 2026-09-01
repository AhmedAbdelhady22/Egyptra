<?php

namespace App\Filament\Resources\BlogCategories\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\BlogCategories\BlogCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogCategory extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = BlogCategoryResource::class;

    protected function translatableFields(): array
    {
        return ['name', 'slug'];
    }
}
