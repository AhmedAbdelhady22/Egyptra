<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Enums\PublishStatus;
use App\Filament\Support\FormComponents;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.sections.basic_information'))
                    ->schema([
                        Select::make('blog_category_id')
                            ->label(__('filament.fields.category'))
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        FormComponents::translationTabs(fn (string $locale): array => [
                            TextInput::make("title.{$locale}")
                                ->label(__('filament.fields.title'))
                                ->required($locale === 'en')
                                ->maxLength(255),
                            TextInput::make("slug.{$locale}")
                                ->label(__('filament.fields.slug'))
                                ->required($locale === 'en')
                                ->maxLength(255),
                            Textarea::make("content.{$locale}")
                                ->label(__('filament.fields.content'))
                                ->rows(8),
                        ]),
                        FileUpload::make('featured_image')
                            ->label(__('filament.fields.featured_image'))
                            ->image()
                            ->directory('blog')
                            ->visibility('public'),
                        Select::make('status')
                            ->label(__('filament.fields.status'))
                            ->options(PublishStatus::class)
                            ->default(PublishStatus::Draft->value)
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label(__('filament.fields.published_at')),
                    ])
                    ->columns(2),
                FormComponents::seoSection('blog/seo'),
            ]);
    }
}
