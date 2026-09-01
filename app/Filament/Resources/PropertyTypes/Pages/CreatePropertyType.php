<?php

namespace App\Filament\Resources\PropertyTypes\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\PropertyTypes\PropertyTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePropertyType extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = PropertyTypeResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }
}
