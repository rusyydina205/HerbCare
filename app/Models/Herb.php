<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Herb extends Model
{
    protected $table = 'herbs';
    protected $primaryKey = 'herbId';

    protected $fillable = [
        'herbName',
        'scientificName',
        'benefits',
        'preparation',
        'safety',
        'categoryId',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(HealthCategory::class, 'categoryId', 'categoryId');
    }

    public function symptoms(): BelongsToMany
    {
        return $this->belongsToMany(
            Symptom::class,
            'herbs_symptoms',
            'herbId',
            'symptomId',
            'herbId',
            'symptomId'
        );
    }

    public function herbSymptoms(): HasMany
    {
        return $this->hasMany(HerbSymptom::class, 'herbId', 'herbId');
    }

}
