<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('superadmin can promote user to admin', function () {
    $superAdmin = createUser('superadmin');
    $user = createUser('user');

    $response = $this
        ->actingAs($superAdmin)
        ->patch("/admins/create/$user->id");

    $response
        ->assertStatus(302)
        ->assertRedirectBack()
        ->assertSessionHas('message', 'User Promoted Successfully!');

    $user->refresh();
    expect($user->role)->toBe('admin');
});

test('superadmin can demote an admin', function () {
    $superAdmin = createUser('superadmin');
    $user = createUser('admin');

    $response = $this
        ->actingAs($superAdmin)
        ->patch("/admins/$user->id");

    $response
        ->assertStatus(302)
        ->assertRedirectBack()
        ->assertSessionHas(
            'message', "Admin Demoted Successfully!"
        );

    $user->refresh();
    expect($user->role)->toBe('user');
});

test('admin cannot promote user to admin', function () {
    $admin = createUser('admin');
    $user = createUser('user');

    $response = $this
        ->actingAs($admin)
        ->patch("/admins/create/$user->id");

    $response->assertStatus(302);

    $user->refresh();
    expect($user->role)->toBe('user');
});

test('admin cannot demote another admin', function () {
    $admin = createUser('admin');
    $user = createUser('admin');

    $response = $this
        ->actingAs($admin)
        ->patch("/admins/$user->id");

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});

test('superemployer cannot promote user to admin', function () {
    $superemployer = createUser('superemployer');
    $user = createUser('user');

    $response = $this
        ->actingAs($superemployer)
        ->patch("/admins/create/$user->id");

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});

test('superemployer cannot demote user to admin', function () {
    $superemployer = createUser('superemployer');
    $user = createUser('admin');

    $response = $this
        ->actingAs($superemployer)
        ->patch("/admins/create/$user->id");

    $response
        ->assertStatus(302)
        ->assertRedirect('/');
});
