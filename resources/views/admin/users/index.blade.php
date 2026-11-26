<x-layout>
    <x-slot:title>Utilisateurs - Mini-CMS</x-slot:title>

    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-gray-900">Utilisateurs</h1>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-gray-200 text-gray-600">
                <tr>
                    <th scope="col" class="py-2 pr-4 font-medium">Nom</th>
                    <th scope="col" class="py-2 pr-4 font-medium">E-mail</th>
                    <th scope="col" class="py-2 pr-4 font-medium">Rôle</th>
                    <th scope="col" class="py-2 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b border-gray-100 align-middle">
                        <td class="py-3 pr-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="py-3 pr-4 text-gray-600">{{ $user->email }}</td>
                        <td class="py-3 pr-4 text-gray-600">{{ $user->role }}</td>
                        <td class="py-3">
                            @can('updateRole', $user)
                                @php($nextRole = $user->isAdmin() ? 'author' : 'admin')
                                <form method="POST" action="{{ route('admin.users.role', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="role" value="{{ $nextRole }}">
                                    <button type="submit" class="rounded-md border border-indigo-600 px-4 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50">
                                        {{ $user->isAdmin() ? 'Passer en auteur' : 'Passer en administrateur' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">Compte actuel</span>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
