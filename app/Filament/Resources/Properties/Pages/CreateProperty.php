<?php

namespace App\Filament\Resources\Properties\Pages;

use App\Filament\Concerns\InteractsWithTranslatableForm;
use App\Filament\Resources\Properties\PropertyResource;
use App\Filament\Support\FormComponents;
use App\Services\MapUrlParser;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
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

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
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
