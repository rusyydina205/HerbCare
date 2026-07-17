<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthCategory extends Model
{
    protected $table = 'health_categories';
    protected $primaryKey = 'categoryId';

    protected $fillable = [
        'categoryName',
    ];

    public function herbs(): HasMany
    {
        return $this->hasMany(Herb::class, 'categoryId', 'categoryId');
    }

    public function symptoms(): HasMany
    {
        return $this->hasMany(Symptom::class, 'categoryId', 'categoryId');
    }
}
