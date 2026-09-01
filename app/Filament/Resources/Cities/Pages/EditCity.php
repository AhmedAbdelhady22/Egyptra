<?php

namespace App\Filament\Resources\Cities\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Cities\CityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCity extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = CityResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
