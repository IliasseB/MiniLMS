@extends('layouts.app')

@section('title', 'Détail de l\'apprenant')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $apprenant->nom }}</h1>
            <div class="flex gap-3">
                <a href="{{ route('apprenants.edit', $apprenant) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    Modifier
                </a>
                <a href="{{ route('apprenants.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Retour
                </a>
            </div>
        </div>

        <!-- Informations de l'apprenant -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations</h2>
            <p><span class="font-medium">Email :</span> {{ $apprenant->email }}</p>
            <div class="mt-2">
                <span class="font-medium">Formations :</span>
                <div class="mt-1 flex flex-wrap gap-2">
                    @forelse($apprenant->formations as $formation)
                        <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-sm">
                            {{ $formation->nom }}
                        </span>
                    @empty
                        <span class="text-gray-500">Aucune formation assignée.</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Notes de l'apprenant -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Notes</h2>
            @forelse($apprenant->notes as $note)
                <div class="border-b py-2 flex justify-between">
                    <span class="text-gray-700">{{ $note->matiere }}</span>
                    <span class="font-medium text-indigo-600">{{ $note->note }}/20</span>
                </div>
            @empty
                <p class="text-gray-500">Aucune note pour cet apprenant.</p>
            @endforelse
        </div>

        <!-- Résultats quiz -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Résultats quiz</h2>
            @forelse($apprenant->resultatsQuiz as $resultat)
                <div class="border-b py-3 flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 font-medium">{{ $resultat->quiz->titre }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Score : {{ $resultat->score }}/{{ $resultat->quiz->questions->count() }}</p>
                    </div>
                    <a href="{{ route('resultats.show', $resultat) }}" class="text-xs font-medium text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition">
                        Consulter le quiz →
                    </a>
                </div>
            @empty
                <p class="text-gray-500">Aucun résultat de quiz pour cet apprenant.</p>
            @endforelse
        </div>
    </div>
@endsection