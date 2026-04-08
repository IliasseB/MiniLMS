@extends('layouts.app')

@section('title', 'Modifier la note')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier la note</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('notes.update', $note) }}">
                @csrf
                @method('PUT')

                <!-- Matière -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Matière</label>
                    <input type="text" name="matiere" value="{{ old('matiere', $note->matiere) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('matiere')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Note -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Note (sur 20)</label>
                    <input type="number" name="note" value="{{ old('note', $note->note) }}" min="0" max="20" step="0.5"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('note')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Apprenant -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Apprenant</label>
                    <select name="apprenant_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">-- Choisir un apprenant --</option>
                        @foreach($apprenants as $apprenant)
                            <option value="{{ $apprenant->id }}" {{ old('apprenant_id', $note->apprenant_id) == $apprenant->id ? 'selected' : '' }}>
                                {{ $apprenant->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('apprenant_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                    <a href="{{ route('notes.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection