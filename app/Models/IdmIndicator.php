<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdmIndicator extends Model
{
    protected $table = 'idm_indicators';

    protected $fillable = [
        'idm_score_id', 'dimension', 'indicator_name',
        'score', 'weight', 'description', 'recommendation',
    ];

    protected $casts = [
        'score' => 'decimal:4',
        'weight' => 'decimal:4',
    ];

    public function idmScore(): BelongsTo
    {
        return $this->belongsTo(IdmScore::class);
    }
}
