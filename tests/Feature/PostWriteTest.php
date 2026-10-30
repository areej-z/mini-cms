<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

beforeEach(function () {
    $this->withoutVite();
});

function postData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article de test',
        'slug' => 'article-de-test',
        'excerpt' => 'Un extrait court.',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '0',
    ], $overrides);
}

it('creates a post from the form', function () {
    $this->post(route('posts.store'), postData())
        ->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'title' => 'Article de test',
        'slug' => 'article-de-test',
        'excerpt' => 'Un extrait court.',
    ]);
});

it('creates a post with the selected tags', function () {
    $tags = Tag::factory(2)->create();

    $this->post(route('posts.store'), postData([
        'tags' => $tags->pluck('id')->all(),
    ]))->assertRedirect();

    $post = Post::query()->where('slug', 'article-de-test')->firstOrFail();

    expect($post->tags()->pluck('tags.id')->all())->toEqual($tags->pluck('id')->all());
});

it('creates a post with a selected category', function () {
    $category = Category::factory()->create();

    $this->post(route('posts.store'), postData([
        'category_id' => $category->id,
    ]))->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'slug' => 'article-de-test',
        'category_id' => $category->id,
    ]);
});

it('does not create a post without a title', function () {
    $this->post(route('posts.store'), postData(['title' => '']))
        ->assertRedirect();

    $this->assertDatabaseMissing('posts', ['slug' => 'article-de-test']);
});

it('shows the edit form with the current values', function () {
    $post = Post::create(postData(['title' => 'Titre initial']));
    $tag = Tag::factory()->create(['name' => 'Tutoriel']);
    $post->tags()->attach($tag);

    $this->get(route('posts.edit', $post))
        ->assertOk()
        ->assertSee('Titre initial')
        ->assertSee('id="tag-'.$tag->id.'" name="tags[]" value="'.$tag->id.'"', false)
        ->assertSee('checked', false);
});

it('shows available tags in the create form', function () {
    $tag = Tag::factory()->create(['name' => 'Tutoriel']);

    $this->get(route('posts.create'))
        ->assertOk()
        ->assertSee('name="tags[]"', false)
        ->assertSee('value="'.$tag->id.'"', false)
        ->assertSee('Tutoriel');
});

it('shows available categories in the create form', function () {
    $category = Category::factory()->create(['name' => 'Tutoriels']);

    $this->get(route('posts.create'))
        ->assertOk()
        ->assertSee('name="category_id"', false)
        ->assertSee('Tutoriels');
});

it('keeps selected tags checked after validation fails', function () {
    $tag = Tag::factory()->create();

    $this->from(route('posts.create'))
        ->post(route('posts.store'), postData([
            'title' => '',
            'tags' => [$tag->id],
        ]))
        ->assertRedirect(route('posts.create'))
        ->assertSessionHasErrors('title');

    $this->get(route('posts.create'))
        ->assertOk()
        ->assertSee('id="tag-'.$tag->id.'" name="tags[]" value="'.$tag->id.'"', false)
        ->assertSee('checked', false);
});

it('updates a post and keeps its own slug', function () {
    $post = Post::create(postData());

    $this->put(route('posts.update', $post), postData(['title' => 'Titre modifie']))
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Titre modifie',
        'slug' => 'article-de-test',
    ]);
});

it('updates a post with the selected tags', function () {
    $post = Post::create(postData());
    $tags = Tag::factory(2)->create();

    $this->put(route('posts.update', $post), postData([
        'tags' => $tags->pluck('id')->all(),
    ]))->assertRedirect(route('posts.show', $post));

    expect($post->tags()->pluck('tags.id')->all())->toEqual($tags->pluck('id')->all());
});

it('removes all tags when none are selected during update', function () {
    $post = Post::create(postData());
    $post->tags()->attach(Tag::factory(2)->create());

    $this->put(route('posts.update', $post), postData())
        ->assertRedirect(route('posts.show', $post));

    expect($post->tags()->count())->toBe(0);
});

it('keeps tags unchecked after an update validation failure when none were selected', function () {
    $post = Post::create(postData());
    $tag = Tag::factory()->create();
    $post->tags()->attach($tag);

    $this->from(route('posts.edit', $post))
        ->put(route('posts.update', $post), postData(['title' => '']))
        ->assertRedirect(route('posts.edit', $post))
        ->assertSessionHasErrors('title');

    $this->get(route('posts.edit', $post))
        ->assertOk()
        ->assertDontSee('checked', false);
});

it('rejects tag ids that do not exist', function () {
    $this->post(route('posts.store'), postData(['tags' => [999]]))
        ->assertSessionHasErrors('tags.0');

    $this->assertDatabaseMissing('posts', ['slug' => 'article-de-test']);
});

it('refuses the slug of another post', function () {
    Post::create(postData(['slug' => 'slug-deja-pris']));
    $post = Post::create(postData());

    $this->put(route('posts.update', $post), postData(['slug' => 'slug-deja-pris']))
        ->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'slug' => 'article-de-test',
    ]);
});

it('deletes a post', function () {
    $post = Post::create(postData());

    $this->delete(route('posts.destroy', $post))
        ->assertRedirect(route('posts.index'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
});
