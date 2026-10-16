@props(['post'])

<article class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 flex flex-col gap-3">
    <div class="flex items-center gap-2">
        <h2 class="text-lg font-semibold text-gray-900">
            <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600">{{ $post->title }}</a>
        </h2>
        @if (! $post->is_published)
            <span class="text-xs font-medium bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full">Brouillon</span>
        @endif
    </div>

    <p class="text-sm text-gray-600">{{ Str::limit($post->body, 120) }}</p>

    <p class="text-xs text-gray-500">
        @if ($post->published_at)
            Publié le {{ $post->published_at->format('d/m/Y') }} -
            <a href="{{ route('posts.archive', $post->published_at->year) }}" class="underline">Archive {{ $post->published_at->year }}</a>
        @else
            Non publié
        @endif
    </p>

    <a href="{{ route('posts.show', $post) }}" class="text-sm font-medium text-indigo-600 hover:underline">Lire l'article</a>
</article>