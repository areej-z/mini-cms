@props(['post'])

<article class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
    <h2 class="text-xl font-semibold text-gray-900">
        <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600">{{ $post->title }}</a>
    </h2>

    <p class="mt-2 text-sm text-gray-500">
        @if ($post->published_at)
            Publié le {{ $post->published_at->format('d/m/Y') }}
        @else
            Brouillon
        @endif
        -
        @if ($post->category)
            <a href="{{ route('posts.category', ['category' => $post->category->slug]) }}" class="underline hover:text-indigo-600">{{ $post->category->name }}</a>
        @else
            Sans catégorie
        @endif
        - par {{ $post->user?->name ?? 'auteur inconnu' }}
    </p>

    <p class="mt-4 text-gray-700">{{ $post->excerpt ?: \Illuminate\Support\Str::limit($post->body, 180) }}</p>

    @if ($post->tags->isNotEmpty())
        <ul class="mt-4 flex flex-wrap gap-2" aria-label="Tags de l'article">
            @foreach ($post->tags as $tag)
                <li class="rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700">{{ $tag->name }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('posts.show', $post) }}" class="mt-4 inline-block text-sm font-medium text-indigo-600 hover:underline">Lire l'article</a>
</article>
