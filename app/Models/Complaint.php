<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    protected $fillable = [
        'ticket_number', 'name', 'nik', 'email', 'phone', 'category',
        'subject', 'message', 'attachments', 'location', 'status', 'priority',
        'response', 'responded_by', 'responded_at', 'resolved_at',
        'satisfaction_rating', 'is_anonymous', 'is_public',
    ];

    protected $casts = [
        'nik' => 'encrypted',
        'attachments' => 'array',
        'responded_at' => 'datetime',
        'resolved_at' => 'datetime',
        'is_anonymous' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function respondedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->ticket_number = 'ADU-' . now()->format('Ymd') . '-' . str_pad(
                static::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT
            );
        });
    }
}
