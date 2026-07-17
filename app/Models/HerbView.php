<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HerbView extends Model
{
    public $timestamps = false;

    protected $table = 'herb_views';

    protected $fillable = [
        'patientId',
        'herbId',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function herb(): BelongsTo
    {
        return $this->belongsTo(Herb::class, 'herbId', 'herbId');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patientId', 'patientId');
    }
}
