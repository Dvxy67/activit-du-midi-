<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activités disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Messages de succès/erreur -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Liste des activités -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($activities as $activity)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-2">{{ $activity->title }}</h3>
                            <p class="text-gray-600 mb-3">{{ $activity->description }}</p>
                            
                            <div class="space-y-2 text-sm text-gray-500 mb-4">
                                <div>📅 {{ $activity->activity_date->format('d/m/Y') }}</div>
                                <div>🕐 {{ $activity->activity_time->format('H:i') }}</div>
                                <div>👥 {{ $activity->users->count() }}/{{ $activity->max_participants }} inscrits</div>
                                <div>📍 {{ $activity->availableSpots() }} places restantes</div>
                            </div>

                            @if ($activity->hasUser(auth()->id()))
                                <!-- Utilisateur déjà inscrit -->
                                <div class="flex items-center justify-between">
                                    <span class="text-green-600 font-medium">✅ Inscrit</span>
                                    <form method="POST" action="{{ route('activities.unregister', $activity) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm"
                                                onclick="return confirm('Êtes-vous sûr de vouloir vous désinscrire ?')">
                                            Se désinscrire
                                        </button>
                                    </form>
                                </div>
                            @elseif ($activity->isFull())
                                <!-- Activité complète -->
                                <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded">
                                    Complet
                                </button>
                            @else
                                <!-- Peut s'inscrire -->
                                <form method="POST" action="{{ route('activities.register', $activity) }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        S'inscrire
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-8">
                        <p>Aucune activité disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>