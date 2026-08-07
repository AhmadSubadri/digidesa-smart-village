<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email', 'name', 'is_active', 'confirmed_at', 'token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNotNull('confirmed_at');
    }
}
