<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

uses(RefreshDatabase::class);

test('user can log in with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'john@example.com',
        'password' => Hash::make('password123')
    ]);

//    $this->withMiddleware([
//        EncryptCookies::class,
//        AddQueuedCookiesToResponse::class,
//        StartSession::class,
//    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'john@example.com',
        'password' => 'password123'
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Logged in successfully!',
            'user' => [
                'email' => 'john@example.com'
            ]
        ]);

    $this->assertAuthenticatedAs($user);
});

test('user cannot login with invalid credentials', function () {
    User::factory()->create([
        'email' => 'jane@example.com',
        'password' => Hash::make('rightPass')
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'jane@example.com',
        'password' => 'wrongPass'
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'message' => 'The provided credentials are incorrect.'
        ]);
});

test('guest middleware blocks the logged user from accessing login page', function () {
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum');

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'pass123'
    ]);


    $response->assertStatus(302);
});
