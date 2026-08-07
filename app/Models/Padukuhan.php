<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Padukuhan extends Model
{
    protected $fillable = [
        'name', 'code', 'head_name', 'head_phone', 'area_size',
        'population', 'families_count', 'coordinates',
        'total_rt', 'total_rw', 'description', 'photo', 'sort_order',
    ];

    protected $casts = [
        'coordinates' => 'array',
        'area_size'   => 'float',
    ];

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }

    public function rws(): HasMany
    {
        return $this->hasMany(Rw::class);
    }

    public function officials(): HasMany
    {
        return $this->hasMany(Official::class);
    }

    public function posyanduUnits(): HasMany
    {
        return $this->hasMany(PosyanduUnit::class);
    }

    public function umkm(): HasMany
    {
        return $this->hasMany(Umkm::class);
    }

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }
}
