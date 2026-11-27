<?php

use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

function apiPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article envoye par l API',
        'slug' => 'article-envoye-par-l-api',
        'excerpt' => 'Un article cree avec un jeton.',
        'body' => 'Le contenu complet de cet article, envoye en JSON.',
        'is_published' => true,
    ], $overrides);
}

it('returns 401 when no token is provided for post creation', function () {
    $this->postJson('/api/posts', apiPostData())
        ->assertUnauthorized()
        ->assertJsonPath('message', 'Unauthenticated.');

    $this->assertDatabaseCount('posts', 0);
});

it('creates a post for the owner of the token', function () {
    $author = User::factory()->create();
    Sanctum::actingAs($author);

    $this->postJson('/api/posts', apiPostData())
        ->assertCreated()
        ->assertJsonPath('data.slug', 'article-envoye-par-l-api')
        ->assertJsonPath('data.author', $author->name);

    $this->assertDatabaseHas('posts', [
        'slug' => 'article-envoye-par-l-api',
        'user_id' => $author->id,
    ]);
});

it('rejects an invalid post with French messages', function () {
    Sanctum::actingAs(User::factory()->create());

    $this->postJson('/api/posts', apiPostData(['title' => '']))
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['title'])
        ->assertJsonPath('errors.title.0', 'Le champ titre est obligatoire.');
});

it('returns 403 when an author updates another users post before validation', function () {
    $post = Post::factory()->create(['user_id' => User::factory()->create()->id]);
    Sanctum::actingAs(User::factory()->create());

    $this->putJson('/api/posts/'.$post->id, ['title' => ''])
        ->assertForbidden();
});

it('lets the author delete their own post', function () {
    $author = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $author->id]);
    Sanctum::actingAs($author);

    $this->deleteJson('/api/posts/'.$post->id)
        ->assertNoContent();

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});

it('issues a token that opens the protected routes', function () {
    $user = User::factory()->create();

    $token = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
        ->assertCreated()
        ->assertJsonStructure(['token', 'token_type'])
        ->json('token');

    $this->assertDatabaseCount('personal_access_tokens', 1);

    $this->withToken($token)
        ->getJson('/api/user')
        ->assertOk()
        ->assertJsonPath('email', $user->email);
});

it('refuses a wrong password with a neutral message', function () {
    $user = User::factory()->create();

    $this->postJson('/api/login', ['email' => $user->email, 'password' => 'mauvais'])
        ->assertUnprocessable()
        ->assertJsonPath('errors.email.0', 'Ces identifiants ne correspondent à aucun compte.');

    $this->assertDatabaseCount('personal_access_tokens', 0);
});

it('revokes the current token on logout', function () {
    $user = User::factory()->create();
    $token = $user->createToken('api')->plainTextToken;

    $this->withToken($token)
        ->postJson('/api/logout')
        ->assertNoContent();

    $this->assertDatabaseCount('personal_access_tokens', 0);
});
