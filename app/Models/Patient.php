<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    public function isPatient(): bool { return true; }
    public function isPractitioner(): bool { return false; }

    protected $table = 'patients';
    protected $primaryKey = 'patientId';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class, 'patientId', 'patientId');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'patientId', 'patientId');
    }
}
