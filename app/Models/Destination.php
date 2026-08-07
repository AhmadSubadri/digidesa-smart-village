<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Destination extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'category', 'address',
        'padukuhan_id', 'photos', 'coordinates_lat', 'coordinates_lng',
        'opening_hours', 'ticket_price', 'facilities', 'contact_phone', 'is_published',
    ];

    protected $casts = [
        'photos' => 'array',
        'opening_hours' => 'array',
        'facilities' => 'array',
        'ticket_price' => 'decimal:2',
        'is_published' => 'boolean',
        'coordinates_lat' => 'decimal:8',
        'coordinates_lng' => 'decimal:8',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function padukuhan(): BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
