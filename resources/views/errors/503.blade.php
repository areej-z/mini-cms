<x-layout title="Service indisponible (503)">
    <div class="max-w-2xl mx-auto py-12 px-4 text-center space-y-6">
        <p class="text-sm font-semibold uppercase tracking-wider text-amber-600">Erreur 503</p>
        <h1 class="text-3xl font-bold text-gray-900">Site temporairement en lecture seule.</h1>
        <p class="text-gray-600">
            {{ $exception->getMessage() ?: 'Le site est en lecture seule. Veuillez réessayer plus tard.' }}
        </p>
        <div>
            <a href="{{ route('posts.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Retour aux articles
            </a>
        </div>
    </div>
</x-layout>