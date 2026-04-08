@extends('layouts.app')

@section('title', 'Mes formations')

@section('content')
    <div class="max-w-5xl mx-auto">

        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes formations</h1>
            <p class="text-gray-400 mt-1">Continuez votre apprentissage là où vous vous étiez arrêté.</p>
        </div>

        @forelse($formations as $formation)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">

                <!-- En-tête de la formation -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <!-- Badges -->
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md uppercase tracking-wide">
                                {{ $formation->niveau }}
                            </span>
                            @if($formation->duree)
                                <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                    {{ $formation->duree }}H
                                </span>
                            @endif
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $formation->nom }}</h2>
                        @if($formation->description)
                            <p class="text-gray-400 text-sm mt-1">{{ $formation->description }}</p>
                        @endif
                    </div>
                    <!-- Icône -->
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0 ml-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>

                <!-- Contenu du cours -->
                <div class="border border-gray-100 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Contenu du cours</span>
                    </div>

                    @foreach($formation->chapitres as $chapitre)
                        <div class="mb-3">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="font-semibold text-gray-700 text-sm">{{ $chapitre->titre }}</span>
                            </div>
                            @foreach($chapitre->souschapitres as $sousChapitre)
                                <div class="flex items-center justify-between py-1.5 pl-6">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-indigo-400 flex-shrink-0"></span>
                                        <span class="text-sm text-gray-600">{{ $sousChapitre->titre }}</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('souschapitres.consulter', $sousChapitre) }}" class="text-xs font-medium text-indigo-600 hover:underline">
                                            Consulter →
                                        </a>
                                        @if($sousChapitre->quiz)
                                            <a href="{{ route('quiz.passer', $sousChapitre->quiz) }}" class="text-xs font-medium text-indigo-600 hover:underline">
                                                Passer le quiz →
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <p class="text-gray-400">Vous n'êtes inscrit à aucune formation.</p>
            </div>
        @endforelse
    </div>
@endsection