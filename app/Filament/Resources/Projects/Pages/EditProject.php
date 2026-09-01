<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = ProjectResource::class;

    protected function translatableFields(): array
    {
        return ['title', 'slug', 'description', 'location', 'features', 'seo_title', 'seo_description'];
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
