@extends('layouts.app')

@section('title', 'Modifier l\'apprenant')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier l'apprenant</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('apprenants.update', $apprenant) }}">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Nom Complet</label>
                    <input type="text" name="nom" value="{{ old('nom', $apprenant->nom) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $apprenant->email) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Formations -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Formations</label>
                    @foreach($formations as $formation)
                        <label class="flex items-center gap-2 mb-2 cursor-pointer">
                            <input type="checkbox" name="formations[]" value="{{ $formation->id }}"
                                {{ in_array($formation->id, old('formations', $apprenant->formations->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-600">
                            <span class="text-gray-700">{{ $formation->nom }}</span>
                        </label>
                    @endforeach
                    @error('formations')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                    <a href="{{ route('apprenants.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection