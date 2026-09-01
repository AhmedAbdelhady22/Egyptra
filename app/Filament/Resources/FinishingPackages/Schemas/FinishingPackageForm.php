<?php

namespace App\Filament\Resources\FinishingPackages\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FinishingPackageForm
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
                        ]),
                        TextInput::make('price_per_sqm')
                            ->label(__('filament.fields.price_per_sqm'))
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('currency')
                            ->label(__('filament.fields.currency'))
                            ->default('EGP')
                            ->maxLength(3),
                        FileUpload::make('featured_image')
                            ->label(__('filament.fields.featured_image'))
                            ->image()
                            ->directory('packages')
                            ->visibility('public'),
                        TextInput::make('sort_order')
                            ->label(__('filament.fields.sort_order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_featured')
                            ->label(__('filament.fields.is_featured')),
                        Toggle::make('is_published')
                            ->label(__('filament.fields.is_published')),
                    ])
                    ->columns(2),
                FormComponents::seoSection('packages/seo'),
            ]);
    }
}
