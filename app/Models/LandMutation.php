<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandMutation extends Model
{
    protected $table = 'land_mutations';

    protected $fillable = [
        'land_record_id',
        'mutation_date',
        'mutation_type',
        'old_owner_name',
        'new_owner_name',
        'new_owner_nik',
        'area_transferred_m2',
        'remaining_area_m2',
        'deed_number',
        'notary_name',
        'notes',
        'document_scan_path',
    ];

    protected $casts = [
        'mutation_date' => 'date',
        'new_owner_nik' => 'encrypted',
        'area_transferred_m2' => 'decimal:2',
        'remaining_area_m2' => 'decimal:2',
    ];

    public function landRecord(): BelongsTo
    {
        return $this->belongsTo(LandRecord::class);
    }
}
