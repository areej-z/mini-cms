<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

function authorizationPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article protege',
        'slug' => 'article-protege',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('redirects a guest to the login page', function () {
    $post = Post::factory()->create();

    $this->get(route('posts.edit', $post))
        ->assertRedirect(route('login'));
});

it('records the logged-in user as the author', function () {
    $author = User::factory()->create();

    $this->actingAs($author)
        ->post(route('posts.store'), authorizationPostData())
        ->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'slug' => 'article-protege',
        'user_id' => $author->id,
    ]);
});

it('lets an author edit their own post', function () {
    $author = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $author->id]);

    $this->actingAs($author)
        ->get(route('posts.edit', $post))
        ->assertOk();
});

it('forbids an author to edit the post of another user', function () {
    $post = Post::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs(User::factory()->create())
        ->get(route('posts.edit', $post))
        ->assertForbidden();
});

it('forbids an author to update the post of another user', function () {
    $post = Post::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs(User::factory()->create())
        ->put(route('posts.update', $post), authorizationPostData())
        ->assertForbidden();

    $this->assertDatabaseMissing('posts', ['slug' => 'article-protege']);
});

it('forbids an author to delete the post of another user', function () {
    $post = Post::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs(User::factory()->create())
        ->delete(route('posts.destroy', $post))
        ->assertForbidden();

    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});

it('lets an admin update any post', function () {
    $post = Post::factory()->create(['user_id' => User::factory()->create()->id]);

    $this->actingAs(User::factory()->admin()->create())
        ->put(route('posts.update', $post), authorizationPostData())
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', ['id' => $post->id, 'slug' => 'article-protege']);
});

it('keeps the category back office for admins', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.categories.index'))
        ->assertForbidden();

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('admin.categories.index'))
        ->assertOk();
});