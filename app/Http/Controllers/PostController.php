public function togglePublication(Post $post): RedirectResponse
    {
        $isPublished = ! $post->is_published;

        $post->update([
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()->route('posts.show', $post);
    }