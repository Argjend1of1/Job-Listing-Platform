<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('superadmin can promote user to admin', function () {
    $superadmin = createUser('superadmin');
    $user = createUser('user');

    $response = $this
        ->actingAs($superadmin)
        ->patchJson("/api/admins/create/$user->id", [
            'role' => 'admin'
        ]);

//    dd($response);

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'User Promoted Successfully!',
            'user' => [
                'name' => $user->name
            ]
        ]);

    $user->refresh();
    expect($user->role)->toBe('admin');
});

test('superadmin can demote an admin', function () {
    $superadmin = createUser('superadmin');
    $user = createUser('admin');

    $response = $this
        ->actingAs($superadmin)
        ->patchJson("/api/admins/$user->id", [
            'role' => 'user'
        ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => "Admin Demoted Successfully!"
        ]);

    $user->refresh();
    expect($user->role)->toBe('user');
});

test('admin cannot promote user to admin', function () {
    $admin = createUser('admin');
    $user = createUser('user');

    $response = $this
        ->actingAs($admin)
        ->patchJson("/api/admins/create/$user->id", [
            'role' => 'user'
        ]);

    $response->assertStatus(403);
});

test('admin cannot demote admin to user', function () {
    $admin = createUser('admin');
    $user = createUser('admin');

    $response = $this
        ->actingAs($admin)
        ->patchJson("/api/admins/$user->id", [
            'role' => 'user'
        ]);

    $response->assertStatus(403);
});

test('superemployer cannot promote user to admin', function () {
    $superemployer = createUser('superemployer');
    $user = createUser('user');

    $response = $this
        ->actingAs($superemployer)
        ->patchJson("/api/admins/$user->id", [
            'role' => 'admin'
        ]);

    $response->assertStatus(403);
});

test('superemployer cannot demote user to admin', function () {
    $superemployer = createUser('superemployer');
    $user = createUser('admin');

    $response = $this
        ->actingAs($superemployer)
        ->patchJson("/api/admins/$user->id", [
            'role' => 'user'
        ]);

    $response->assertStatus(403);
});
