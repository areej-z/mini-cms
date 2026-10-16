<x-layout>
    <x-slot:title>{{ $post['title'] }} - Mini-CMS</x-slot:title>

    <article class="max-w-2xl">
        <a href="{{ route('posts.index') }}" class="text-sm text-indigo-600 hover:underline">Retour aux articles</a>

        <h1 class="text-3xl font-bold mt-4 mb-2">{{ $post['title'] }}</h1>
        <p class="text-sm text-gray-500 mb-6">{{ $post['author'] }} - {{ $post['date'] }}</p>

        <div class="space-y-4 text-gray-800 leading-relaxed">
            @foreach ($post['body'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </article>
</x-layout>