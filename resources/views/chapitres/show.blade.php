@extends('layouts.app')

@section('title', 'Détail du chapitre')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $chapitre->titre }}</h1>
            <div class="flex gap-3">
                <a href="{{ route('chapitres.edit', $chapitre) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Modifier
                </a>
                <a href="{{ route('chapitres.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Retour
                </a>
            </div>
        </div>

        <!-- Informations du chapitre -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations</h2>
            <p><span class="font-medium">Formation :</span> {{ $chapitre->formation->nom }}</p>
            <p class="mt-2"><span class="font-medium">Description :</span> {{ $chapitre->description ?? 'Aucune description.' }}</p>
        </div>

        <!-- Sous-chapitres associés -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Sous-chapitres</h2>
            @forelse($chapitre->souschapitres as $sousChapitre)
                <div class="border-b py-2">
                    <a href="{{ route('sous-chapitres.show', $sousChapitre) }}" class="text-indigo-600 hover:underline">
                        {{ $sousChapitre->titre }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">Aucun sous-chapitre pour ce chapitre.</p>
            @endforelse
        </div>
    </div>
@endsection