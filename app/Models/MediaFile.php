<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaFile extends Model
{
    protected $table = 'media_files';

    protected $fillable = [
        'album_id', 'mediable_type', 'mediable_id', 'file_path', 'file_name',
        'file_type', 'mime_type', 'file_size', 'title', 'caption',
        'alt_text', 'width', 'height', 'sort_order',
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function mediable()
    {
        return $this->morphTo();
    }
}
