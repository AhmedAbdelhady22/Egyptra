<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = ProjectResource::class;

    protected function translatableFields(): array
    {
        return ['title', 'slug', 'description', 'location', 'features', 'seo_title', 'seo_description'];
    }
}
