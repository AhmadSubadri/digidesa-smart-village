<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rw extends Model
{
    protected $table = 'rws';

    protected $fillable = [
        'number', 'padukuhan_id', 'head_name', 'head_phone',
    ];

    public function padukuhan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class, 'rw_id');
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class, 'rw_id');
    }
}
