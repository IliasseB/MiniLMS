@extends('layouts.app')

@section('title', 'Modifier le quiz')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le quiz</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('quiz.update', $quiz) }}">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre', $quiz->titre) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('titre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sous-chapitre -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Sous-chapitre</label>
                    <select name="sous_chapitre_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">-- Choisir un sous-chapitre --</option>
                        @foreach($souschapitres as $sousChapitre)
                            <option value="{{ $sousChapitre->id }}" {{ old('sous_chapitre_id', $quiz->sous_chapitre_id) == $sousChapitre->id ? 'selected' : '' }}>
                                {{ $sousChapitre->titre }}
                            </option>
                        @endforeach
                    </select>
                    @error('sous_chapitre_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                    <a href="{{ route('quiz.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection