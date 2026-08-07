<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    protected $fillable = [
        'kk_number', 'padukuhan_id', 'rt_id', 'rw_id', 'address',
        'economic_status', 'house_ownership', 'house_condition', 'status',
    ];

    protected $casts = [
        'kk_number' => 'encrypted',
    ];

    public function padukuhan(): BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function head(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Resident::class)->where('is_head_of_family', true);
    }

    public function socialAidRecipients(): HasMany
    {
        return $this->hasMany(SocialAidRecipient::class);
    }
}
