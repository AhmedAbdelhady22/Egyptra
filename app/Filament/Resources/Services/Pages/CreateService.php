<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Services\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = ServiceResource::class;

    protected function translatableFields(): array
    {
        return ['name', 'slug', 'description', 'features', 'price_info', 'seo_title', 'seo_description'];
    }
}
