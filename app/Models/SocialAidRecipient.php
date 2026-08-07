<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialAidRecipient extends Model
{
    protected $table = 'social_aid_recipients';

    protected $fillable = [
        'program_id', 'resident_id', 'family_id', 'amount',
        'period_month', 'period_year', 'status',
        'distribution_date', 'notes', 'verified_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'distribution_date' => 'date',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(SocialAidProgram::class, 'program_id');
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
