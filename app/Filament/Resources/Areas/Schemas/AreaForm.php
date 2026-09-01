<?php

namespace App\Filament\Resources\Areas\Schemas;

use App\Filament\Support\FormComponents;
use App\Models\City;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AreaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.sections.basic_information'))
                    ->schema([
                        Select::make('city_id')
                            ->label(__('filament.fields.city'))
                            ->relationship('city', 'name')
                            ->getOptionLabelFromRecordUsing(
                                fn (City $record): string => (string) ($record->getTranslation('name', app()->getLocale(), false)
                                    ?: $record->getTranslation('name', 'en', false)),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
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
