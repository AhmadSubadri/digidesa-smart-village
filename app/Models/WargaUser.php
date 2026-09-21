<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WargaUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'warga_users';

    protected $fillable = [
        'resident_id', 'nik', 'name', 'email', 'phone',
        'password', 'is_verified', 'verified_at', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'nik' => 'encrypted',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return $this->name ?? $this->resident?->full_name ?? 'Warga';
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function letterRequests(): HasMany
    {
        return $this->hasMany(LetterRequest::class);
    }
}
