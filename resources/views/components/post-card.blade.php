@props(['post'])

<article class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <h2 class="text-xl font-bold text-gray-900">
        <a href="{{ route('posts.show', $post['slug']) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
            {{ $post['title'] }}
        </a>
    </h2>
    <p class="mt-2 text-gray-600">
        {{ $post['excerpt'] }}
    </p>
    <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
        <span>Par {{ $post['author'] }} - {{ $post['date'] }}</span>
        <a href="{{ route('posts.show', $post['slug']) }}" class="font-medium text-blue-600 hover:underline">
            Lire la suite &rarr;
        </a>
    </div>
</article>