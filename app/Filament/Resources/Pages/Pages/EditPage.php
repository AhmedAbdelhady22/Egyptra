<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Pages\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = PageResource::class;

    protected function translatableFields(): array
    {
        return ['title', 'content', 'seo_title', 'seo_description'];
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
