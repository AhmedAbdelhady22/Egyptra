<?php

namespace App\Models;

use App\Support\Concerns\HasSeo;
use App\Support\Concerns\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class FinishingPackage extends Model
{
    use HasFactory;
    use HasSeo;
    use HasTranslatableSlug;
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = [
        'name',
        'slug',
        'description',
        'features',
        'seo_title',
        'seo_description',
    ];

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'features',
        'price_per_sqm',
        'currency',
        'featured_image',
        'seo_title',
        'seo_description',
        'og_image',
        'is_featured',
        'is_published',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_per_sqm' => 'decimal:2',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return HasMany<FinishingPackageImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(FinishingPackageImage::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<FinishingPackageVideo, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(FinishingPackageVideo::class)->orderBy('sort_order');
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
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
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
