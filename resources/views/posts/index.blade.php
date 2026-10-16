<x-layout>
    <x-slot:title>{{ $heading }} - Mini-CMS</x-slot:title>

    <x-page-header :title="$heading" />

    <div class="grid gap-6 md:grid-cols-2">
        @forelse ($posts as $post)
            <x-post-card :post="$post" />
        @empty
            <x-alert type="warning" title="Aucun article" class="md:col-span-2">
                Il n'y a pas encore d'article.
            </x-alert>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-layout>