<?php

namespace App\Models;

use App\Enums\VideoType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinishingPackageVideo extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'finishing_package_id',
        'type',
        'url',
        'path',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => VideoType::class,
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<FinishingPackage, $this>
     */
    public function finishingPackage(): BelongsTo
    {
        return $this->belongsTo(FinishingPackage::class);
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
