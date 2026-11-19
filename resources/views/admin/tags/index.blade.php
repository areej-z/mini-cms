<x-layout>
    <x-slot:title>Tags - Mini-CMS</x-slot:title>

    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-gray-900">Tags</h1>
        <a href="{{ route('admin.tags.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Nouveau tag</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-gray-200 text-gray-600">
                <tr>
                    <th scope="col" class="py-2 pr-4 font-medium">Nom</th>
                    <th scope="col" class="py-2 pr-4 font-medium">Slug</th>
                    <th scope="col" class="py-2 pr-4 font-medium">Articles</th>
                    <th scope="col" class="py-2 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tags as $tag)
                    <tr class="border-b border-gray-100 align-top">
                        <td class="py-3 pr-4 font-medium text-gray-900">{{ $tag->name }}</td>
                        <td class="py-3 pr-4 text-gray-600">{{ $tag->slug }}</td>
                        <td class="py-3 pr-4 text-gray-600">{{ $tag->posts_count }}</td>
                        <td class="py-3">
                            <div class="flex flex-wrap items-start gap-3">
                                <a href="{{ route('admin.tags.edit', $tag) }}" class="rounded-md border border-indigo-600 px-4 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50">Modifier</a>

                                <details>
                                    <summary class="cursor-pointer rounded-md border border-red-600 px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50">Supprimer</summary>

                                    <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" class="mt-3 rounded-md border border-red-200 bg-red-50 p-4">
                                        @csrf
                                        @method('DELETE')

                                        <p class="mb-3 text-sm text-red-900">Supprimer ce tag ? Il sera retiré de ses articles.</p>
                                        <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Confirmer la suppression</button>
                                    </form>
                                </details>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">Aucun tag pour l'instant.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>