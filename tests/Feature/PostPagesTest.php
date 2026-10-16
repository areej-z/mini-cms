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