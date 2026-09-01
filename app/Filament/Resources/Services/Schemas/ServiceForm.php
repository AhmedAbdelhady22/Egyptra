<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceForm
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
                            Textarea::make("description.{$locale}")
                                ->label(__('filament.fields.description'))
                                ->rows(4),
                            Textarea::make("features.{$locale}")
                                ->label(__('filament.fields.features'))
                                ->rows(3),
                            Textarea::make("price_info.{$locale}")
                                ->label(__('filament.fields.price_info'))
                                ->rows(2),
                        ]),
                        FileUpload::make('featured_image')
                            ->label(__('filament.fields.featured_image'))
                            ->image()
                            ->directory('services')
                            ->visibility('public'),
                        TextInput::make('sort_order')
                            ->label(__('filament.fields.sort_order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_published')
                            ->label(__('filament.fields.is_published')),
                    ])
                    ->columns(2),
                FormComponents::seoSection('services/seo'),
            ]);
    }
}
