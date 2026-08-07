<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rt extends Model
{
    protected $table = 'rts';

    protected $fillable = [
        'number', 'padukuhan_id', 'rw_id', 'head_name', 'head_phone', 'households_count',
    ];

    public function padukuhan(): BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class, 'rt_id');
    }
}
