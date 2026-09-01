<?php

namespace App\Filament\Resources\Cities\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Cities\CityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCity extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = CityResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }
}
