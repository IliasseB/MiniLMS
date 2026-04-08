@extends('layouts.app')

@section('title', 'Nouveau sous-chapitre')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouveau sous-chapitre</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('sous-chapitres.store') }}">
                @csrf

                <!-- Titre -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('titre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contenu -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Résumé du sous chapitre</label>
                    <textarea name="contenu" rows="6"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('contenu') }}</textarea>
                    @error('contenu')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Chapitre -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Chapitre</label>
                    <select name="chapitre_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">-- Choisir un chapitre --</option>
                        @foreach($chapitres as $chapitre)
                            <option value="{{ $chapitre->id }}" {{ old('chapitre_id') == $chapitre->id ? 'selected' : '' }}>
                                {{ $chapitre->titre }}
                            </option>
                        @endforeach
                    </select>
                    @error('chapitre_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Créer
                    </button>
                    <a href="{{ route('sous-chapitres.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection