<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestBook extends Model
{
    protected $table = 'guest_books';

    protected $fillable = [
        'visitor_name', 'institution', 'purpose', 'phone', 'email',
        'message', 'photo_path', 'visited_at', 'responded_by', 'response',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function respondedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_by');
    }
}
