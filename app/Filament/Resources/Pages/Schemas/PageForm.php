<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Support\FormComponents;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.sections.basic_information'))
                    ->schema([
                        TextInput::make('slug')
                            ->label(__('filament.fields.slug'))
                            ->required()
                            ->maxLength(255),
                        FormComponents::translationTabs(fn (string $locale): array => [
                            TextInput::make("title.{$locale}")
                                ->label(__('filament.fields.title'))
                                ->required($locale === 'en')
                                ->maxLength(255),
                            Textarea::make("content.{$locale}")
                                ->label(__('filament.fields.content'))
                                ->rows(8),
                        ]),
                        Toggle::make('is_published')
                            ->label(__('filament.fields.is_published')),
                    ])
                    ->columns(2),
                FormComponents::seoSection('pages/seo'),
            ]);
    }
}
