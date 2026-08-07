<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LetterLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'letter_request_id', 'action', 'performed_by', 'notes',
        'old_status', 'new_status', 'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function letterRequest(): BelongsTo
    {
        return $this->belongsTo(LetterRequest::class);
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
