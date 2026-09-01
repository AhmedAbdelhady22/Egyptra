<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Properties\PropertyResource;
use App\Filament\Support\FormComponents;
use App\Services\MapUrlParser;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditProperty extends EditRecord
{
    use InteractsWithTranslatableForm;

    protected static string $resource = PropertyResource::class;

    /**
     * @return list<string>
     */
    protected function translatableFields(): array
    {
        return ['title', 'slug', 'description', 'seo_title', 'seo_description'];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data = FormComponents::expandTranslatable($data, $this->translatableFields());

        return FormComponents::expandFeatures($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data = FormComponents::collapseTranslatable($data, $this->translatableFields());
        $data = FormComponents::collapseFeatures($data);

        return $this->parseMapCoordinates($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function parseMapCoordinates(array $data): array
    {
        if (! empty($data['google_maps_url'])) {
            $coordinates = app(MapUrlParser::class)->parse($data['google_maps_url']);
            $data['latitude'] = $coordinates['latitude'];
            $data['longitude'] = $coordinates['longitude'];
        }

        return $data;
    }
}
