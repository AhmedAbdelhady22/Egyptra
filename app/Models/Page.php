<?php

namespace App\Models;

use App\Support\Concerns\HasSeo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory;
    use HasSeo;
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = [
        'title',
        'content',
        'seo_title',
        'seo_description',
    ];

    /** @var list<string> */
    protected $fillable = [
        'slug',
        'title',
        'content',
        'seo_title',
        'seo_description',
        'og_image',
        'is_published',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        return static::query()
            ->where('slug', $value)
            ->where('is_published', true)
            ->first();
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
