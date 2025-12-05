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

    $response = $this
        ->actingAs($user)
        ->post('/jobs/' . $job->id . '/apply');

    $response
        ->assertStatus(302)
        ->assertSessionHas(
            'completed', 'Application submitted successfully!'
        );

    $this->assertDatabaseHas('applications', [
        'user_id' => $user->id,
        'job_id' => $job->id
    ]);
});

test('unauthenticated user cannot apply for a job', function () {
    $job = Job::factory()->create();

    $response = $this->post("/jobs/$job->id/apply");

    $response
        ->assertStatus(302)
        ->assertRedirect('/login');
});

test('user cannot apply without resume', function () {
    $job = Job::factory()->create();
    $user = User::factory()->create([
        'role' => 'user'
    ]);

    $response = $this
        ->actingAs($user)
        ->post("/jobs/$job->id/apply");

    $response
        ->assertStatus(302)
        ->assertSessionHas(
            'message', 'Please upload your resume before applying!'
        );
});

test('user cannot apply twice for the same job', function () {
    $job = Job::factory()->create();
    $user = User::factory()->create([
        'role' => 'user'
    ]);

    $fakeResume = UploadedFile::fake()->create('resume.pdf');
    $path = $fakeResume->store('resumes', 'local');

    /**
     * Insert the Resume and Application first and then send the request
     */
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
        ->post("/jobs/$job->id/apply");

    $response
        ->assertStatus(302)
        ->assertSessionHas(
            'message', 'You already applied for this job!'
        );
});
