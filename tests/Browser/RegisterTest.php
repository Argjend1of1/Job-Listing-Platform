<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->category = Category::create(['name' => 'Test Category']);
});

//test failing:::
test('user can register as a company', function () {
    $page = visit('/');

    $page
        ->click('Register')
        ->assertPathIs('/register')

        ->type('name', 'John Doe')
        ->type('email', 'john@example.com')
        ->type('password', 'password')
        ->type('password_confirmation', 'password')

//        ->attach('logo', 'C:\\Users\\Admin\\Downloads\\male-avatar.webp')

        ->select('category', $this->category->name)
        ->check('is_company')
        ->type('employer', 'Acme Corp')
        ->press('Create Account')
        ->wait(3);

    $this->assertAuthenticated();
});

