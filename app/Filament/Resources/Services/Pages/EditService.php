<?php

namespace App\Filament\Resources\Services\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Services\ServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = ServiceResource::class;

    protected function translatableFields(): array
    {
        return ['name', 'slug', 'description', 'features', 'price_info', 'seo_title', 'seo_description'];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
