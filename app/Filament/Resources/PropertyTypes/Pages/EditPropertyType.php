<?php

namespace App\Filament\Resources\PropertyTypes\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\PropertyTypes\PropertyTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPropertyType extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = PropertyTypeResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
