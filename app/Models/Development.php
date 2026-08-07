<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Development extends Model
{
    use HasSlug;

    protected $fillable = [
        'name', 'slug', 'description', 'location_text', 'budget_period_id',
        'budget_amount', 'contractor', 'start_date', 'end_date',
        'progress_percentage', 'status', 'before_photos', 'progress_photos',
        'after_photos', 'coordinates_lat', 'coordinates_lng',
        'volume', 'unit', 'beneficiaries_count', 'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget_amount' => 'decimal:2',
        'before_photos' => 'array',
        'progress_photos' => 'array',
        'after_photos' => 'array',
        'coordinates_lat' => 'decimal:8',
        'coordinates_lng' => 'decimal:8',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function budgetPeriod(): BelongsTo
    {
        return $this->belongsTo(BudgetPeriod::class);
    }
}
