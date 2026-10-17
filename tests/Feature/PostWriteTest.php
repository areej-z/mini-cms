it('publishes a draft', function () {
    $post = Post::create(postData());

    $this->patch(route('posts.publication', $post))
        ->assertRedirect(route('posts.show', $post));

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'is_published' => true,
    ]);

    expect($post->fresh()->published_at)->not->toBeNull();
});