<?php

namespace App\Filament\Resources\Compounds\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Compounds\CompoundResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCompound extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = CompoundResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }
}
