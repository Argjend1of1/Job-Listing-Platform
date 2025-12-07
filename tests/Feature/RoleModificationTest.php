<?php

use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can promote an employer', function () {
    $admin = createUser('admin');
    $user = createUser('employer');
    $employer = Employer::factory()->create([
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($admin)
        ->patch("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertSessionHas(
            'message', 'Employer Promoted Successfully!'
        );

    $user->refresh();
    expect($user->role)->toBe('superemployer');
});

test('admin can demote a superemployer', function () {
    $admin = createUser('admin');
    $user = createUser('superemployer');
    $employer = Employer::factory()->create([
        'user_id' => $user->id
    ]);

    $response = $this
        ->actingAs($admin)
        ->patch("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertSessionHas(
            'message', 'Employer Demoted Successfully!'
        );

    $user->refresh();
    expect($user->role)->toBe('employer');
});

test('admin can delete an employer', function () {
    $admin = createUser('admin');
    $employer = Employer::factory()->create();

    $response = $this
        ->actingAs($admin)
        ->delete("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertSessionHas(
            'message', 'Employer removed successfully!'
        );

    $this->assertDatabaseMissing('employers', [
        'id' => $employer->id
    ]);
});

test("other roles are denied from updating employers' role", function () {
    $user = createUser('employer');
    $employer = Employer::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertRedirect('/')
        ->assertSessionHas('message', 'You are not authorized for this action!');
});

function createUser($role, $id = 1){
    return User::factory()->create([
        'role' => $role,
        'category_id' => $id
    ]);
}
