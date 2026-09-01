<?php

namespace App\Models;

use App\Enums\FurnishedType;
use App\Enums\ListingType;
use App\Enums\PropertyStatus;
use App\Support\Concerns\HasSeo;
use App\Support\Concerns\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Property extends Model
{
    use HasFactory;
    use HasSeo;
    use HasTranslatableSlug;
    use HasTranslations;
    use SoftDeletes;

    /** @var list<string> */
    public array $translatable = [
        'title',
        'slug',
        'description',
        'features',
        'seo_title',
        'seo_description',
    ];

    /** @var list<string> */
    protected $fillable = [
        'property_type_id',
        'city_id',
        'area_id',
        'compound_id',
        'title',
        'slug',
        'description',
        'features',
        'listing_type',
        'price',
        'currency',
        'property_area_sqm',
        'bedrooms',
        'bathrooms',
        'floor',
        'furnished',
        'status',
        'google_maps_url',
        'latitude',
        'longitude',
        'featured_image',
        'seo_title',
        'seo_description',
        'og_image',
        'is_featured',
        'is_published',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'listing_type' => ListingType::class,
            'price' => 'decimal:2',
            'property_area_sqm' => 'decimal:2',
            'bedrooms' => 'integer',
            'bathrooms' => 'integer',
            'furnished' => FurnishedType::class,
            'status' => PropertyStatus::class,
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<PropertyType, $this>
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo<Area, $this>
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * @return BelongsTo<Compound, $this>
     */
    public function compound(): BelongsTo
    {
        return $this->belongsTo(Compound::class);
    }

    /**
     * @return HasMany<PropertyImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<PropertyVideo, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(PropertyVideo::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<Lead, $this>
     */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
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
     * @param  array<string, mixed>  $filters
     * @return Builder<self>
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['listing_type'] ?? null, function (Builder $query, mixed $value): void {
                $query->where('listing_type', $value instanceof ListingType ? $value->value : $value);
            })
            ->when($filters['property_type_id'] ?? null, fn (Builder $query, mixed $value) => $query->where('property_type_id', $value))
            ->when($filters['city_id'] ?? null, fn (Builder $query, mixed $value) => $query->where('city_id', $value))
            ->when($filters['area_id'] ?? null, fn (Builder $query, mixed $value) => $query->where('area_id', $value))
            ->when($filters['compound_id'] ?? null, fn (Builder $query, mixed $value) => $query->where('compound_id', $value))
            ->when($filters['price_min'] ?? null, fn (Builder $query, mixed $value) => $query->where('price', '>=', $value))
            ->when($filters['price_max'] ?? null, fn (Builder $query, mixed $value) => $query->where('price', '<=', $value))
            ->when($filters['area_min'] ?? null, fn (Builder $query, mixed $value) => $query->where('property_area_sqm', '>=', $value))
            ->when($filters['area_max'] ?? null, fn (Builder $query, mixed $value) => $query->where('property_area_sqm', '<=', $value))
            ->when($filters['bedrooms'] ?? null, fn (Builder $query, mixed $value) => $query->where('bedrooms', '>=', $value))
            ->when($filters['bathrooms'] ?? null, fn (Builder $query, mixed $value) => $query->where('bathrooms', '>=', $value))
            ->when($filters['floor'] ?? null, fn (Builder $query, mixed $value) => $query->where('floor', $value))
            ->when($filters['furnished'] ?? null, function (Builder $query, mixed $value): void {
                $query->where('furnished', $value instanceof FurnishedType ? $value->value : $value);
            })
            ->when($filters['status'] ?? null, function (Builder $query, mixed $value): void {
                $query->where('status', $value instanceof PropertyStatus ? $value->value : $value);
            });
    }
}
