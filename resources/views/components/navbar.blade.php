<header class="bg-white border-b border-gray-200">
    <nav class="max-w-5xl mx-auto px-4 py-3 flex flex-wrap items-center gap-2" aria-label="Navigation principale">
        <a href="{{ route('home') }}" class="font-bold text-lg text-indigo-600 mr-4">Mini-CMS</a>

        <x-nav-link to="home">Accueil</x-nav-link>
        <x-nav-link to="posts.index" match="posts.*">Articles</x-nav-link>
        <x-nav-link to="time">Heure</x-nav-link>
        <x-nav-link to="about">À propos</x-nav-link>

        <div class="ml-auto flex flex-wrap items-center gap-2">
            @auth
                <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">Déconnexion</button>
                </form>
            @endauth

            @guest
                <x-nav-link to="login">Connexion</x-nav-link>
                <x-nav-link to="register">Inscription</x-nav-link>
            @endguest
        </div>
    </nav>
</header>