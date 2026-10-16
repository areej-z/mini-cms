<x-layout>
    <x-slot:title>{{ $post['title'] }} - Mini-CMS</x-slot:title>

    <article class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-sm border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-900">{{ $post['title'] }}</h1>
        <div class="mt-2 text-sm text-gray-500">
            Par {{ $post['author'] }} - {{ $post['date'] }}
        </div>

        <div class="mt-6 space-y-4 text-gray-700">
            @foreach ($post['body'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>

        <div class="mt-8">
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline font-medium">
                &larr; Retour à la liste des articles
            </a>
        </div>
    </article>
</x-layout>