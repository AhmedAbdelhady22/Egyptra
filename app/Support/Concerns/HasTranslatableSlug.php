<?php

namespace App\Support\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasTranslatableSlug
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        $locale = request()->route('locale') ?? app()->getLocale();

        return static::query()
            ->where(function (Builder $query) use ($value, $locale): void {
                $query->where("slug->{$locale}", $value)
                    ->orWhere('slug->en', $value);
            })
            ->tap(fn (Builder $query) => static::applyRouteBindingVisibilityScope($query))
            ->first();
    }

    /**
     * @param  Builder<static>  $query
     */
    protected static function applyRouteBindingVisibilityScope(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function localizedSlug(?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        return $this->getTranslation('slug', $locale, false)
            ?: $this->getTranslation('slug', 'en', false);
    }
}
