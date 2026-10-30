<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

beforeEach(function () {
    $this->withoutVite();
});

function taxonomyPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article classe',
        'slug' => 'article-classe',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('shows category and tag choices on the create form', function () {
    $category = Category::factory()->create(['name' => 'Laravel']);
    $tag = Tag::factory()->create(['name' => 'Astuce']);

    $this->get(route('posts.create'))
        ->assertOk()
        ->assertSee('value="'.$category->id.'"', false)
        ->assertSee('Laravel')
        ->assertSee('name="tags[]"', false)
        ->assertSee('value="'.$tag->id.'"', false)
        ->assertSee('Astuce');
});

it('preselects the post category and tags on the edit form', function () {
    $category = Category::factory()->create(['name' => 'Laravel']);
    $tag = Tag::factory()->create(['name' => 'Astuce']);
    $post = Post::factory()->for($category)->create();
    $post->tags()->attach($tag);

    $this->get(route('posts.edit', $post))
        ->assertOk()
        ->assertSee('value="'.$category->id.'" selected', false)
        ->assertSee('id="tag-'.$tag->id.'" name="tags[]" value="'.$tag->id.'"', false)
        ->assertSee('checked', false);
});

it('stores the category and tags submitted from the post form', function () {
    $category = Category::factory()->create();
    $tags = Tag::factory(2)->create();

    $this->post(route('posts.store'), taxonomyPostData([
        'category_id' => $category->id,
        'tags' => $tags->modelKeys(),
    ]))->assertRedirect();

    $post = Post::query()->where('slug', 'article-classe')->firstOrFail();

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'category_id' => $category->id,
    ]);
    expect($post->tags()->pluck('tags.id')->all())->toEqual($tags->modelKeys());
});

it('replaces category and tags when updating a post', function () {
    $oldCategory = Category::factory()->create();
    $newCategory = Category::factory()->create();
    $post = Post::factory()->for($oldCategory)->create(['slug' => 'article-classe']);
    [$oldTag, $keptTag, $newTag] = Tag::factory(3)->create()->all();
    $post->tags()->attach([$oldTag->id, $keptTag->id]);

    $this->put(route('posts.update', $post), taxonomyPostData([
        'category_id' => $newCategory->id,
        'tags' => [$keptTag->id, $newTag->id],
    ]))->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'category_id' => $newCategory->id,
    ]);
    $this->assertDatabaseMissing('post_tag', [
        'post_id' => $post->id,
        'tag_id' => $oldTag->id,
    ]);
    $this->assertDatabaseHas('post_tag', [
        'post_id' => $post->id,
        'tag_id' => $keptTag->id,
    ]);
    $this->assertDatabaseHas('post_tag', [
        'post_id' => $post->id,
        'tag_id' => $newTag->id,
    ]);
});

it('detaches all tags when the update form submits none', function () {
    $post = Post::factory()->create(['slug' => 'article-classe']);
    $post->tags()->attach(Tag::factory(2)->create());

    $this->put(route('posts.update', $post), taxonomyPostData())
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseMissing('post_tag', ['post_id' => $post->id]);
});

it('lists only published posts on a category page found by slug', function () {
    $category = Category::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);
    Post::factory()->published()->for($category)->create(['title' => 'Article Laravel']);
    Post::factory()->for($category)->create(['title' => 'Brouillon Laravel']);

    $this->get(route('posts.category', ['category' => 'laravel']))
        ->assertOk()
        ->assertSee('Catégorie : Laravel')
        ->assertSee('Article Laravel')
        ->assertDontSee('Brouillon Laravel');
});

it('shows published article counts by category without loading posts', function () {
    $laravel = Category::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);
    $php = Category::factory()->create(['name' => 'PHP', 'slug' => 'php']);

    Post::factory(2)->published()->for($laravel)->create();
    Post::factory()->for($laravel)->create();
    Post::factory()->published()->for($php)->create();

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Laravel (2)')
        ->assertSee('PHP (1)')
        ->assertSee(route('posts.category', ['category' => 'laravel']), false)
        ->assertViewHas('categories', function ($categories) {
            expect($categories->pluck('posts_count', 'name')->all())->toBe([
                'Laravel' => 2,
                'PHP' => 1,
            ]);
            expect($categories->every(
                fn (Category $category) => ! $category->relationLoaded('posts')
            ))->toBeTrue();

            return true;
        });
});
