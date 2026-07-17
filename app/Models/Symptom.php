<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Symptom extends Model
{
    protected $table = 'symptoms';
    protected $primaryKey = 'symptomId';

    protected $fillable = [
        'symptomName',
        'description',
        'categoryId',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(HealthCategory::class, 'categoryId', 'categoryId');
    }

    public function herbs(): BelongsToMany
    {
        return $this->belongsToMany(
            Herb::class,
            'herbs_symptoms',
            'symptomId',
            'herbId',
            'symptomId',
            'herbId'
        );
    }

}
