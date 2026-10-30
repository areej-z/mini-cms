<x-layout>
    <x-slot:title>Nouvel article - Mini-CMS</x-slot:title>

    <x-page-header title="Nouvel article" subtitle="Chaque champ est vérifié par le serveur." />

    @if ($errors->any())
        <x-alert type="error" title="Le formulaire contient des erreurs" class="mb-6 max-w-2xl">
            Corrigez les champs signalés, puis envoyez à nouveau.
        </x-alert>
    @endif

    <x-post-form :categories="$categories" :tags="$tags" />
</x-layout>