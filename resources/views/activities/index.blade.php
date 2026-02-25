<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Activités disponibles
            </h2>
            <div class="flex items-center gap-2 text-gray-600 bg-white border border-gray-200 px-4 py-2 rounded-full text-sm font-medium shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ Auth::user()->points }} <span class="text-gray-400 font-normal">points</span></span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 bg-white border border-emerald-100 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 bg-white border border-red-100 text-red-600 px-5 py-4 rounded-2xl shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Grille des activités --}}
            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($activities as $activity)

                    @php
                        $isRegistered = $activity->hasUser(auth()->id());
                        $isFull = $activity->isFull();
                        $canAfford = Auth::user()->points >= $activity->points_cost;
                        $percent = ($activity->users->count() / $activity->max_participants) * 100;
                    @endphp

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">

                        {{-- Bande de statut fine en haut --}}
                        <div class="h-1 w-full
                            @if ($isRegistered) bg-emerald-400
                            @elseif ($isFull) bg-gray-300
                            @else bg-slate-300
                            @endif
                        "></div>

                        <div class="p-6 flex flex-col flex-1">

                            {{-- Titre + badge statut --}}
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h3 class="text-base font-semibold text-gray-900 leading-snug">{{ $activity->title }}</h3>
                                <span class="shrink-0 text-xs font-medium px-2.5 py-1 rounded-full
                                    @if ($isRegistered) bg-emerald-50 text-emerald-600
                                    @elseif ($isFull) bg-gray-100 text-gray-400
                                    @else bg-slate-50 text-slate-500
                                    @endif
                                ">
                                    @if ($isRegistered) Inscrit
                                    @elseif ($isFull) Complet
                                    @else Disponible
                                    @endif
                                </span>
                            </div>

                            <p class="text-gray-400 text-sm mb-5 leading-relaxed flex-1">{{ $activity->description }}</p>

                            {{-- Infos --}}
                            <div class="space-y-2 text-sm text-gray-500 mb-5">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $activity->activity_date->format('d/m/Y') }}</span>
                                    <span class="text-gray-300">·</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $activity->activity_time->format('H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-gray-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $activity->users->count() }}/{{ $activity->max_participants }} inscrits</span>
                                    <span class="text-gray-300">·</span>
                                    <span class="
                                        @if ($activity->availableSpots() <= 3) text-amber-500
                                        @else text-gray-400
                                        @endif
                                    ">{{ $activity->availableSpots() }} places</span>
                                </div>
                            </div>

                            {{-- Barre de progression --}}
                            <div class="mb-5">
                                <div class="w-full bg-gray-100 rounded-full h-1">
                                    <div class="h-1 rounded-full transition-all duration-300
                                        @if ($isFull) bg-gray-400
                                        @elseif ($percent >= 75) bg-amber-400
                                        @else bg-slate-300
                                        @endif"
                                         style="width: {{ $percent }}%">
                                    </div>
                                </div>
                            </div>

                            {{-- Séparateur + Coût + Bouton --}}
                            <div class="border-t border-gray-50 pt-4 flex items-center justify-between gap-3">
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $activity->points_cost }}
                                    <span class="text-gray-400 font-normal text-xs">pts</span>
                                </span>

                                @if ($isRegistered)
                                    <form method="POST" action="{{ route('activities.unregister', $activity) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Êtes-vous sûr de vouloir vous désinscrire ?')"
                                                class="text-sm text-gray-400 hover:text-red-500 font-medium transition duration-150 underline underline-offset-2">
                                            Se désinscrire
                                        </button>
                                    </form>
                                @elseif ($isFull)
                                    <span class="text-sm text-gray-300 font-medium">Complet</span>
                                @elseif (!$canAfford)
                                    <span class="text-sm text-amber-400 font-medium">Points insuffisants</span>
                                @else
                                    <form method="POST" action="{{ route('activities.register', $activity) }}">
                                        @csrf
                                        <button type="submit"
                                                class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium py-2 px-5 rounded-xl transition duration-150">
                                            S'inscrire
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="col-span-full text-center py-16 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-400">Aucune activité disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
