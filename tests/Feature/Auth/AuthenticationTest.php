<?php

use App\Models\Patient;
use App\Models\Practitioner;
use Illuminate\Support\Facades\Hash;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('patients can authenticate using the login screen', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'patient@test.com',
        'password' => 'password',
        'role' => 'patient',
    ]);

    $this->assertAuthenticated('web');
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('practitioners can authenticate using the login screen', function () {
    $practitioner = Practitioner::create([
        'name' => 'Test Practitioner',
        'email' => 'practitioner@test.com',
        'phone' => '0987654321',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'practitioner@test.com',
        'password' => 'password',
        'role' => 'practitioner',
    ]);

    $this->assertAuthenticated('practitioner');
    $response->assertRedirect(route('practitioner.dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $this->post('/login', [
        'email' => 'patient@test.com',
        'password' => 'wrong-password',
        'role' => 'patient',
    ]);

    $this->assertGuest();
});

test('home page keeps login and sign up actions instead of dashboard for authenticated visitors', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($patient, 'web')->get('/');

    $response->assertOk();
    $response->assertSee('Login');
    $response->assertSee('Sign Up Now');
    $response->assertDontSee('DASHBOARD');
});

test('patients can logout', function () {
    $patient = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($patient, 'web')->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('practitioners can logout', function () {
    $practitioner = Practitioner::create([
        'name' => 'Test Practitioner',
        'email' => 'practitioner@test.com',
        'phone' => '0987654321',
        'password' => Hash::make('password'),
    ]);

    $response = $this->actingAs($practitioner, 'practitioner')->post('/logout');

    $this->assertGuest('practitioner');
    $response->assertRedirect('/');
});
