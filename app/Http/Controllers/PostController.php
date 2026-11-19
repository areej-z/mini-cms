<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        return view('posts.index', [
            'heading' => 'Tous les articles',
            'posts' => Post::with('user', 'category', 'tags')->latest('id')->paginate(4),
        ]);
    }

    public function archive(string $year): View
    {
        return view('posts.index', [
            'heading' => 'Articles de '.$year,
            'posts' => Post::published()->with('user', 'category', 'tags')->whereYear('published_at', $year)->latest('id')->paginate(4),
        ]);
    }

    public function byCategory(Category $category): View
    {
        return view('posts.index', [
            'heading' => 'Catégorie : '.$category->name,
            'posts' => $category->posts()
                ->published()
                ->with('user', 'category', 'tags')
                ->latest('published_at')
                ->paginate(4),
        ]);
    }

    public function byTag(Tag $tag): View
    {
        return view('posts.index', [
            'heading' => 'Tag : '.$tag->name,
            'posts' => $tag->posts()
                ->published()
                ->with('user', 'category', 'tags')
                ->latest('published_at')
                ->paginate(4),
        ]);
    }

    public function create(): View
    {
        return view('posts.create', [
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        $post = $request->user()->posts()->create(Arr::except($validated, ['tags']));
        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('posts.show', $post)->with('success', 'Article créé.');
    }

    public function show(Post $post): View
    {
        $post->load('user', 'category', 'tags');

        $related = $post->category
            ? $post->category->posts()
                ->published()
                ->where('id', '!=', $post->id)
                ->with('user', 'category', 'tags')
                ->latest('published_at')
                ->take(3)
                ->get()
            : collect();

        return view('posts.show', compact('post', 'related'));
    }

    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);

        $post->load('tags');

        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? ($post->published_at ?? now()) : null;

        $post->update(Arr::except($validated, ['tags']));
        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('posts.show', $post)->with('success', 'Article mis à jour.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Article supprimé.');
    }

    public function togglePublication(Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        $isPublished = ! $post->is_published;

        $post->update([
            'is_published' => $isPublished,
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()->route('posts.show', $post)->with('success', $isPublished ? 'Article publié.' : 'Article dépublié.');
    }
}