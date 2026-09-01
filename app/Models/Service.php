<?php

namespace App\Models;

use App\Support\Concerns\HasSeo;
use App\Support\Concerns\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory;
    use HasSeo;
    use HasTranslatableSlug;
    use HasTranslations;
    use SoftDeletes;

    /** @var list<string> */
    public array $translatable = [
        'name',
        'slug',
        'description',
        'features',
        'price_info',
        'seo_title',
        'seo_description',
    ];

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'price_info',
        'featured_image',
        'seo_title',
        'seo_description',
        'og_image',
        'is_published',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return HasMany<ServiceImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<ServiceVideo, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(ServiceVideo::class)->orderBy('sort_order');
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
