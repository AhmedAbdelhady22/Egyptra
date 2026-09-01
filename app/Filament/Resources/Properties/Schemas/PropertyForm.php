<?php

namespace App\Filament\Resources\Properties\Schemas;

use App\Enums\FurnishedType;
use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Enums\VideoType;
use App\Filament\Support\FormComponents;
use App\Models\Area;
use App\Models\City;
use App\Models\Compound;
use App\Models\PropertyType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('filament.sections.property_information'))
                    ->schema([
                        FormComponents::translationTabs(fn (string $locale): array => [
                            TextInput::make("title.{$locale}")
                                ->label(__('filament.fields.title'))
                                ->required($locale === 'en')
                                ->maxLength(255),
                            TextInput::make("slug.{$locale}")
                                ->label(__('filament.fields.slug'))
                                ->required($locale === 'en')
                                ->maxLength(255),
                        ]),
                        Select::make('property_type_id')
                            ->label(__('filament.fields.property_type'))
                            ->relationship(
                                name: 'propertyType',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderBy('sort_order'),
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (PropertyType $record): string => (string) ($record->getTranslation('name', app()->getLocale(), false)
                                    ?: $record->getTranslation('name', 'en', false)),
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('listing_type')
                            ->label(__('filament.fields.listing_type'))
                            ->options(ListingType::options())
                            ->required(),
                        TextInput::make('price')
                            ->label(__('filament.fields.price'))
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('currency')
                            ->label(__('filament.fields.currency'))
                            ->required()
                            ->default('EGP')
                            ->maxLength(3),
                        Select::make('status')
                            ->label(__('filament.fields.status'))
                            ->options(PropertyStatus::options())
                            ->default(PropertyStatus::Available->value)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make(__('filament.sections.property_details'))
                    ->schema([
                        TextInput::make('property_area_sqm')
                            ->label(__('filament.fields.area_sqm'))
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('bedrooms')
                            ->label(__('filament.fields.bedrooms'))
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('bathrooms')
                            ->label(__('filament.fields.bathrooms'))
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('floor')
                            ->label(__('filament.fields.floor'))
                            ->maxLength(50),
                        Select::make('furnished')
                            ->label(__('filament.fields.furnished'))
                            ->options(FurnishedType::options()),
                    ])
                    ->columns(2),

                Section::make(__('filament.sections.location'))
                    ->schema([
                        Select::make('city_id')
                            ->label(__('filament.fields.city'))
                            ->relationship(
                                name: 'city',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->orderBy('sort_order'),
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (City $record): string => (string) ($record->getTranslation('name', app()->getLocale(), false)
                                    ?: $record->getTranslation('name', 'en', false)),
                            )
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set): void {
                                $set('area_id', null);
                                $set('compound_id', null);
                            })
                            ->required(),
                        Select::make('area_id')
                            ->label(__('filament.fields.area'))
                            ->options(fn (Get $get): array => Area::query()
                                ->when(
                                    filled($get('city_id')),
                                    fn ($query) => $query->where('city_id', $get('city_id')),
                                    fn ($query) => $query->whereRaw('0 = 1'),
                                )
                                ->orderBy('sort_order')
                                ->get()
                                ->mapWithKeys(fn (Area $area): array => [
                                    $area->id => (string) ($area->getTranslation('name', app()->getLocale(), false)
                                        ?: $area->getTranslation('name', 'en', false)),
                                ])
                                ->all())
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('compound_id', null)),
                        Select::make('compound_id')
                            ->label(__('filament.fields.compound'))
                            ->options(fn (Get $get): array => Compound::query()
                                ->when(
                                    filled($get('area_id')),
                                    fn ($query) => $query->where('area_id', $get('area_id')),
                                    fn ($query) => $query->whereRaw('0 = 1'),
                                )
                                ->orderBy('sort_order')
                                ->get()
                                ->mapWithKeys(fn (Compound $compound): array => [
                                    $compound->id => (string) ($compound->getTranslation('name', app()->getLocale(), false)
                                        ?: $compound->getTranslation('name', 'en', false)),
                                ])
                                ->all())
                            ->searchable(),
                        TextInput::make('google_maps_url')
                            ->label(__('filament.fields.google_maps_url'))
                            ->url()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make(__('filament.sections.description'))
                    ->schema([
                        FormComponents::translationTabs(fn (string $locale): array => [
                            Textarea::make("description.{$locale}")
                                ->label(__('filament.fields.description'))
                                ->rows(5),
                            Repeater::make("feature_items.{$locale}")
                                ->label(__('filament.fields.features'))
                                ->schema([
                                    TextInput::make('value')
                                        ->label(__('filament.fields.feature'))
                                        ->required()
                                        ->maxLength(255),
                                ])
                                ->defaultItems(0)
                                ->collapsible()
                                ->columnSpanFull(),
                        ]),
                    ]),

                Section::make(__('filament.sections.media'))
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label(__('filament.fields.featured_image'))
                            ->image()
                            ->directory('properties')
                            ->visibility('public'),
                        Repeater::make('images')
                            ->label(__('filament.fields.gallery_images'))
                            ->relationship()
                            ->schema([
                                FileUpload::make('path')
                                    ->label(__('filament.fields.image_path'))
                                    ->image()
                                    ->directory('properties/gallery')
                                    ->visibility('public')
                                    ->required(),
                                TextInput::make('sort_order')
                                    ->label(__('filament.fields.sort_order'))
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->orderColumn('sort_order')
                            ->collapsible()
                            ->defaultItems(0),
                        Repeater::make('videos')
                            ->label(__('filament.fields.videos'))
                            ->relationship()
                            ->schema([
                                Select::make('type')
                                    ->label(__('filament.fields.video_type'))
                                    ->options(VideoType::class)
                                    ->default(VideoType::Url->value)
                                    ->required()
                                    ->live(),
                                TextInput::make('url')
                                    ->label(__('filament.fields.video_url'))
                                    ->url()
                                    ->visible(fn (Get $get): bool => $get('type') === VideoType::Url->value),
                                FileUpload::make('path')
                                    ->label(__('filament.fields.video_file'))
                                    ->directory('properties/videos')
                                    ->visibility('public')
                                    ->visible(fn (Get $get): bool => $get('type') === VideoType::File->value),
                                TextInput::make('sort_order')
                                    ->label(__('filament.fields.sort_order'))
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->orderColumn('sort_order')
                            ->collapsible()
                            ->defaultItems(0),
                    ]),

                FormComponents::seoSection('properties/seo'),

                Section::make(__('filament.sections.publishing'))
                    ->schema([
                        Toggle::make('is_featured')
                            ->label(__('filament.fields.is_featured')),
                        Toggle::make('is_published')
                            ->label(__('filament.fields.is_published')),
                        DateTimePicker::make('published_at')
                            ->label(__('filament.fields.published_at')),
                    ])
                    ->columns(2),
            ]);
    }
}
