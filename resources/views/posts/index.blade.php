<x-layout>
    <x-slot:title>{{ $heading }} - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold">{{ $heading }}</h1>

    <ul class="mt-6 space-y-4">
        @foreach ($posts as $slug => $post)
            <li class="rounded border border-gray-200 bg-white p-4">
                <a href="{{ route('posts.show', $slug) }}" class="text-xl font-medium text-red-600 hover:underline">{{ $post['title'] }}</a>
                <p class="mt-1 text-sm text-gray-500">
                    Publié en
                    <a href="{{ route('posts.archive', $post['year']) }}" class="underline">{{ $post['year'] }}</a>
                </p>
            </li>
        @endforeach
    </ul>
</x-layout>