<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterRequest extends Model
{
    protected $fillable = [
        'request_number', 'resident_id', 'warga_user_id', 'letter_type_id',
        'status', 'form_data', 'attachments', 'notes', 'rejection_reason',
        'verified_by', 'verified_at', 'processed_by', 'processed_at',
        'signed_by', 'signed_at', 'completed_at',
        'pdf_path', 'qr_code_token', 'signature_image_path', 'letter_number',
    ];

    protected $casts = [
        'form_data' => 'array',
        'attachments' => 'array',
        'verified_at' => 'datetime',
        'processed_at' => 'datetime',
        'signed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function wargaUser(): BelongsTo
    {
        return $this->belongsTo(WargaUser::class);
    }

    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function signedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LetterLog::class)->orderBy('created_at');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->request_number = 'REQ-' . now()->format('Ymd') . '-' . str_pad(
                static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT
            );
        });
    }
}
