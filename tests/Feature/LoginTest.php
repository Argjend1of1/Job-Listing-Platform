<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

uses(RefreshDatabase::class);

test('user can log in with valid credentials', function () {
    $user = createUserForLogin('password123');

    $response = $this->post('/login', [
        'email' => 'jane@example.com',
        'password' => 'password123'
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirect('/account')
        ->assertSessionHas('success', "Logged In Successfully!");

    $this->assertAuthenticatedAs($user);
});

test('user cannot login with invalid credentials', function () {
    createUserForLogin('rightPass');

    $response = $this->postJson('/login', [
        'email' => 'jane@example.com',
        'password' => 'wrongPass'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors('password');
});

test('guest middleware blocks the logged user from accessing login page', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'pass123'
    ]);


    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});

function createUserForLogin(string $password): User
{
    return User::factory()->create([
        'email' => 'jane@example.com',
        'password' => Hash::make($password)
    ]);
}
