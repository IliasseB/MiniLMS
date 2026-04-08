@extends('layouts.app')

@section('title', 'Détail de la formation')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $formation->nom }}</h1>
            <div class="flex gap-3">
                <a href="{{ route('formations.edit', $formation) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Modifier
                </a>
                <a href="{{ route('formations.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Retour
                </a>
            </div>
        </div>

        <!-- Informations de la formation -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations</h2>
            <p><span class="font-medium">Niveau :</span> {{ $formation->niveau }}</p>
            <p><span class="font-medium">Durée :</span> {{ $formation->duree ?? '-' }}h</p>
            <p class="mt-2"><span class="font-medium">Description :</span> {{ $formation->description ?? 'Aucune description.' }}</p>
        </div>

        <!-- Chapitres associés -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Chapitres</h2>
            @forelse($formation->chapitres as $chapitre)
                <div class="border-b py-2">
                    <a href="{{ route('chapitres.show', $chapitre) }}" class="text-indigo-600 hover:underline">
                        {{ $chapitre->titre }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">Aucun chapitre pour cette formation.</p>
            @endforelse
        </div>

        <!-- Apprenants associés -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Apprenants</h2>
            @forelse($formation->apprenants as $apprenant)
                <div class="border-b py-2">
                    <a href="{{ route('apprenants.show', $apprenant) }}" class="text-indigo-600 hover:underline">
                        {{ $apprenant->nom }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">Aucun apprenant pour cette formation.</p>
            @endforelse
        </div>
    </div>
@endsection