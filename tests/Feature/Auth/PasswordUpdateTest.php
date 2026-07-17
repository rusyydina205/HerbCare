<?php

use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this
        ->actingAs($patient, 'web')
        ->from('/profile')
        ->put('/password', [
            'current_password' => 'password',
            'password' => 'Newpassword123!',
            'password_confirmation' => 'Newpassword123!',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertTrue(Hash::check('Newpassword123!', $patient->refresh()->password));
});

test('correct password must be provided to update password', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this
        ->actingAs($patient, 'web')
        ->from('/profile')
        ->put('/password', [
            'current_password' => 'wrong-password',
            'password' => 'Newpassword123!',
            'password_confirmation' => 'Newpassword123!',
        ]);

    $response
        ->assertSessionHasErrorsIn('updatePassword', 'current_password')
        ->assertRedirect('/profile');
});
