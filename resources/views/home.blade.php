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