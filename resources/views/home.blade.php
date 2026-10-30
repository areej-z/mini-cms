<x-layout>
    <x-slot:title>Accueil - Mini-CMS</x-slot:title>

    <section class="py-10">
        <h1 class="text-4xl font-bold mb-4">Bienvenue sur Mini-CMS</h1>
        <p class="text-lg text-gray-600 mb-6 max-w-2xl">
            Une petite plateforme de publication construite pas à pas pendant l'Atelier Framework Côté Serveur.
        </p>
        <a href="{{ route('posts.index') }}" class="inline-block rounded-md bg-indigo-600 px-5 py-2.5 font-medium text-white hover:bg-indigo-700">
            Lire les articles
        </a>
    </section>

    <h2 class="mb-4 text-2xl font-bold">Parcourir par catégorie</h2>
    <ul class="mb-10 flex flex-wrap gap-3" aria-label="Catégories">
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('posts.category', ['category' => $category->slug]) }}" class="inline-block rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:border-indigo-600 hover:text-indigo-600">
                    {{ $category->name }} ({{ $category->posts_count }})
                </a>
            </li>
        @endforeach
    </ul>

    @if ($tags->isNotEmpty())
        <h2 class="mb-4 text-2xl font-bold">Tags populaires</h2>
        <ul class="mb-10 flex flex-wrap gap-3" aria-label="Tags populaires">
            @foreach ($tags as $tag)
                <li>
                    <a href="{{ route('posts.tag', ['tag' => $tag->slug]) }}" class="inline-block rounded-full bg-indigo-50 px-3 py-1 text-sm font-medium text-indigo-700 hover:bg-indigo-100">
                        {{ $tag->name }} ({{ $tag->posts_count }})
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2 class="text-2xl font-bold mb-4">Derniers articles publiés</h2>

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($latestPosts as $post)
            <x-post-card :post="$post" />
        @empty
            <x-alert type="info" title="Aucun article publié" class="md:col-span-2">
                Les articles publiés apparaîtront ici.
            </x-alert>
        @endforelse
    </div>
</x-layout>