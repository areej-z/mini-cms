<x-layout>
    <x-slot:title>Connexion - Mini-CMS</x-slot:title>

    <x-page-header title="Connexion" subtitle="Connectez-vous pour écrire et modifier vos articles." />

    <form method="POST" action="{{ route('login.store') }}" class="max-w-md space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
            <input type="password" id="password" name="password" autocomplete="current-password" class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="rounded-md bg-indigo-600 px-5 py-2.5 font-medium text-white hover:bg-indigo-700">Se connecter</button>

        <p class="text-sm text-gray-600">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:underline">Créer un compte</a>
        </p>
    </form>
</x-layout>