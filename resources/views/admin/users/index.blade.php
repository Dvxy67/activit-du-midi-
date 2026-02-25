<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des utilisateurs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 text-green-600 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 pr-4">Nom</th>
                            <th class="py-2 pr-4">Email</th>
                            <th class="py-2 pr-4">Points</th>
                            <th class="py-2 pr-4">Admin</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 pr-4">{{ $user->name }}</td>
                            <td class="py-2 pr-4">{{ $user->email }}</td>
                            <td class="py-2 pr-4">{{ $user->points }} pts</td>
                            <td class="py-2 pr-4">
                                @if($user->is_admin)
                                    <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full">Admin</span>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">Utilisateur</span>
                                @endif
                            </td>
                            <td class="py-2">
                                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="points" value="{{ $user->points }}"
                                           class="border rounded px-2 py-1 w-24 text-sm" min="0">
                                    <button type="submit"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        Modifier
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>