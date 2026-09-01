<?php

namespace App\Filament\Support;

use App\Support\Locale;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class FormComponents
{
    /** @var list<string> */
    public const CONTENT_LOCALES = ['en', 'ar', 'ru'];

    /**
     * @param  callable(string): array<int, Component>  $fieldsPerLocale
     */
    public static function translationTabs(callable $fieldsPerLocale): Tabs
    {
        return Tabs::make('translations')
            ->tabs(
                collect(self::CONTENT_LOCALES)
                    ->map(
                        fn (string $locale): Tab => Tab::make(Locale::label($locale))
                            ->schema($fieldsPerLocale($locale)),
                    )
                    ->all(),
            );
    }

    public static function seoSection(?string $ogImageDirectory = null): Section
    {
        return Section::make(__('filament.sections.seo'))
            ->schema([
                self::translationTabs(fn (string $locale): array => [
                    TextInput::make("seo_title.{$locale}")
                        ->label(__('filament.fields.search_engine_title'))
                        ->maxLength(255),
                    Textarea::make("seo_description.{$locale}")
                        ->label(__('filament.fields.search_engine_description'))
                        ->rows(3),
                ]),
                FileUpload::make('og_image')
                    ->label(__('filament.fields.social_image'))
                    ->image()
                    ->directory($ogImageDirectory ?? 'seo')
                    ->visibility('public'),
            ])
            ->collapsible();
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $fields
     * @param  list<string>  $locales
     * @return array<string, mixed>
     */
    public static function expandTranslatable(array $data, array $fields, array $locales = self::CONTENT_LOCALES): array
    {
        foreach ($fields as $field) {
            $translations = $data[$field] ?? [];

            if (is_string($translations)) {
                $decoded = json_decode($translations, true);
                $translations = is_array($decoded) ? $decoded : [];
            }

            foreach ($locales as $locale) {
                $data["{$field}.{$locale}"] = $translations[$locale] ?? '';
            }

            unset($data[$field]);
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $fields
     * @param  list<string>  $locales
     * @return array<string, mixed>
     */
    public static function collapseTranslatable(array $data, array $fields, array $locales = self::CONTENT_LOCALES): array
    {
        foreach ($fields as $field) {
            $translations = [];

            foreach ($locales as $locale) {
                $key = "{$field}.{$locale}";

                if (array_key_exists($key, $data)) {
                    $translations[$locale] = $data[$key];
                    unset($data[$key]);
                }
            }

            if ($translations !== []) {
                $data[$field] = $translations;
            }
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $locales
     * @return array<string, mixed>
     */
    public static function expandFeatures(array $data, array $locales = self::CONTENT_LOCALES): array
    {
        $features = $data['features'] ?? [];

        if (is_string($features)) {
            $decoded = json_decode($features, true);
            $features = is_array($decoded) ? $decoded : [];
        }

        foreach ($locales as $locale) {
            $html = is_array($features) ? ($features[$locale] ?? '') : '';
            $data["feature_items.{$locale}"] = collect(self::featuresHtmlToItems($html))
                ->map(fn (string $item): array => ['value' => $item])
                ->values()
                ->all();
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $locales
     * @return array<string, mixed>
     */
    public static function collapseFeatures(array $data, array $locales = self::CONTENT_LOCALES): array
    {
        $features = [];

        foreach ($locales as $locale) {
            $key = "feature_items.{$locale}";
            $items = collect($data[$key] ?? [])
                ->pluck('value')
                ->filter(fn (mixed $value): bool => filled($value))
                ->map(fn (mixed $value): string => trim((string) $value))
                ->values()
                ->all();

            if ($items !== []) {
                $features[$locale] = self::featuresItemsToHtml($items);
            }

            unset($data[$key]);
        }

        if ($features !== []) {
            $data['features'] = $features;
        }

        return $data;
    }

    /**
     * @return list<string>
     */
    public static function featuresHtmlToItems(?string $html): array
    {
        if (! $html) {
            return [];
        }

        if (preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $html, $matches)) {
            return collect($matches[1])
                ->map(fn (string $item): string => trim(html_entity_decode(strip_tags($item))))
                ->filter()
                ->values()
                ->all();
        }

        return collect(preg_split('/\r\n|\r|\n/', strip_tags($html)))
            ->map(fn (string $line): string => trim(ltrim($line, '-• ')))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * @param  list<string>  $items
     */
    public static function featuresItemsToHtml(array $items): string
    {
        if ($items === []) {
            return '';
        }

        $list = collect($items)
            ->map(fn (string $item): string => '<li>'.e($item).'</li>')
            ->implode('');

        return "<ul>{$list}</ul>";
    }
}
