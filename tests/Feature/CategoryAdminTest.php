<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->admin()->create());
});

function categoryAdminData(array $overrides = []): array
{
    return array_merge([
        'name' => 'Laravel',
        'slug' => 'laravel',
    ], $overrides);
}

it('lists the categories', function () {
    Category::factory()->create(['name' => 'Cuisine', 'slug' => 'cuisine']);

    $this->get(route('admin.categories.index'))
        ->assertOk()
        ->assertSee('Cuisine');
});

it('creates a category and flashes a message', function () {
    $this->post(route('admin.categories.store'), categoryAdminData())
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('success', 'Catégorie créée.');

    $this->assertDatabaseHas('categories', ['slug' => 'laravel']);
});

it('rejects an empty category with French messages', function () {
    $this->post(route('admin.categories.store'), ['name' => '', 'slug' => ''])
        ->assertSessionHasErrors([
            'name' => 'Le champ nom est obligatoire.',
            'slug' => 'Le champ slug est obligatoire.',
        ]);

    $this->assertDatabaseCount('categories', 0);
});

it('rejects a slug already used by another category', function () {
    Category::factory()->create(['name' => 'PHP', 'slug' => 'php']);

    $this->post(route('admin.categories.store'), categoryAdminData(['slug' => 'php']))
        ->assertSessionHasErrors(['slug' => 'Ce slug est déjà utilisé par une autre catégorie.']);
});

it('keeps its own slug on update', function () {
    $category = Category::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);

    $this->put(route('admin.categories.update', $category), categoryAdminData(['name' => 'Laravel 13']))
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHasNoErrors();

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Laravel 13']);
});

it('deletes a category and keeps its posts', function () {
    $category = Category::factory()->create();
    $post = Post::factory()->create(['category_id' => $category->id]);

    $this->delete(route('admin.categories.destroy', $category))
        ->assertRedirect(route('admin.categories.index'))
        ->assertSessionHas('success', 'Catégorie supprimée.');

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    $this->assertDatabaseHas('posts', ['id' => $post->id, 'category_id' => null]);
});

it('blocks category writes when the site is read-only', function () {
    config(['site.read_only' => true]);

    $this->post(route('admin.categories.store'), categoryAdminData())
        ->assertStatus(503)
        ->assertSee('Le site est en lecture seule.');

    $this->assertDatabaseCount('categories', 0);
});

it('still shows the category list when the site is read-only', function () {
    config(['site.read_only' => true]);

    $this->get(route('admin.categories.index'))->assertOk();
});