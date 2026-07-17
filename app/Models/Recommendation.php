<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    protected $table = 'recommendations';
    protected $primaryKey = 'recommendationId';

    protected $fillable = [
        'herbName',
        'patientId',
        'symptomId',
        'categoryId',
        'herbsId',
    ];

    /** The patient who received this recommendation */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patientId', 'patientId');
    }

    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class, 'symptomId', 'symptomId');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HealthCategory::class, 'categoryId', 'categoryId');
    }

    public function herb(): BelongsTo
    {
        return $this->belongsTo(Herb::class, 'herbsId', 'herbId');
    }
}
