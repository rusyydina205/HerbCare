<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HerbSymptom extends Model
{
    protected $table = 'herbs_symptoms';
    protected $primaryKey = 'herbSymptomId';

    protected $fillable = [
        'herbId',
        'symptomId',
        'categoryId',
    ];

    public function herb(): BelongsTo
    {
        return $this->belongsTo(Herb::class, 'herbId', 'herbId');
    }

    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class, 'symptomId', 'symptomId');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HealthCategory::class, 'categoryId', 'categoryId');
    }
}
