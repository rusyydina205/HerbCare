<?php

use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

test('profile page is displayed', function () {
    $user = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this
        ->actingAs($user, 'web')
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = Patient::create([
        'name' => 'Original Name',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this
        ->actingAs($user, 'web')
        ->patch('/profile', [
            'email' => 'test@example.com',
            'phone' => '0123456789',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Original Name', $user->name); // Name must remain unchanged
    $this->assertSame('test@example.com', $user->email);
    $this->assertSame('0123456789', $user->phone);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);
    $user->email_verified_at = now();
    $user->save();

    $response = $this
        ->actingAs($user, 'web')
        ->patch('/profile', [
            'email' => $user->email,
            'phone' => '1234567890',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = Patient::create([
        'name' => 'Test Patient',
        'email' => 'patient@test.com',
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    $response = $this
        ->actingAs($user, 'web')
        ->delete('/profile');

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});
