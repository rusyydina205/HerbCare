<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $table = $user instanceof \App\Models\Practitioner ? 'practitioners' : 'patients';
        $primaryKey = $user instanceof \App\Models\Practitioner ? 'practitionerId' : 'patientId';

        $rules = [
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255', 
                Rule::unique($table)->ignore($user->$primaryKey, $primaryKey)
            ],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,gif,webp', 'max:2048'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9]+$/'],
        ];

        return $rules;
    }
}
