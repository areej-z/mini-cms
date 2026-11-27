<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IndexPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        Gate::authorize('view', $post);

        return new PostResource($post->load('user', 'category', 'tags'));
    }
}
