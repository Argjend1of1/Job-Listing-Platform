<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

test('user can register without employer fields', function () {
    Storage::fake('local');//simulate storage

    $response = $this->postJson('/api/register', [
        'name' => 'Normal User',
        'email' => 'user@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'employer' => null //because it checks if null on controller
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Successfully Registered!',
            'user' => ['email' => 'user@example.com'],
            'employer' => null
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'user@example.com',
        'role' => 'user'
    ]);
});

test('user can register as an employer', function () {
    Storage::fake('local');

    Category::create(['name' => 'test']);

    $response = $this->postJson('/api/register', [
        'name' => 'Normal User',
        'email' => 'employer@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'employer' => 'User Enterprise', //because it checks if null on controller
        'category' => "test"
    ]);

//    dd($response);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Successfully Registered!',
            'user' => ['email' => 'employer@example.com'],
            'employer' => ['name' => 'User Enterprise'],
        ]);
});

test('employer registration fails without category', function () {
    Storage::fake('local');

    $response = $this->postJson('/api/register', [
        'name' => 'Company Admin',
        'email' => 'employer2@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'employer' => 'Tech Corp',
        // missing 'category'
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'message' => 'A company must belong to a category.'
        ]);
});

test('registration fails if email is taken', function () {
    User::factory()->create([
        'email' => 'duplicate@example.com'
    ]);

    Storage::fake('local');

    $response = $this->postJson('/api/register', [
        'name' => 'Duplicate',
        'email' => 'duplicate@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'employer' => null
    ]);

    $response->assertStatus(409);
});

