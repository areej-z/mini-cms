<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Mini-CMS' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 flex flex-col">
    <header class="bg-white border-b border-gray-200">
        <nav class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap items-center gap-2" aria-label="Navigation principale">
            <a href="{{ url('/') }}" class="font-bold text-lg text-indigo-600 mr-4">Mini-CMS</a>
            <a
                href="{{ url('/') }}"
                class="px-3 py-2 rounded-md text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100"
            >
                Accueil
            </a>
            <a
                href="{{ route('posts.index') }}"
                @if (request()->routeIs('posts.*')) aria-current="page" @endif
                class="px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('posts.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}"
            >
                Articles
            </a>
        </nav>
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 py-8 space-y-6">
        @if (config('site.read_only'))
            <x-alert type="warning" title="Site en lecture seule">
                Les opérations de création, modification et suppression sont temporairement désactivées.
            </x-alert>
        @endif

        @if (session('success'))
            <x-alert type="success" title="Succès">
                {{ session('success') }}
            </x-alert>
        @endif

        {{ $slot }}
    </main>

    <footer class="border-t border-gray-200 py-6 text-center text-sm text-gray-500">
        Mini-CMS - Atelier Framework Côté Serveur - ISET Sidi Bouzid
    </footer>
</body>
</html>