<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterRegister extends Model
{
    protected $fillable = [
        'register_type',
        'letter_number',
        'letter_date',
        'sender_or_recipient',
        'subject',
        'summary',
        'classification_code',
        'letter_request_id',
        'document_file_path',
        'archived_by',
    ];

    protected $casts = [
        'letter_date' => 'date',
    ];

    public function letterRequest(): BelongsTo
    {
        return $this->belongsTo(LetterRequest::class);
    }

    public function archivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    public function scopeOutgoing($query)
    {
        return $query->where('register_type', 'outgoing');
    }

    public function scopeIncoming($query)
    {
        return $query->where('register_type', 'incoming');
    }
}
