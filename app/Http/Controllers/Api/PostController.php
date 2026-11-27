<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPostRequest $request): AnonymousResourceCollection
    {
        $perPage = (int) ($request->validated('per_page') ?? 5);

        $posts = Post::published()
            ->with('user', 'category', 'tags')
            ->when($request->validated('category'), fn (Builder $query, string $slug) => $query->whereRelation('category', 'slug', $slug))
            ->when($request->validated('tag'), fn (Builder $query, string $slug) => $query->whereRelation('tags', 'slug', $slug))
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        $post = $request->user()->posts()->create(Arr::except($validated, ['tags']));
        $post->tags()->sync($validated['tags'] ?? []);

        return (new PostResource($post->load('user', 'category', 'tags')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        Gate::authorize('view', $post);

        return new PostResource($post->load('user', 'category', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $validated = $request->validated();

        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? ($post->published_at ?? now()) : null;

        $post->update(Arr::except($validated, ['tags']));
        $post->tags()->sync($validated['tags'] ?? []);

        return new PostResource($post->load('user', 'category', 'tags'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): Response
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->noContent();
    }
}
