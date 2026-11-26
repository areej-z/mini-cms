<?php

use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

it('allows an admin to promote an author to admin', function () {
    $admin = User::factory()->admin()->create();
    $author = User::factory()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.role', $author), ['role' => 'admin'])
        ->assertRedirect(route('admin.users.index'));

    expect($author->fresh()->role)->toBe('admin');
});

it('forbids an admin from changing their own role', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.role', $admin), ['role' => 'author'])
        ->assertForbidden();

    expect($admin->fresh()->role)->toBe('admin');
});
