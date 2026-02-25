<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier l'activité
            </h2>
            <a href="{{ route('admin.activities.index') }}"
               class="text-sm text-gray-400 hover:text-gray-600 transition duration-150">
                Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

                <form method="POST" action="{{ route('admin.activities.update', $activity) }}">
                    @csrf
                    @method('PATCH')

                    {{-- Titre --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre</label>
                        <input type="text" name="title" value="{{ old('title', $activity->title) }}"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        @error('title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">{{ old('description', $activity->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date et Heure --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                            <input type="date" name="activity_date" value="{{ old('activity_date', $activity->activity_date->format('Y-m-d')) }}"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            @error('activity_date')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Heure</label>
                            <input type="time" name="activity_time" value="{{ old('activity_time', $activity->activity_time->format('H:i')) }}"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            @error('activity_time')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Places et Points --}}
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de places</label>
                            <input type="number" name="max_participants" value="{{ old('max_participants', $activity->max_participants) }}" min="1"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            @error('max_participants')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Coût en points</label>
                            <input type="number" name="points_cost" value="{{ old('points_cost', $activity->points_cost) }}" min="0"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                            @error('points_cost')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Bouton --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium py-2.5 px-6 rounded-xl transition duration-150">
                            Sauvegarder
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>