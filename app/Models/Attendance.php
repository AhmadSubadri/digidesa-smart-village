<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'official_id', 'date', 'check_in', 'check_out', 'status',
        'notes', 'latitude', 'longitude', 'photo_path',
    ];

    protected $casts = [
        'date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function official(): BelongsTo
    {
        return $this->belongsTo(Official::class);
    }
}
