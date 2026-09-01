<?php

namespace App\Filament\Resources\BlogCategories\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\BlogCategories\BlogCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBlogCategory extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = BlogCategoryResource::class;

    protected function translatableFields(): array
    {
        return ['name', 'slug'];
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
