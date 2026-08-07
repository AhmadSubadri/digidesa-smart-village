<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PublicDocument extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'description', 'file_path',
        'file_size', 'file_type', 'fiscal_year', 'uploaded_by',
        'is_published', 'download_count', 'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('fiscal_year', 'desc');
    }
}
