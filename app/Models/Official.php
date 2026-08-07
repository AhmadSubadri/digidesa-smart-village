<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Official extends Model
{
    protected $fillable = [
        'name', 'nip', 'position', 'rank', 'photo', 'phone', 'email',
        'period_start', 'period_end', 'bio', 'education',
        'padukuhan_id', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    public function padukuhan(): BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }

    public function institutions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Institution::class, 'institution_official')
            ->withPivot('role');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
