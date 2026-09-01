<?php

namespace App\Filament\Resources\Areas\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Areas\AreaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArea extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = AreaResource::class;

    protected function translatableFields(): array
    {
        return ['name'];
    }
}
