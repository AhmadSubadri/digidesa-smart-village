<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class Resident extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'nik', 'kk_number', 'full_name', 'birth_place', 'birth_date',
        'gender', 'blood_type', 'religion', 'marital_status', 'education_level',
        'occupation', 'citizenship', 'address', 'padukuhan_id', 'rt_id', 'rw_id',
        'family_id', 'photo_path', 'father_nik', 'mother_nik',
        'is_head_of_family', 'disability_type', 'status',
        'moved_date', 'death_date', 'notes',
    ];

    protected $casts = [
        'birth_date'       => 'date',
        'moved_date'       => 'date',
        'death_date'       => 'date',
        'is_head_of_family' => 'boolean',
    ];

    // Encrypted attributes — auto-encrypt/decrypt
    public function setNikAttribute(string $value): void
    {
        $this->attributes['nik'] = Crypt::encryptString($value);
    }

    public function getNikAttribute(string $value): string
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception) {
            return $value;
        }
    }

    public function setFullNameAttribute(string $value): void
    {
        $this->attributes['full_name'] = Crypt::encryptString($value);
    }

    public function getFullNameAttribute(string $value): string
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception) {
            return $value;
        }
    }

    public function setKkNumberAttribute(string $value): void
    {
        $this->attributes['kk_number'] = Crypt::encryptString($value);
    }

    public function getKkNumberAttribute(string $value): string
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception) {
            return $value;
        }
    }

    // Relationships
    public function padukuhan(): BelongsTo
    {
        return $this->belongsTo(Padukuhan::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function letterRequests(): HasMany
    {
        return $this->hasMany(LetterRequest::class);
    }

    public function stuntingRecords(): HasMany
    {
        return $this->hasMany(StuntingRecord::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeMale($query)
    {
        return $query->where('gender', 'L');
    }

    public function scopeFemale($query)
    {
        return $query->where('gender', 'P');
    }

    // Helpers
    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }
}
