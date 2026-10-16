<x-layout>
    <x-slot:title>À propos - Mini-CMS</x-slot:title>

    <x-page-header title="À propos" subtitle="Le projet Mini-CMS et ses objectifs." />

    <div class="space-y-4 max-w-2xl">
        <p class="text-gray-700 leading-relaxed">
            Mini-CMS est le projet fil rouge de l'Atelier Framework Côté Serveur, 3e année MDW, ISET Sidi Bouzid.
        </p>

        <p class="text-gray-700">Auteur : {{ $auteur }} - Groupe : {{ $groupe }}</p>

        <x-alert type="info" title="Projet pédagogique">
            Ce site évolue à chaque session : les pages que vous voyez aujourd'hui seront reliées à une base de données dans la suite du cours.
        </x-alert>

        <x-alert type="warning" title="Données provisoires">
            Les articles affichés viennent d'un tableau PHP écrit dans le contrôleur. Ils ne sont pas enregistrés.
        </x-alert>
    </div>
</x-layout>