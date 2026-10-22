<x-layout>
    <x-slot:title>{{ $heading }} - Mini-CMS</x-slot:title>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $heading }}</h1>
    </div>

    <a href="{{ route('posts.create') }}" class="inline-block mb-6 rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Nouvel article</a>

    <div class="grid gap-6 md:grid-cols-2">
        @foreach ($posts as $post)
            <x-post-card :$post />
        @endforeach
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-layout>