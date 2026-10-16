<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo ou Titre du site -->
                <span class="font-bold text-xl text-gray-800">Mini-CMS</span>

                <!-- Liens de navigation -->
                <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link route="home">
                        Accueil
                    </x-nav-link>

                    <x-nav-link route="posts.index">
                        Articles
                    </x-nav-link>

                    <x-nav-link route="time">
                        Heure
                    </x-nav-link>

                    <x-nav-link route="about">
                        À propos
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
