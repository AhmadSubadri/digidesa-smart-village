<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SdgsScore extends Model
{
    protected $table = 'sdgs_scores';

    protected $fillable = [
        'sdgs_goal_id', 'year', 'score', 'status',
        'indicators_data', 'notes', 'updated_by',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'indicators_data' => 'array',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(SdgsGoal::class, 'sdgs_goal_id');
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
