@props(['post'])

<article class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 flex flex-col gap-3">
    <div class="flex items-center gap-2">
        <h2 class="text-lg font-semibold text-gray-900">
            <a href="{{ route('posts.show', $post['slug']) }}" class="hover:text-indigo-600">{{ $post['title'] }}</a>
        </h2>

        @if ($post['featured'])
            <span class="text-xs font-medium bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">À la une</span>
        @endif
    </div>

    <p class="text-sm text-gray-600">{{ $post['excerpt'] }}</p>
    <p class="text-xs text-gray-500">
        {{ $post['author'] }} - {{ $post['date'] }} -
        <a href="{{ route('posts.archive', $post['year']) }}" class="underline">Archive {{ $post['year'] }}</a>
    </p>

    <a href="{{ route('posts.show', $post['slug']) }}" class="text-sm font-medium text-indigo-600 hover:underline">Lire l'article</a>
</article>