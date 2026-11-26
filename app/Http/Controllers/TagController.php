<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        Gate::authorize('manage-tags');

        $tags = Tag::withCount('posts')->orderBy('name')->get();

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        Gate::authorize('manage-tags');

        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        Tag::create($request->validated());

        return redirect()->route('admin.tags.index')->with('success', 'Tag créé.');
    }

    public function edit(Tag $tag): View
    {
        Gate::authorize('manage-tags');

        return view('admin.tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        $tag->update($request->validated());

        return redirect()->route('admin.tags.index')->with('success', 'Tag mis à jour.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        Gate::authorize('manage-tags');

        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag supprimé.');
    }
}
