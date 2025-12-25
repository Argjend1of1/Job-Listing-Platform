<?php

use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('other roles are denied from deleting employers', function () {
    $user = createUser('employer');
    $employer = Employer::factory()->create();

    $this->assertModelExists($employer);

    $response = $this
        ->actingAs($user)
        ->delete("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertRedirectBack()
        ->assertSessionHas('message', 'You are not authorized for this action!');

    $this->assertModelExists($employer);
});

test('guest users cannot promote or demote employers', function () {
    $employer = Employer::factory()->create();

    $response = $this->patch("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertRedirect(route('login'));
});

test('guest users cannot delete employers', function () {
    $employer = Employer::factory()->create();
    $this->assertModelExists($employer);

    $response = $this->delete("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertRedirect(route('login'));

    $this->assertModelExists($employer);
});

test('admin receives not found when deleting non existent employer', function () {
    $admin = createUser('admin');

    $response = $this
        ->actingAs($admin)
        ->delete('/employers/999999');

//    dd($response);

    $response->assertStatus(302)
        ->assertSessionHas('error', 'The page you were looking for could not be found.');
});

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
        ->assertRedirectBack()
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
        ->assertRedirectBack()
        ->assertSessionHas(
            'message', 'Employer Demoted Successfully!'
        );

    $user->refresh();
    expect($user->role)->toBe('employer');
});

test('admin can delete an employer', function () {
    $admin = createUser('admin');
    $employer = Employer::factory()->create();
    $this->assertModelExists($employer);

    $response = $this
        ->actingAs($admin)
        ->delete("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertRedirectBack()
        ->assertSessionHas(
            'message', 'Employer removed successfully!'
        );

    $this->assertModelMissing($employer);
});

test("other roles are denied from updating employers' role", function () {
    $user = createUser('employer');
    $employer = Employer::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch("/employers/$employer->id");

    $response
        ->assertStatus(302)
        ->assertRedirectBack()
        ->assertSessionHas('message', 'You are not authorized for this action!');
});

function createUser($role, $id = 1): User
{
    return User::factory()->create([
        'role' => $role,
        'category_id' => $id
    ]);
}
