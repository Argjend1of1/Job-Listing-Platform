<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('user can register without employer fields', function () {
    Storage::fake('local');//simulate storage

    Category::create(['name' => 'Teestttt']);

    $response = $this->postJson('/api/register', [
        'name' => 'Normal User',
        'email' => 'user1@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'category' => 'Teestttt',
        'employer' => null //because it checks if null on controller || PRECAUTION!!
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Successfully Registered!',
            'user' => ['email' => 'user1@example.com'],
            'employer' => null
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'user1@example.com',
        'role' => 'user'
    ]);
});

test('user can register as an employer', function () {
    Storage::fake('local');

    Category::create(['name' => 'Test']);

    $response = $this->postJson('/api/register', [
        'name' => 'Normal User',
        'email' => 'employer@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'category' => 'Test',
        'employer' => 'User Enterprise' //because it checks if null on controller
    ]);

//    dd($response);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Successfully Registered!',
            'user' => ['email' => 'employer@example.com'],
            'employer' => ['name' => 'User Enterprise'],
        ]);
});

test('registration fails if email is taken', function () {
    User::factory()->create([
        'email' => 'duplicate@example.com'
    ]);
    Category::create(['name' => 'test']);

    Storage::fake('local');

    $response = $this->postJson('/api/register', [
        'name' => 'Duplicate',
        'email' => 'duplicate@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'category' => 'test',
        'employer' => null
    ]);

    $response->assertStatus(409);
});

