<?php

use App\Models\Category;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

test('employer/superemployer can create a job', function () {
    $category = Category::create([
        'name' => 'testCategory'
    ]);

    $user = User::factory()->create([
        'role' => 'employer'
    ]);

    $user->employer()->create([
        'name' => 'Example Enterprise',
        'category_id' => $category->id
    ]);

//    $this -> refers to the test class instance,
//    which extends Illuminate\Foundation\Testing\TestCase.
    $response = $this
        ->actingAs($user)
        ->postJson('/api/jobs/create', [
            'title' => 'Senior Dev',
            'salary' => '70000',
            'location' => 'Remote',
            'schedule' => 'Full Time',
            'about' => 'We are hiring!',
            'url' => 'https://example.com',
            'tags' => 'php,laravel'
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Job Listed Successfully!',
            'jobs' => [
                'title' => 'Senior Dev',
            ]
        ]);
});

test('superemployer job gets listed as a top job', function () {
    $user = User::factory()->create([
        'role' => 'superemployer'
    ]);

    $category = Category::create([
        'name' => 'test'
    ]);

    Employer::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id
    ]);

    $response = $this
        ->actingAs($user)
        ->postJson('/api/jobs/create', [
            'title' => 'Top Job Title',
            'salary' => '60000',
            'location' => 'Prishtina',
            'schedule' => 'Full Time',
            'about' => 'This is a top job',
            'url' => 'https://example.com',
            'tags' => 'remote,urgent',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Job Listed Successfully!',
            'jobs' => [
                'title' => 'Top Job Title',
                'top' => true
            ]
        ]);
});

test('authenticated as a user cannot post jobs', function ()  {
    $user = User::factory()->create([
        'role' => 'user'
    ]);

    $response = $this
        ->actingAs($user)
        ->postJson('/api/jobs/create', [
            'title' => 'Senior Dev',
            'salary' => '70000',
            'location' => 'Remote',
            'schedule' => 'Full Time',
            'about' => 'We are hiring!',
            'url' => 'https://example.com',
            'tags' => 'php,laravel'
        ]);

    $response->assertStatus(403)
        ->assertJson([
            'message' => 'Unauthorized: Insufficient permissions.'
        ]);
});
