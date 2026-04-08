@extends('layouts.app')

@section('title', 'Modifier le chapitre')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le chapitre</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('chapitres.update', $chapitre) }}">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre', $chapitre->titre) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('titre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('description', $chapitre->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Formation -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Formation</label>
                    <select name="formation_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">-- Choisir une formation --</option>
                        @foreach($formations as $formation)
                            <option value="{{ $formation->id }}" {{ old('formation_id', $chapitre->formation_id) == $formation->id ? 'selected' : '' }}>
                                {{ $formation->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('formation_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                    <a href="{{ route('chapitres.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection