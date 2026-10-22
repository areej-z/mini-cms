<x-layout>
    <x-slot:title>{{ $post->title }} - Mini-CMS</x-slot:title>

    <article class="max-w-2xl">
        <a href="{{ route('posts.index') }}" class="text-sm text-indigo-600 hover:underline">Retour aux articles</a>

        <h1 class="text-3xl font-bold mt-4 mb-2">{{ $post->title }}</h1>

        <p class="text-sm text-gray-500 mb-4">
            @if ($post->published_at)
                Publié le {{ $post->published_at->format('d/m/Y') }}
            @else
                Brouillon
            @endif
            - {{ $post->category?->name ?? 'Sans catégorie' }} - par {{ $post->user?->name ?? 'auteur inconnu' }}
        </p>

        @if ($post->tags->isNotEmpty())
            <ul class="mb-6 flex flex-wrap gap-2" aria-label="Tags de l'article">
                @foreach ($post->tags as $tag)
                    <li class="rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700">{{ $tag->name }}</li>
                @endforeach
            </ul>
        @endif

        @if ($post->excerpt)
            <p class="text-lg text-gray-600 mb-6">{{ $post->excerpt }}</p>
        @endif

        <div class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $post->body }}</div>

        <div class="mt-8 flex flex-wrap items-start gap-4">
            <form method="POST" action="{{ route('posts.publication', $post) }}">
                @csrf
                @method('PATCH')

                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">{{ $post->is_published ? 'Dépublier' : 'Publier' }}</button>
            </form>

            <a href="{{ route('posts.edit', $post) }}" class="rounded-md border border-indigo-600 px-4 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50">Modifier</a>

            <details>
                <summary class="cursor-pointer rounded-md border border-red-600 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50">Supprimer</summary>

                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="mt-3 rounded-md border border-red-200 bg-red-50 p-4">
                    @csrf
                    @method('DELETE')

                    <p class="mb-3 text-sm text-red-900">Cette action est définitive : l'article sera effacé de la base.</p>
                    <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Confirmer la suppression</button>
                </form>
            </details>
        </div>
    </article>

    @if ($related->isNotEmpty())
        <section class="mt-12" aria-labelledby="related-title">
            <h2 id="related-title" class="text-xl font-bold mb-4">Dans la même catégorie</h2>

            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($related as $relatedPost)
                    <x-post-card :post="$relatedPost" />
                @endforeach
            </div>
        </section>
    @endif
</x-layout>