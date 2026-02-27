<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Messages flash --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-5 py-4 rounded-r-lg shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border-l-4 border-red-500 text-red-800 px-5 py-4 rounded-r-lg shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            {{-- En-tête utilisateur + solde --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Bienvenue</p>
                            <h3 class="mt-1 text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                        </div>
                        <div class="sm:text-right">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Solde disponible</p>
                            <div class="mt-1 flex items-baseline gap-1.5 sm:justify-end">
                                <span class="text-3xl font-bold text-gray-900">{{ $user->points }}</span>
                                <span class="text-sm font-medium text-gray-500">point{{ $user->points > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activités inscrites --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100">
                <div class="px-8 pt-8 pb-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Mes inscriptions</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if($activities->isEmpty())
                                    Aucune activité pour le moment
                                @else
                                    {{ $activities->count() }} activité{{ $activities->count() > 1 ? 's' : '' }} à venir
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-150">
                            Voir le catalogue
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                @if($activities->isEmpty())
                    <div class="px-8 py-12 text-center">
                        <svg class="mx-auto w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                        <p class="mt-4 text-sm text-gray-500">Vous n'êtes inscrit à aucune activité.</p>
                        <a href="{{ route('activities.index') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors duration-150">
                            Découvrir les activités
                        </a>
                    </div>
                @else
                    <div class="mt-4">
                        {{-- Vue desktop : tableau --}}
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-t border-gray-100">
                                        <th class="px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Activité</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Heure</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lieu</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Coût</th>
                                        <th class="px-8 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                        <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition-colors duration-100">
                                            <td class="px-8 py-4">
                                                <span class="font-semibold text-gray-900">{{ $activity->title }}</span>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($activity->activity_time)->format('H:i') }}
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-600">
                                                {{ $activity->location }}
                                            </td>
                                            <td class="px-4 py-4 text-sm text-right">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                                    {{ $activity->points_cost }} pts
                                                </span>
                                            </td>
                                            <td class="px-8 py-4 text-right">
                                                <form action="{{ route('activities.unregister', $activity) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment vous désinscrire de cette activité ? Vos points seront remboursés.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors duration-150">
                                                        Se désinscrire
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Vue mobile : cartes --}}
                        <div class="sm:hidden divide-y divide-gray-100 border-t border-gray-100">
                            @foreach($activities as $activity)
                                <div class="px-6 py-5">
                                    <div class="flex items-start justify-between">
                                        <div class="space-y-1">
                                            <h4 class="font-semibold text-gray-900">{{ $activity->title }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}
                                                à {{ \Carbon\Carbon::parse($activity->activity_time)->format('H:i') }}
                                            </p>
                                            <p class="text-sm text-gray-500">{{ $activity->location }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            {{ $activity->points_cost }} pts
                                        </span>
                                    </div>
                                    <form action="{{ route('activities.unregister', $activity) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment vous désinscrire de cette activité ? Vos points seront remboursés.')" class="mt-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors duration-150">
                                            Se désinscrire
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>