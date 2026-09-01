<?php

namespace App\Filament\Resources\BlogCategories\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.sections.basic_information'))
                    ->schema([
                        FormComponents::translationTabs(fn (string $locale): array => [
                            TextInput::make("name.{$locale}")
                                ->label(__('filament.fields.name'))
                                ->required($locale === 'en')
                                ->maxLength(255),
                            TextInput::make("slug.{$locale}")
                                ->label(__('filament.fields.slug'))
                                ->required($locale === 'en')
                                ->maxLength(255),
                        ]),
                    ]),
            ]);
    }
}
