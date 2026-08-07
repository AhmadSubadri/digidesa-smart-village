<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IdmScore extends Model
{
    protected $table = 'idm_scores';

    protected $fillable = [
        'year', 'total_score', 'status', 'ike_score', 'ikl_score', 'iks_score',
        'national_rank', 'provincial_rank', 'district_rank',
        'data_source_url', 'notes', 'published_at',
    ];

    protected $casts = [
        'total_score' => 'decimal:4',
        'ike_score' => 'decimal:4',
        'ikl_score' => 'decimal:4',
        'iks_score' => 'decimal:4',
        'published_at' => 'datetime',
    ];

    public function indicators(): HasMany
    {
        return $this->hasMany(IdmIndicator::class, 'idm_score_id');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('year', 'desc');
    }
}
