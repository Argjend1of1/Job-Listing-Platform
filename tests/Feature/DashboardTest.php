<?php

use App\Models\Employer;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('employer can access the dashboard', function () {
    $user = User::factory()->create([
        'role' => 'employer'
    ]);

    Employer::factory()->create([
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson('/api/dashboard');

    $response->assertStatus(200)
        ->assertExactJson([
            'user' => $user->fresh()->load('employer.job')->toArray(),
            'jobs' => [],
            'message' => '(super)employer can access dashboard!',
        ]);
});

test('other roles beside (super)employer cannot access dashboard', function () {
    $user = User::factory()->create([
        'role' => 'admin'
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson('/api/dashboard');

    $response->assertStatus(403);
});

test('employer can edit their job', function () {
    [
        'user' => $user,
        'job' => $job
    ] = createUserWithJob();

    $response = $this
        ->actingAs($user)
        ->patchJson("/api/dashboard/edit/$job->id", [
            'title' => 'Updated Title',
            'schedule' => 'Full Time',
            'about' => 'This is a new job description.',
            'salary' => '3000'
        ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Job updated successfully!',
            'job' => [
                'title' => 'Updated Title',
                'salary' => '3000'
            ]
        ]);
});

test('employer can delete his job', function () {
    [
        'user' => $user,
        'job' => $job
    ] = createUserWithJob();

    $response = $this
        ->actingAs($user)
        ->deleteJson("/api/dashboard/edit/$job->id");

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Listing deleted successfully!'
        ]);
});

test("employer cannot delete others' jobs", function () {
    [
        'user' => $user,
        'job' => $job
    ] = createUserWithJob(false);

    $response = $this
        ->actingAs($user)
        ->deleteJson("/api/dashboard/edit/$job->id");

    $response
        ->assertStatus(403)
        ->assertJson([
            'message' => "Unauthorized to remove others' jobs!"
        ]);
});

function createUserWithJob($isOwner = true): array
{
    $user = User::factory()->create([
        'role' => 'employer'
    ]);

    Employer::factory()->create([
        'user_id' => $user->id
    ]);

    if(!$isOwner) {
        $employer = Employer::factory()->create();
    }

    $job = Job::factory()->create([
        'employer_id' => $isOwner ? $user->employer->id : $employer->id
    ]);

    return compact('user', 'job');
}
