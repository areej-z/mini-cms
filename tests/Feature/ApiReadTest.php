<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

it('lists only published posts with the resource shape', function () {
    Post::factory()->published()->count(2)->create();
    Post::factory()->create(['title' => 'Brouillon cache']);

    $this->getJson('/api/posts')
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => ['*' => ['id', 'title', 'slug', 'excerpt', 'published_at', 'author', 'category', 'tags', 'url']],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'last_page', 'per_page', 'total'],
        ]);
});

it('filters the posts by category slug', function () {
    $category = Category::factory()->create();
    Post::factory()->published()->create(['category_id' => $category->id, 'title' => 'Dans la categorie']);
    Post::factory()->published()->create(['title' => 'Hors categorie']);

    $this->getJson('/api/posts?category='.$category->slug)
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.title', 'Dans la categorie')
        ->assertJsonPath('data.0.category.slug', $category->slug);
});

it('filters the posts by tag slug', function () {
    $tag = Tag::factory()->create();
    $matchingPost = Post::factory()->published()->create(['title' => 'Avec le tag']);
    $matchingPost->tags()->attach($tag);
    Post::factory()->published()->create(['title' => 'Sans le tag']);

    $this->getJson('/api/posts?tag='.$tag->slug)
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.title', 'Avec le tag');
});

it('rejects an unknown category slug in French', function () {
    $this->getJson('/api/posts?category=inexistante')
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['category'])
        ->assertJsonPath('errors.category.0', 'La valeur sélectionnée pour le champ catégorie est invalide.');
});

it('lists the categories with their published post count', function () {
    $category = Category::factory()->create();
    Post::factory()->published()->count(2)->create(['category_id' => $category->id]);
    Post::factory()->create(['category_id' => $category->id]);

    $this->getJson('/api/categories')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', $category->slug)
        ->assertJsonPath('data.0.posts_count', 2);
});

it('returns a JSON 404 for an unknown category', function () {
    $this->getJson('/api/categories/999')
        ->assertNotFound()
        ->assertJsonStructure(['message']);
});
