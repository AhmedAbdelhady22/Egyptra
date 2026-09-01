<?php

namespace App\Filament\Resources\FinishingPackages\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\FinishingPackages\FinishingPackageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFinishingPackage extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = FinishingPackageResource::class;

    protected function translatableFields(): array
    {
        return ['name', 'slug', 'description', 'features', 'seo_title', 'seo_description'];
    }
}
