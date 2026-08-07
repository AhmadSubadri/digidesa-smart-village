<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SdgsGoal extends Model
{
    protected $table = 'sdgs_goals';

    protected $fillable = [
        'number', 'name', 'description', 'icon', 'color',
    ];

    public function scores(): HasMany
    {
        return $this->hasMany(SdgsScore::class);
    }

    public function latestScore(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SdgsScore::class)->orderBy('year', 'desc');
    }
}
