<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    User::factory()->create([
        'email' => 'nuno@laravel.com',
        'password' => Hash::make('password'),
    ]);
});

test('user can login successfully', function () {

    $page = visit('/');

    $page
        ->click('Login')
        ->assertSee('Log In')
        ->assertPathIs('/login')
        ->fill('email', 'nuno@laravel.com')
        ->fill('password', 'password')
        ->click('button[type=submit]')
        ->wait(2)
        ->assertPathIs('/account')
        ->assertSee('Your Account Info');

    $this->assertAuthenticated();
});

test('user cannot login with wrong credentials', function () {
    $page = visit('/login');

    $page
        ->assertPathIs('/login')
        ->assertSee('Log In')
        ->fill('email', 'nuno@laravel.com')
        ->fill('password', 'passwordwrong')
        ->click('button[type=submit]')
        ->wait(2)
        ->assertSee('The provided credentials are incorrect.')
        ->assertPathIs('/login');

    $this->assertGuest();
});
