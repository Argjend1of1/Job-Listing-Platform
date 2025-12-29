<?php

use App\Models\Category;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->category = Category::create(['name' => 'Test Category']);
});

test('registration page loads and can submit a company registration', function () {
    Event::fake();

    $page = visit('/register');

    // Assert form elements exist and the page loads correctly
    $page->assertSee('Name')
        ->assertSee('Email')
        ->assertSee('Password')
        ->assertSee('Category')
        ->assertSee("I'm registering as a company")
        ->assertSee('Create Account');

    $page->fill('name', 'John Doe')
        ->fill('email', 'john@example.com')
        ->fill('password', 'password')
        ->fill('password_confirmation', 'password')

        ->select('category', $this->category->name)
        ->assertVisible('input[name=is_company]')// won't work with React's internal state on browser testing
        ->screenshot()
        ->press('Create Account')
        ->wait(2);

    // Backend assertions: user should be authenticated and event fired
    $this->assertAuthenticated();
    Event::assertDispatched(Registered::class);
});


