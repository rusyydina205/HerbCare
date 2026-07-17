<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $primaryKey = 'messageId';

    protected $fillable = [
        'patientId',
        'subject',
        'message',
        'status',
        'reply',
        'replied_at',
        'is_read',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patientId', 'patientId');
    }
}
