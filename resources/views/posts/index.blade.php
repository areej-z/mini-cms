@forelse ($posts as $post)
    <x-post-card :post="$post" />
@empty
    <x-alert type="info">
        Aucun article ne correspond à votre recherche.
    </x-alert>
@endforelse