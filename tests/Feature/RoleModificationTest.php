<?php

use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can promote an employer', function () {
    $admin = createUser('admin');
    $user = createUser('employer');

    $response = $this
        ->actingAs($admin)
        ->patchJson("/api/employers/$user->id", [
            'role' => 'superemployer'
        ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Employer Promoted Successfully!'
        ]);

    $user->refresh();
    expect($user->role)->toBe('superemployer');
});

test('admin can demote a superemployer', function () {
    $admin = createUser('admin');
    $user = createUser('superemployer');
    Employer::factory()->create([
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($admin)
        ->patchJson("/api/premiumEmployers/$user->id", [
            'role' => 'employer'
        ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Superemployer Demoted Successfully!'
        ]);

    $user->refresh();
    expect($user->role)->toBe('employer');
});

test('admin can delete employer', function () {
    $user = createUser('admin');
    $employer = Employer::factory()->create();

    $response = $this
        ->actingAs($user)
        ->deleteJson("/api/employers/$employer->id");

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Employer deleted successfully!'
        ]);
});

test('other roles receive a 403 when trying to edit an employer', function () {
    $user = createUser('employer');
    $employer = Employer::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patchJson("/api/employers/$employer->id");

    $response->assertStatus(403);
});

test('other roles receive a 403 when trying to delete an employer', function () {
    $user = createUser('superemployer');
    $employer = Employer::factory()->create();

    $response = $this
        ->actingAs($user)
        ->deleteJson("/api/employers/$employer->id");

    $response->assertStatus(403);
});

function createUser($role, $id = 1){
    return User::factory()->create([
        'role' => $role,
        'category_id' => $id
    ]);
}
