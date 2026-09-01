<?php

namespace App\Filament\Resources\Compounds\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Compounds\CompoundResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompound extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = CompoundResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
