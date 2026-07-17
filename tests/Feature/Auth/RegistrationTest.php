<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new patients can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test Patient',
        'email' => 'test_patient@example.com',
        'phone' => '1234567890',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'role' => 'patient',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('login'));
    
    $this->assertDatabaseHas('patients', [
        'email' => 'test_patient@example.com',
    ]);
});

test('new practitioners can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test Practitioner',
        'email' => 'test_practitioner@example.com',
        'phone' => '0987654321',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
        'role' => 'practitioner',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('login'));

    $this->assertDatabaseHas('practitioners', [
        'email' => 'test_practitioner@example.com',
    ]);
});
