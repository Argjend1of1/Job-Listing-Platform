<?php

use App\Models\Category;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('employer/superemployer can create a job', function () {
    $category = Category::create([
        'name' => 'testCategory'
    ]);

    $user = User::factory()->create([
        'role' => 'employer'
    ]);

    $user->employer()->create([
        'name' => 'Test Enterprise',
        'category_id' => $category->id
    ]);

    $response = $this
        ->actingAs($user)
        ->post('/jobs/create', [
            'title' => 'Senior Dev',
            'salary' => '70000',
            'location' => 'Remote',
            'schedule' => 'Full Time',
            'about' => 'We are hiring!',
            'url' => 'https://example.com',
            'tags' => 'php,laravel'
        ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('success', "Job Listed Successfully!");
});

test('superemployer job gets listed as a top job', function () {
    $category = Category::create([
        'name' => 'test'
    ]);

    $user = User::factory()->create([
        'category_id' => $category->id,
        'role' => 'superemployer'
    ]);


    Employer::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id
    ]);

    $response = $this
        ->actingAs($user)
        ->post('/jobs/create', [
            'title' => 'Top Job Title',
            'salary' => '60000',
            'location' => 'Prishtina',
            'schedule' => 'Full Time',
            'about' => 'This is a top job',
            'url' => 'https://example.com',
            'tags' => 'remote,urgent',
        ]);

    $response->assertStatus(302);

    $this->assertDatabaseHas('jobs', [
        'title' => 'Top Job Title',
        'top' => true,
    ]);
});

test('authenticated as a user cannot post jobs', function ()  {
    $user = User::factory()->create([
        'role' => 'user',
        'category_id' => 1
    ]);

    $response = $this
        ->actingAs($user)
        ->post('jobs/create', [
            'title' => 'Senior Dev',
            'salary' => '70000',
            'location' => 'Remote',
            'schedule' => 'Full Time',
            'about' => 'We are hiring!',
            'url' => 'https://example.com',
            'tags' => 'php,laravel'
        ]);

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});
