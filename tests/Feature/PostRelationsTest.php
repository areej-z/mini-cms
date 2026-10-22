<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
});

it('lists posts with their category, author and tags without lazy loading', function () {
    $category = Category::factory()->create(['name' => 'Tutoriels']);
    $tag = Tag::factory()->create(['name' => 'Astuce']);
    $author = User::factory()->create(['name' => 'Amira Ben Salah']);

    $posts = Post::factory(3)->published()->create([
        'category_id' => $category->id,
        'user_id' => $author->id,
    ]);

    $posts->each(fn (Post $post) => $post->tags()->attach($tag));

    $this->get(route('posts.index'))
        ->assertOk()
        ->assertSee('Tutoriels')
        ->assertSee('Amira Ben Salah')
        ->assertSee('Astuce');
});

it('keeps the posts when their category is deleted', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->create(['category_id' => $category->id]);

    $category->delete();

    $this->assertDatabaseHas('posts', ['id' => $post->id]);
    expect($post->fresh()->category_id)->toBeNull();
});

it('replaces the tags of a post with sync', function () {
    $post = Post::factory()->create();
    $tags = Tag::factory(3)->create();

    $post->tags()->attach([$tags[0]->id, $tags[1]->id]);
    $post->tags()->sync([$tags[1]->id, $tags[2]->id]);

    expect($post->tags()->count())->toBe(2);
    $this->assertDatabaseMissing('post_tag', ['post_id' => $post->id, 'tag_id' => $tags[0]->id]);
    $this->assertDatabaseHas('post_tag', ['post_id' => $post->id, 'tag_id' => $tags[2]->id]);
});

it('removes the pivot rows when a post is deleted', function () {
    $post = Post::factory()->create();
    $tag = Tag::factory()->create();
    $post->tags()->attach($tag);

    $this->delete(route('posts.destroy', $post));

    $this->assertDatabaseMissing('post_tag', ['post_id' => $post->id]);
    $this->assertDatabaseHas('tags', ['id' => $tag->id]);
});

it('shows other published posts of the same category', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->published()->create(['category_id' => $category->id]);

    Post::factory()->published()->create(['category_id' => $category->id, 'title' => 'Voisin publie']);
    Post::factory()->create(['category_id' => $category->id, 'title' => 'Voisin brouillon']);
    Post::factory()->published()->create(['title' => 'Autre categorie']);

    $this->get(route('posts.show', $post))
        ->assertOk()
        ->assertSee('Voisin publie')
        ->assertDontSee('Voisin brouillon')
        ->assertDontSee('Autre categorie');
});