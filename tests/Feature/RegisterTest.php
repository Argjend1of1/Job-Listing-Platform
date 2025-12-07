<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('local');
    $this->category = Category::create(['name' => 'Test']);
});

test('user can register without employer fields', function () {
    $response = $this->post('/register', [
        'name' => 'Normal User',
        'email' => 'user1@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'category' => $this->category->name,
        'logo' => UploadedFile::fake()->image('logo.png'),
    ]);

    $response
        ->assertStatus(302)
        ->assertValid()
        ->assertRedirect('/account')
        ->assertSessionHas('success', 'Registered Successfully!');

    $this->assertDatabaseHas('users', [
        'email' => 'user1@example.com',
        'role' => 'user'
    ]);
});

test('user can register as an employer', function () {
    $response = $this->post('/register', [
        'name' => 'Normal User',
        'email' => 'employer@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'category' => $this->category->name,
        'employer_id' => 'User Enterprise' //because it checks if null on controller
    ]);

    $response
        ->assertStatus(302)
        ->assertValid()
        ->assertRedirect('/account')
        ->assertSessionHas('success', 'Registered Successfully!');
});

test('registration fails if email is taken', function () {
    User::factory()->create([
        'email' => 'duplicate@example.com'
    ]);

    $response = $this->post('/register', [
        'name' => 'Duplicate',
        'email' => 'duplicate@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'logo' => UploadedFile::fake()->image('logo.png'),
        'category' => $this->category->name,
    ]);

    $response
        ->assertStatus(302)
        ->assertOnlyInvalid(['email'])
        ->assertRedirectBack()
        ->assertDontSee('role');
});
