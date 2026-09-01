<?php

namespace App\Models;

use App\Enums\PublishStatus;
use App\Support\Concerns\HasSeo;
use App\Support\Concerns\HasTranslatableSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
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
        'content',
        'seo_title',
        'seo_description',
    ];

    /** @var list<string> */
    protected $fillable = [
        'blog_category_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'seo_title',
        'seo_description',
        'og_image',
        'status',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PublishStatus::class,
            'published_at' => 'datetime',
        ];
    }

    /**
     * @param  Builder<self>  $query
     */
    protected static function applyRouteBindingVisibilityScope(Builder $query): void
    {
        $query->where('status', PublishStatus::Published);
    }

    /**
     * @return BelongsTo<BlogCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PublishStatus::Published);
    }
}
