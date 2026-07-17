<?php

use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

test('confirm password screen can be rendered', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($patient, 'web')->get('/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($patient, 'web')->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($patient, 'web')->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
