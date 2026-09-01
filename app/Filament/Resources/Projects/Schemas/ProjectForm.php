<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.sections.basic_information'))
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
                            Textarea::make("description.{$locale}")
                                ->label(__('filament.fields.description'))
                                ->rows(4),
                            TextInput::make("location.{$locale}")
                                ->label(__('filament.fields.location_text'))
                                ->maxLength(255),
                            Textarea::make("features.{$locale}")
                                ->label(__('filament.fields.features'))
                                ->rows(3),
                        ]),
                        DatePicker::make('completed_at')
                            ->label(__('filament.fields.completed_at')),
                        FileUpload::make('featured_image')
                            ->label(__('filament.fields.featured_image'))
                            ->image()
                            ->directory('projects')
                            ->visibility('public'),
                        Toggle::make('is_published')
                            ->label(__('filament.fields.is_published')),
                    ])
                    ->columns(2),
                FormComponents::seoSection('projects/seo'),
            ]);
    }
}
