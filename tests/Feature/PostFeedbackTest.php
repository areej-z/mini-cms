<?php

use App\Models\Post;

beforeEach(function () {
    $this->withoutVite();
});

function feedbackPostData(array $overrides = []): array
{
    return array_merge([
        'title' => 'Article avec message',
        'slug' => 'article-avec-message',
        'body' => 'Contenu assez long pour passer la validation.',
        'is_published' => '1',
    ], $overrides);
}

it('shows a success message after creating a post', function () {
    $this->followingRedirects()
        ->post(route('posts.store'), feedbackPostData())
        ->assertOk()
        ->assertSee('Article créé.');
});

it('shows a success message after deleting a post', function () {
    $post = Post::factory()->create();

    $this->followingRedirects()
        ->delete(route('posts.destroy', $post))
        ->assertOk()
        ->assertSee('Article supprimé.');
});
