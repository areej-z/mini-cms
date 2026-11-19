<x-layout>
    <x-slot:title>Page introuvable - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">Page introuvable</h1>
    <p class="mt-2 mb-8 text-gray-600">L'adresse demandée n'existe pas ou a été déplacée.</p>

    <x-alert type="info" title="Erreur 404" class="max-w-2xl">
        Vérifiez l'adresse, ou repartez de la page d'accueil.
    </x-alert>

    <p class="mt-6">
        <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:underline">Retour à l'accueil</a>
    </p>
</x-layout>