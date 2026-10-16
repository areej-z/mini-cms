<x-layout>
    <x-slot:title>{{ $post['title'] }} - Mini-CMS</x-slot:title>

    <article>
        <h1 class="text-3xl font-bold">{{ $post['title'] }}</h1>
        <p class="mt-1 text-sm text-gray-500">Publié en {{ $post['year'] }}</p>
        <p class="mt-6 leading-relaxed text-gray-700">{{ $post['body'] }}</p>
    </article>

    <p class="mt-8">
        <a href="{{ route('posts.index') }}" class="text-red-600 underline">Retour à la liste des articles</a>
    </p>
</x-layout>