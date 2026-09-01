<?php

namespace App\Filament\Resources\FinishingPackages\Pages;

use App\Filament\Resources\FinishingPackages\FinishingPackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFinishingPackages extends ListRecords
{
    protected static string $resource = FinishingPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
