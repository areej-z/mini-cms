<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

it('lists only published posts as a resource collection', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    $tags = Tag::factory()->count(2)->create();
    $published = Post::factory()->published()->create([
        'title' => 'Article public',
        'user_id' => $author->id,
        'category_id' => $category->id,
    ]);
    $published->tags()->attach($tags);

    Post::factory()->create([
        'title' => 'Brouillon prive',
        'user_id' => $author->id,
    ]);

    $this->getJson('/api/posts?per_page=2')
        ->assertOk()
        ->assertJsonPath('meta.per_page', 2)
        ->assertJsonPath('data.0.title', 'Article public')
        ->assertJsonPath('data.0.author', $author->name)
        ->assertJsonPath('data.0.category.id', $category->id)
        ->assertJsonCount(2, 'data.0.tags')
        ->assertJsonMissingPath('data.0.user_id')
        ->assertJsonMissingPath('data.0.body')
        ->assertJsonMissingPath('data.0.email');
});

it('shows a published post with its body and tags', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Article detail',
    ]);
    $post->tags()->attach(Tag::factory()->create(['name' => 'Laravel']));

    $this->getJson("/api/posts/{$post->id}")
        ->assertOk()
        ->assertJsonPath('data.title', 'Article detail')
        ->assertJsonPath('data.body', $post->body)
        ->assertJsonPath('data.tags.0', 'Laravel');
});

it('returns 404 for an unknown post', function () {
    $this->getJson('/api/posts/999999')
        ->assertNotFound();
});

it('forbids a draft to a guest', function () {
    $draft = Post::factory()->create(['is_published' => false]);

    $this->getJson("/api/posts/{$draft->id}")
        ->assertForbidden();
});

it('validates per_page', function () {
    $this->getJson('/api/posts?per_page=500')
        ->assertUnprocessable()
        ->assertJsonValidationErrors('per_page');
});
