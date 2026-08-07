<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'content', 'priority', 'start_date', 'end_date',
        'attachment_path', 'is_popup', 'is_pinned', 'is_ticker', 'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_popup' => 'boolean',
        'is_pinned' => 'boolean',
        'is_ticker' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            });
    }

    public function scopeTicker($query)
    {
        return $query->active()->where('is_ticker', true);
    }

    public function scopePopup($query)
    {
        return $query->active()->where('is_popup', true);
    }
}
