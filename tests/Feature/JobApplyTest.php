<?php

use App\Models\Application;
use App\Models\Job;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('authenticated with user role can apply for a job', function () {
    Storage::fake('local');

    $job = Job::factory()->create();

    $user = User::factory()->create([
        'role' => 'user'
    ]);
    $this->actingAs($user);

    $fakeResume = UploadedFile::fake()->create('resume.pdf');
    $path = $fakeResume->store('resumes', 'local');

    Resume::create([
        'user_id' => $user->id,
        'file_path' => $path
    ]);

    // Ensure the resume was stored and saved
    Storage::disk('local')->assertExists($path);
    $this->assertDatabaseHas('resumes', [
        'user_id' => $user->id,
        'file_path' => $path
    ]);

    $response = $this->postJson('/api/jobs/' . $job->id . '/apply');

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Application submitted successfully!'
        ]);

    $this->assertDatabaseHas('applications', [
        'user_id' => $user->id,
        'job_id' => $job->id
    ]);
});

test('unauthenticated user cannot apply for a job', function () {
    $job = Job::factory()->create();

    $response = $this->postJson("/api/jobs/$job->id/apply");

    $response
        ->assertStatus(401)
        ->assertJson([
            'message' => 'You need to be logged in to apply for this job!'
        ]);
});

test('user cannot apply without resume', function () {
    $job = Job::factory()->create();
    $user = User::factory()->create([
        'name' => 'testUser'
    ]);

    $response = $this
        ->actingAs($user)
        ->postJson("/api/jobs/$job->id/apply");

    $response
        ->assertStatus(422)
        ->assertJson([
            'message' => 'Please upload your resume before applying!'
        ]);
});

test('user cannot apply twice for the same job', function () {
    $job = Job::factory()->create();
    $user = User::factory()->create([
        'name' => 'testUser'
    ]);

    $fakeResume = UploadedFile::fake()->create('resume.pdf');
    $path = $fakeResume->store('resumes', 'local');

    Resume::create([
        'user_id' => $user->id,
        'file_path' => $path
    ]);

    Application::create([
        'user_id' => $user->id,
        'job_id' => $job->id
    ]);

    // Ensure the resume was stored and saved
    Storage::disk('local')->assertExists($path);
    $this->assertDatabaseHas('resumes', [
        'user_id' => $user->id,
        'file_path' => $path
    ]);

    $response = $this
        ->actingAs($user)
        ->postJson("/api/jobs/$job->id/apply");

    $response
        ->assertStatus(404)
        ->assertJson([
            'message' => 'You already applied for this Job!'
        ]);
});
