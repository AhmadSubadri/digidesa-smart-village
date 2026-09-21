<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'media_type', 'image_path', 'video_url', 'video_path',
        'cta_text', 'cta_url', 'cta_secondary_text', 'cta_secondary_url',
        'text_position', 'start_date', 'end_date', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort_order');
    }

    public function isVideo(): bool
    {
        return in_array($this->media_type, ['video', 'youtube']);
    }

    public function getYouTubeEmbedUrl(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }

        // Match YouTube video ID
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $this->video_url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $matches[1] . '&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1';
        }

        return $this->video_url;
    }
}
