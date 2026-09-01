<?php

namespace App\Filament\Resources\Areas\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Areas\AreaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArea extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = AreaResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
