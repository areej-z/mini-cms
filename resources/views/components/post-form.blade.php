@props(['post' => null, 'tags' => []])

@php
    $selectedTags = session()->hasOldInput()
        ? old('tags', [])
        : ($post?->tags->pluck('id')->all() ?? []);
@endphp

<form method="POST" action="{{ $post ? route('posts.update', $post) : route('posts.store') }}" class="max-w-2xl space-y-5">
    @csrf

    @if ($post)
        @method('PUT')
    @endif

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
        <input type="text" id="title" name="title" value="{{ old('title', $post?->title) }}" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug (minuscules, chiffres et tirets)</label>
        <input type="text" id="slug" name="slug" value="{{ old('slug', $post?->slug) }}" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">
        @error('slug')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="excerpt" class="block text-sm font-medium text-gray-700">Extrait (facultatif, 255 caractères au plus)</label>
        <input type="text" id="excerpt" name="excerpt" value="{{ old('excerpt', $post?->excerpt) }}" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">
        @error('excerpt')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="body" class="block text-sm font-medium text-gray-700">Contenu</label>
        <textarea id="body" name="body" rows="8" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">{{ old('body', $post?->body) }}</textarea>
        @error('body')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <span class="mb-2 block text-sm font-medium text-gray-700">Tags</span>
        <div class="flex flex-wrap gap-4">
            @foreach ($tags as $tag)
                <div class="flex items-center">
                    <input type="checkbox" id="tag-{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}"
                        @checked(in_array($tag->id, $selectedTags))
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="tag-{{ $tag->id }}" class="ml-2 text-sm text-gray-700">{{ $tag->name }}</label>
                </div>
            @endforeach
        </div>
        @error('tags')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('tags.*')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" id="is_published" name="is_published" value="1" @checked(old('is_published', $post?->is_published))>
        <label for="is_published" class="text-sm text-gray-700">Publié</label>
    </div>

    <div class="flex items-center gap-4">
        <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2.5 font-medium text-white hover:bg-indigo-700">{{ $post ? 'Mettre à jour' : 'Enregistrer' }}</button>
        <a href="{{ $post ? route('posts.show', $post) : route('posts.index') }}" class="text-sm text-gray-600 hover:underline">Annuler</a>
    </div>
</form>