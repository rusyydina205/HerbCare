<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Practitioner extends Authenticatable
{
    use HasFactory, Notifiable;

    public function isPractitioner(): bool { return true; }
    public function isPatient(): bool { return false; }

    protected $table = 'practitioners';
    protected $primaryKey = 'practitionerId';

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

    public function messages()
    {
        return $this->hasMany(Message::class, 'practitionerId', 'practitionerId');
    }
}
