<?php

namespace App\Filament\Resources\Cities\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CityForm
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
                        ]),
                        TextInput::make('slug')
                            ->label(__('filament.fields.slug'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('sort_order')
                            ->label(__('filament.fields.sort_order'))
                            ->required()
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('filament.fields.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
