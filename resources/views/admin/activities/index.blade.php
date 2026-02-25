<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des activités
            </h2>
            <a href="{{ route('admin.activities.create') }}"
               class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium py-2 px-5 rounded-xl transition duration-150">
                Nouvelle activité
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 bg-white border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Titre</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Heure</th>
                            <th class="px-6 py-4">Places</th>
                            <th class="px-6 py-4">Coût</th>
                            <th class="px-6 py-4">Inscrits</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($activities as $activity)
                            <tr class="hover:bg-gray-50 transition duration-100">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $activity->title }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $activity->activity_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $activity->activity_time->format('H:i') }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $activity->max_participants }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $activity->points_cost }} pts</td>
                                <td class="px-6 py-4 text-gray-500">{{ $activity->users->count() }}</td>
                                <td class="px-6 py-4 flex items-center gap-4 justify-end">
                                    <a href="{{ route('admin.activities.edit', $activity) }}"
                                       class="text-gray-400 hover:text-gray-700 font-medium transition duration-150">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('admin.activities.destroy', $activity) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Supprimer cette activité ?')"
                                                class="text-red-400 hover:text-red-600 font-medium transition duration-150">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                    Aucune activité pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>