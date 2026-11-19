<x-layout>
    <x-slot:title>Service indisponible - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">Service momentanément indisponible</h1>
    <p class="mt-2 mb-8 text-gray-600">Le site ne peut pas traiter cette demande pour le moment.</p>

    <x-alert type="warning" title="Erreur 503" class="max-w-2xl">
        {{ $exception->getMessage() ?: 'Le site est en maintenance. Réessayez dans quelques minutes.' }}
    </x-alert>

    <p class="mt-6">
        <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:underline">Retour à l'accueil</a>
    </p>
</x-layout>