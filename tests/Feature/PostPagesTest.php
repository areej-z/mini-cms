<?php

use App\Models\Category;
use App\Models\Post;

it('shows only published posts on the home page', function () {
    Post::create([
        'title' => 'Article visible',
        'slug' => 'article-visible',
        'body' => 'Cet article est publie et doit apparaitre.',
        'is_published' => true,
        'published_at' => now(),
    ]);

    Post::create([
        'title' => 'Article masque',
        'slug' => 'article-masque',
        'body' => 'Cet article est un brouillon et reste cache.',
        'is_published' => false,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Article visible')
        ->assertDontSee('Article masque');
});

it('shows published post counts for categories without loading their posts', function () {
    $laravel = Category::factory()->create([
        'name' => 'Laravel',
        'slug' => 'laravel',
    ]);
    $php = Category::factory()->create([
        'name' => 'PHP',
        'slug' => 'php',
    ]);
    Category::factory()->create([
        'name' => 'Vide',
        'slug' => 'vide',
    ]);

    Post::factory(2)->published()->create(['category_id' => $laravel->id]);
    Post::factory()->create(['category_id' => $laravel->id]);
    Post::factory()->published()->create(['category_id' => $php->id]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Laravel (2)')
        ->assertSee('PHP (1)')
        ->assertSee('Vide (0)')
        ->assertSee(route('posts.category', ['category' => 'laravel']), false)
        ->assertViewHas('categories', function ($categories) {
            expect($categories->pluck('posts_count', 'name')->all())->toBe([
                'Laravel' => 2,
                'PHP' => 1,
                'Vide' => 0,
            ]);

            expect($categories->every(
                fn (Category $category) => ! $category->relationLoaded('posts')
            ))->toBeTrue();

            return true;
        });
});
