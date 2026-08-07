<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Umkm extends Model
{
    protected $table = 'umkm';

    protected $fillable = [
        'name', 'slug', 'owner_name', 'owner_resident_id', 'description',
        'category', 'address', 'padukuhan_id', 'phone', 'email', 'website',
        'social_media', 'products', 'photos', 'coordinates_lat', 'coordinates_lng',
        'is_verified', 'is_featured', 'is_published',
    ];

    protected $casts = [
        'social_media' => 'array',
        'products' => 'array',
        'photos' => 'array',
        'is_verified' => 'boolean',
        'is_featured' => 'boolean',
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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'owner_resident_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
