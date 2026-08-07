<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandRecord extends Model
{
    protected $table = 'land_records';

    protected $fillable = [
        'certificate_number', 'owner_resident_id', 'owner_name',
        'land_type', 'area_m2', 'address', 'padukuhan_id',
        'ownership_type', 'coordinates', 'tax_number', 'notes', 'status',
    ];

    protected $casts = [
        'certificate_number' => 'encrypted',
        'owner_name' => 'encrypted',
        'tax_number' => 'encrypted',
        'coordinates' => 'array',
        'area_m2' => 'decimal:2',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'owner_resident_id');
    }

    public function padukuhan(): BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }
}
