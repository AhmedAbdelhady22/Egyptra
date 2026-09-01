<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'message',
        'property_id',
        'status',
        'source',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
        ];
    }

    /**
     * @return BelongsTo<Property, $this>
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', LeadStatus::New);
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeStatus(Builder $query, LeadStatus $status): Builder
    {
        return $query->where('status', $status);
    }
}
