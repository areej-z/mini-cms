<x-layout :title="$heading ?? 'Page introuvable'">
    <div class="max-w-4xl mx-auto py-12 px-4 space-y-10">
        <div class="text-center space-y-6">
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">Erreur 404</p>
            <h1 class="text-3xl font-bold text-gray-900">{{ $heading ?? 'Page introuvable' }}</h1>
            <p class="text-gray-600">
                {{ $message ?? 'La ressource demandée est introuvable.' }}
            </p>
            <div>
                <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Retour aux articles
                </a>
            </div>
        </div>

        @if (isset($recentPosts) && $recentPosts->isNotEmpty())
            <section class="space-y-4 text-left">
                <h2 class="text-2xl font-bold text-gray-900">Articles récents</h2>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($recentPosts as $recentPost)
                        <x-post-card :post="$recentPost" />
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-layout>