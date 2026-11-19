<x-layout>
    <x-slot:title>Nouvelle catégorie - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">Nouvelle catégorie</h1>
    <p class="mt-2 mb-8 text-gray-600">Le slug sert dans l'adresse de la page publique de la catégorie.</p>

    @if ($errors->any())
        <x-alert type="error" title="Le formulaire contient des erreurs" class="mb-6 max-w-2xl">
            Corrigez les champs signalés, puis envoyez à nouveau.
        </x-alert>
    @endif

    <form method="POST" action="{{ route('admin.categories.store') }}" class="max-w-2xl space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">
            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2.5 font-medium text-white hover:bg-indigo-700">Créer</button>
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 hover:underline">Annuler</a>
        </div>
    </form>
</x-layout>