<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StuntingRecord extends Model
{
    protected $table = 'stunting_records';

    protected $fillable = [
        'resident_id', 'posyandu_id', 'measurement_date', 'age_months',
        'weight_kg', 'height_cm', 'head_circumference', 'nutritional_status',
        'z_score_wfa', 'z_score_hfa', 'z_score_wfh',
        'immunization_status', 'notes', 'recorded_by',
    ];

    protected $casts = [
        'measurement_date' => 'date',
        'weight_kg' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'head_circumference' => 'decimal:2',
        'z_score_wfa' => 'decimal:2',
        'z_score_hfa' => 'decimal:2',
        'z_score_wfh' => 'decimal:2',
        'immunization_status' => 'array',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(PosyanduUnit::class, 'posyandu_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
