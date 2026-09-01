<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = PageResource::class;

    protected function translatableFields(): array
    {
        return ['title', 'content', 'seo_title', 'seo_description'];
    }
}
