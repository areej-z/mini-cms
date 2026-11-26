<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

it('shows a published post to a guest', function () {
    $post = Post::factory()->published()->create();

    $this->get(route('posts.show', $post))
        ->assertOk();
});

it('forbids a draft to a guest', function () {
    $post = Post::factory()->create(['is_published' => false]);

    $this->get(route('posts.show', $post))
        ->assertForbidden();
});

it('shows a draft to its author only', function () {
    $author = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $author->id, 'is_published' => false]);

    $this->actingAs($author)
        ->get(route('posts.show', $post))
        ->assertOk();

    $this->actingAs(User::factory()->create())
        ->get(route('posts.show', $post))
        ->assertForbidden();
});

it('shows any draft to an admin', function () {
    $post = Post::factory()->create([
        'user_id' => User::factory()->create()->id,
        'is_published' => false,
    ]);

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('posts.show', $post))
        ->assertOk();
});

it('lists drafts only for their author', function () {
    $author = User::factory()->create();
    Post::factory()->create(['title' => 'Brouillon personnel', 'user_id' => $author->id, 'is_published' => false]);
    Post::factory()->create(['title' => 'Brouillon externe', 'user_id' => User::factory()->create()->id, 'is_published' => false]);
    Post::factory()->published()->create(['title' => 'Article public']);

    $this->get(route('posts.index'))
        ->assertSee('Article public')
        ->assertDontSee('Brouillon personnel')
        ->assertDontSee('Brouillon externe');

    $this->actingAs($author)
        ->get(route('posts.index'))
        ->assertSee('Article public')
        ->assertSee('Brouillon personnel')
        ->assertDontSee('Brouillon externe');
});
