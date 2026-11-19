<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->admin()->create());
});

function taxonomyPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article classé',
        'slug' => 'article-classe',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('stores the category and the tags chosen in the form', function () {
    $category = Category::factory()->create();
    $tags = Tag::factory(2)->create();

    $this->post(route('posts.store'), taxonomyPostData([
        'category_id' => $category->id,
        'tags' => $tags->pluck('id')->all(),
    ]))->assertRedirect();

    $post = Post::where('slug', 'article-classe')->firstOrFail();
    expect($post->category_id)->toBe($category->id);
    expect($post->tags()->count())->toBe(2);
});

it('replaces the tags on update with sync', function () {
    $post = Post::factory()->create(['slug' => 'article-classe']);
    [$old, $kept, $new] = Tag::factory(3)->create()->all();
    $post->tags()->attach([$old->id, $kept->id]);

    $this->put(route('posts.update', $post), taxonomyPostData(['tags' => [$kept->id, $new->id]]))
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseMissing('post_tag', ['post_id' => $post->id, 'tag_id' => $old->id]);
    $this->assertDatabaseHas('post_tag', ['post_id' => $post->id, 'tag_id' => $kept->id]);
    $this->assertDatabaseHas('post_tag', ['post_id' => $post->id, 'tag_id' => $new->id]);
});

it('removes every tag when no box is checked', function () {
    $post = Post::factory()->create(['slug' => 'article-classe']);
    $post->tags()->attach(Tag::factory(2)->create());

    $this->put(route('posts.update', $post), taxonomyPostData())
        ->assertRedirect(route('posts.show', $post));

    expect($post->tags()->count())->toBe(0);
});

it('refuses a category that does not exist', function () {
    $this->post(route('posts.store'), taxonomyPostData(['category_id' => 999]))
        ->assertRedirect();

    $this->assertDatabaseMissing('posts', ['slug' => 'article-classe']);
});

it('lists the published posts of a category by its slug', function () {
    $category = Category::factory()->create(['name' => 'Tutoriels', 'slug' => 'tutoriels']);
    Post::factory()->published()->create(['category_id' => $category->id, 'title' => 'Dans la categorie']);
    Post::factory()->create(['category_id' => $category->id, 'title' => 'Brouillon de la categorie']);
    Post::factory()->published()->create(['title' => 'Hors categorie']);

    $this->get('/posts/categorie/tutoriels')
        ->assertOk()
        ->assertSee('Dans la categorie')
        ->assertDontSee('Brouillon de la categorie')
        ->assertDontSee('Hors categorie');
});

it('returns 404 for an unknown category slug', function () {
    $this->get('/posts/categorie/inconnue')->assertNotFound();
});

it('counts the published posts of each category on the home page', function () {
    $category = Category::factory()->create(['name' => 'Tutoriels']);
    Post::factory(2)->published()->create(['category_id' => $category->id]);
    Post::factory()->create(['category_id' => $category->id]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Tutoriels (2)');
});

it('lists the published posts of a tag by its slug', function () {
    $tag = Tag::factory()->create(['name' => 'Astuce', 'slug' => 'astuce']);
    $published = Post::factory()->published()->create(['title' => 'Astuce publiee']);
    $draft = Post::factory()->create(['title' => 'Astuce en brouillon']);
    $published->tags()->attach($tag);
    $draft->tags()->attach($tag);
    Post::factory()->published()->create(['title' => 'Sans ce tag']);

    $this->get('/posts/tag/astuce')
        ->assertOk()
        ->assertSee('Astuce publiee')
        ->assertDontSee('Astuce en brouillon')
        ->assertDontSee('Sans ce tag');
});

it('returns 404 for an unknown tag slug', function () {
    $this->get('/posts/tag/inconnu')->assertNotFound();
});

it('shows only the tags that have published posts on the home page', function () {
    $popular = Tag::factory()->create(['name' => 'Populaire']);
    $hidden = Tag::factory()->create(['name' => 'Invisible']);
    Post::factory(2)->published()->create()->each(fn (Post $post) => $post->tags()->attach($popular));
    Post::factory()->create()->tags()->attach($hidden);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Populaire (2)')
        ->assertDontSee('Invisible');
});