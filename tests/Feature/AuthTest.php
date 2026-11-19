<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->withoutVite();
});

function authRegisterData(array $overrides = []): array
{
    return array_merge([
        'name' => 'Amira Ben Salah',
        'email' => 'amira@example.com',
        'password' => 'motdepasse123',
        'password_confirmation' => 'motdepasse123',
    ], $overrides);
}

it('registers an author with a hashed password and logs them in', function () {
    $this->post(route('register.store'), authRegisterData())
        ->assertRedirect(route('posts.index'));

    $user = User::where('email', 'amira@example.com')->firstOrFail();

    expect($user->password)->not->toBe('motdepasse123')
        ->and(Hash::check('motdepasse123', $user->password))->toBeTrue()
        ->and($user->role)->toBe('author');

    $this->assertAuthenticatedAs($user);
});

it('refuses a password that does not match its confirmation', function () {
    $this->post(route('register.store'), authRegisterData(['password_confirmation' => 'autrechose']))
        ->assertSessionHasErrors('password');

    $this->assertGuest();
});

it('logs in with the right password', function () {
    $user = User::factory()->create(['email' => 'auteur@example.com']);

    $this->post(route('login.store'), ['email' => 'auteur@example.com', 'password' => 'password'])
        ->assertRedirect(route('posts.index'));

    $this->assertAuthenticatedAs($user);
});

it('refuses a wrong password with a neutral message', function () {
    User::factory()->create(['email' => 'auteur@example.com']);

    $this->post(route('login.store'), ['email' => 'auteur@example.com', 'password' => 'mauvais'])
        ->assertSessionHasErrors(['email' => 'Ces identifiants ne correspondent à aucun compte.']);

    $this->assertGuest();
});

it('logs out and shows a message', function () {
    $this->actingAs(User::factory()->create())
        ->followingRedirects()
        ->post(route('logout'))
        ->assertOk()
        ->assertSee('Vous êtes déconnecté.');

    $this->assertGuest();
});