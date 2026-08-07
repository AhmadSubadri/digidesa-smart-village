<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialAidProgram extends Model
{
    protected $table = 'social_aid_programs';

    protected $fillable = [
        'name', 'code', 'description', 'source', 'period_start',
        'period_end', 'budget', 'managing_agency', 'is_active',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'budget' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function recipients(): HasMany
    {
        return $this->hasMany(SocialAidRecipient::class, 'program_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
