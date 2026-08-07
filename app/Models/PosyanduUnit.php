<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PosyanduUnit extends Model
{
    protected $table = 'posyandu_units';

    protected $fillable = [
        'name', 'padukuhan_id', 'address', 'kader_count',
        'schedule_day', 'schedule_week', 'coordinator_name',
        'coordinator_phone', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function padukuhan(): BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }

    public function stuntingRecords(): HasMany
    {
        return $this->hasMany(StuntingRecord::class, 'posyandu_id');
    }

    public function pregnantMothers(): HasMany
    {
        return $this->hasMany(PregnantMother::class, 'posyandu_id');
    }
}
