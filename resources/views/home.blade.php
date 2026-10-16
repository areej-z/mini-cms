<x-layout>
    <x-slot:title>Accueil - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold">Bienvenue sur Mini-CMS</h1>
    <p class="mt-4 text-gray-700">Mini-CMS est le projet fil rouge de l'Atelier Framework Côté Serveur (Laravel 13).</p>
    <p class="mt-6">
        <a href="{{ route('about') }}" class="text-red-600 underline">En savoir plus sur le projet</a>
    </p>
</x-layout>