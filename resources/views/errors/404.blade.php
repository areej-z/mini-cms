<x-layout>
    <x-slot:title>{{ $heading ?? 'Page introuvable' }} - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">{{ $heading ?? 'Page introuvable' }}</h1>
    <p class="mt-2 mb-8 text-gray-600">{{ $message ?? "L'adresse demandée n'existe pas ou a été déplacée." }}</p>

    <x-alert type="info" title="Erreur 404" class="max-w-2xl">
        Vérifiez l'adresse, ou repartez de la page d'accueil.
    </x-alert>

    <p class="mt-6">
        <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:underline">Retour à l'accueil</a>
    </p>

    @if (isset($recentPosts) && $recentPosts->isNotEmpty())
        <section class="mt-10">
            <h2 class="text-xl font-semibold text-gray-900">Articles récents</h2>

            <ul class="mt-4 space-y-2">
                @foreach ($recentPosts as $recentPost)
                    <li>
                        <a href="{{ route('posts.show', $recentPost) }}" class="font-medium text-indigo-600 hover:underline">{{ $recentPost->title }}</a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
</x-layout>