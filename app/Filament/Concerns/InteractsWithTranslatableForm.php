<?php

namespace App\Filament\Concerns;

use App\Filament\Support\FormComponents;

trait InteractsWithTranslatableForm
{
    /**
     * @return list<string>
     */
    abstract protected function translatableFields(): array;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        return FormComponents::expandTranslatable($data, $this->translatableFields());
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return FormComponents::collapseTranslatable($data, $this->translatableFields());
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return FormComponents::collapseTranslatable($data, $this->translatableFields());
    }
}
