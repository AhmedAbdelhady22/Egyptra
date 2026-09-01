<?php

namespace App\Models;

use App\Support\Concerns\HasSeo;
use App\Support\Concerns\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasFactory;
    use HasSeo;
    use HasTranslatableSlug;
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = [
        'title',
        'slug',
        'description',
        'location',
        'features',
        'seo_title',
        'seo_description',
    ];

    /** @var list<string> */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'features',
        'completed_at',
        'featured_image',
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
            'completed_at' => 'date',
            'is_published' => 'boolean',
        ];
    }

    /**
     * @return HasMany<ProjectImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    /**
     * @return HasMany<ProjectVideo, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(ProjectVideo::class)->orderBy('sort_order');
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
