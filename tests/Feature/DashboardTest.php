<?php

use App\Models\Employer;
use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

test('employer can access the dashboard', function () {
    $user = createUser('employer');

    Employer::factory()->create([
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response
        ->assertStatus(200)
        ->assertInertia(function (AssertableInertia $page) use ($user) {
            $page
                ->component('dashboard/Index')
                ->has('user', fn($userProp) =>
                    $userProp
                        ->where('id', $user->id)
                        ->where('role', 'employer')
                        ->etc()
                )
                ->has('logo')
                ->has('jobs');
        });
});

test('other roles beside (super)employer cannot access dashboard', function () {
    $user = createUser('admin');

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});

test('employer can edit their job', function () {
    [
        'user' => $user,
        'job' => $job
    ] = createUserWithJob();

    $response = $this
        ->actingAs($user)
        ->patch("/dashboard/edit/$job->id", [
            'title' => 'Updated Title',
            'schedule' => 'Full Time',
            'about' => 'This is a new job description.',
            'salary' => '3000'
        ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('success', 'Listing updated successfully!');
});

test("employer cannot edit others' jobs", function () {
    [
        'user' => $user,
        'job' => $job
    ] = createUserWithJob();

    [
        'user' => $user2,
        'job' => $job2
    ] = createUserWithJob();

    $response = $this
        ->actingAs($user)
        ->patch("/dashboard/edit/$job2->id", [
            'title' => 'Updated Title',
            'schedule' => 'Full Time',
            'about' => 'This is a new job description.',
            'salary' => '3000'
        ]);

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});

test('employer can delete his job', function () {
    [
        'user' => $user,
        'job' => $job
    ] = createUserWithJob();

    $response = $this
        ->actingAs($user)
        ->delete("/dashboard/edit/$job->id");

    $response
        ->assertStatus(302)
        ->assertRedirect('/dashboard')
        ->assertSessionHas('success', 'Listing deleted successfully!');
});

test("employer cannot delete others' jobs", function () {
    [
        'user' => $user,
        'job' => $job
    ] = createUserWithJob();

    [
        'user' => $user2,
        'job' => $job2
    ] = createUserWithJob();

    $response = $this
        ->actingAs($user)
        ->delete("/api/dashboard/edit/$job2->id");

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});

function createUserWithJob(): array
{
    $user = createUser('employer');

    $employer = Employer::factory()->create([
        'user_id' => $user->id,
        'category_id' => $user->category_id
    ]);

    $job = Job::factory()->create([
        'employer_id' => $employer->id
    ]);

    return compact('user', 'job');
}

