@extends('layouts.app')

@section('title', 'Nouvelle formation')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle formation</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('formations.store') }}">
                @csrf

                <!-- Nom -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Nom</label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Niveau -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Niveau</label>
                    <select name="niveau" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">-- Choisir un niveau --</option>
                        <option value="Débutant" {{ old('niveau') == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                        <option value="Intermédiaire" {{ old('niveau') == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                        <option value="Avancé" {{ old('niveau') == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                    </select>
                    @error('niveau')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Durée -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Durée (en heures)</label>
                    <input type="number" name="duree" value="{{ old('duree') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('duree')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Créer
                    </button>
                    <a href="{{ route('formations.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection