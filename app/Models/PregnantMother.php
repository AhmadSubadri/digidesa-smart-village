<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PregnantMother extends Model
{
    protected $table = 'pregnant_mothers';

    protected $fillable = [
        'resident_id', 'posyandu_id', 'pregnancy_start_date',
        'estimated_delivery_date', 'checkup_count', 'high_risk',
        'blood_type', 'complications', 'status', 'delivery_date',
        'delivery_type', 'baby_weight', 'baby_height', 'notes', 'recorded_by',
    ];

    protected $casts = [
        'pregnancy_start_date' => 'date',
        'estimated_delivery_date' => 'date',
        'delivery_date' => 'date',
        'high_risk' => 'boolean',
        'complications' => 'array',
        'baby_weight' => 'decimal:2',
        'baby_height' => 'decimal:2',
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
