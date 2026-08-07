<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Institution extends Model
{
    protected $fillable = [
        'name', 'abbreviation', 'type', 'description', 'logo',
        'chairman_name', 'chairman_photo', 'secretary_name',
        'members_count', 'period', 'legal_basis', 'program_kerja',
        'address', 'phone', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'program_kerja' => 'array',
    ];

    public function officials(): BelongsToMany
    {
        return $this->belongsToMany(Official::class, 'institution_official')
            ->withPivot('role');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
