<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->category = Category::create(['name' => 'testCategory']);
});

test('employer/superemployer can create a job', function () {
    $user = createEmployerUser();
    $response = postJob($user);

    $response
        ->assertStatus(302)
        ->assertRedirect('/dashboard')
        ->assertSessionHas('success', "Job Listed Successfully!");
});

test('superemployer job gets listed as a top job', function () {
    $user = createEmployerUser('superemployer');
    $response = postJob($user, ['title' => 'Top Job Title']);

    $response->assertStatus(302);

    $this->assertDatabaseHas('jobs', [
        'title' => 'Top Job Title',
        'top' => true,
    ]);
});

test('authenticated as a user cannot post jobs', function ()  {
    $user = User::factory()->create(['role' => 'user', 'category_id' => 1]);
    $response = postJob($user);

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});

function createEmployerUser(string $role = 'employer'): User
{
    $user = User::factory()->create(['role' => $role, 'category_id' => 1]);
    $user->employer()->create([
        'name' => $role === 'superemployer' ? 'Super Enterprise' : 'Test Enterprise',
        'category_id' => 1,
    ]);
    return $user;
}

function postJob(User $user, array $overrides = [])
{
    $defaults = [
        'title' => 'Senior Dev',
        'salary' => '70000',
        'location' => 'Remote',
        'schedule' => 'Full Time',
        'about' => 'We are hiring!',
        'url' => 'https://facebook.com',
        'tags' => 'php,laravel',
    ];

    return test()
        ->actingAs($user)
        ->post('/jobs/create', array_merge($defaults, $overrides));
}

