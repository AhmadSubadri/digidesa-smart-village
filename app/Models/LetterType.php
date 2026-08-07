<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterType extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'requirements', 'template_path',
        'is_active', 'estimated_days', 'fee', 'needs_approval',
        'approval_level', 'sort_order',
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
        'needs_approval' => 'boolean',
        'fee' => 'decimal:2',
    ];

    public function letterRequests(): HasMany
    {
        return $this->hasMany(LetterRequest::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
