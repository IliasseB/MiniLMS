@extends('layouts.app')

@section('title', 'Détail du sous-chapitre')

@section('content')

    <!-- Fil d'ariane -->
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
        <a href="{{ route('formations.index') }}" class="hover:text-indigo-600">Formations</a>
        <span>›</span>
        <a href="{{ route('chapitres.show', $sousChapitre->chapitre) }}" class="hover:text-indigo-600">{{ $sousChapitre->chapitre->titre }}</a>
        <span>›</span>
        <span class="text-gray-700 font-medium">{{ $sousChapitre->titre }}</span>
    </div>

    <!-- En-tête -->
    <div class="flex items-start justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $sousChapitre->titre }}</h1>
        <div class="flex gap-3">
            <a href="{{ route('sous-chapitres.index') }}" class="flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                ← Retour
            </a>
            <a href="{{ route('contenus-ia.create') }}" class="flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition text-sm font-medium">
                ↑ Importer du contenu
            </a>
            <a href="{{ route('sous-chapitres.edit', $sousChapitre) }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
                ✏️ Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <!-- Colonne principale (2/3) -->
        <div class="col-span-2 flex flex-col gap-6">

            <!-- Informations -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Informations</h2>
                </div>

                <div class="mb-4">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Chapitre</p>
                    <p class="font-semibold text-gray-800">{{ $sousChapitre->chapitre->titre }}</p>
                </div>

                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Formation</p>
                    <p class="font-semibold text-gray-800">{{ $sousChapitre->chapitre->formation->nom }}</p>
                </div>
            </div>

            <!-- Contenu -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800">Résumé</h2>
                    </div>
                    <a href="{{ route('sous-chapitres.edit', $sousChapitre) }}" class="text-indigo-600 text-sm font-medium hover:underline">
                        Modifier le résumé
                    </a>
                </div>

                @if($sousChapitre->contenu)
                    <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $sousChapitre->contenu }}
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-600 mb-1">Aucun contenu pour ce sous-chapitre</p>
                        <p class="text-sm text-gray-400">Commencez par ajouter du contenu pédagogique.</p>
                    </div>
                @endif
            </div>

            <!-- Contenus importés -->
            @if($sousChapitre->contenusIa->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800">Contenus</h2>
                    </div>
                    @foreach($sousChapitre->contenusIa as $contenuIa)
                        <a href="{{ route('contenus-ia.show', $contenuIa) }}" class="flex items-center gap-3 py-3 border-b border-gray-50 hover:bg-gray-50 rounded-xl px-2 -mx-2 transition">
                            <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-700">{{ $contenuIa->titre }}</p>
                                @if($contenuIa->source)
                                    <p class="text-xs text-gray-400">{{ $contenuIa->source }}</p>
                                @endif
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">Complété</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Sidebar droite (1/3) -->
        <div class="flex flex-col gap-6">

            <!-- Quiz associé -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Quiz associé</h2>
                </div>

                @if($sousChapitre->quiz)
                    <a href="{{ route('quiz.show', $sousChapitre->quiz) }}" class="flex items-center gap-3 p-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition mb-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-indigo-700 text-sm">{{ $sousChapitre->quiz->titre }}</p>
                            <p class="text-xs text-indigo-400">{{ $sousChapitre->quiz->questions->count() }} question(s)</p>
                        </div>
                    </a>
                @else
                    <div class="flex flex-col items-center justify-center py-6 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 mb-3">Aucun quiz associé</p>
                        <a href="{{ route('quiz.create') }}" class="w-full text-center bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-indigo-700 transition">
                            + Ajouter un quiz
                        </a>
                    </div>
                @endif
            </div>

            <!-- Aperçu rapide -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Aperçu rapide</p>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Statut</span>
                        <span class="text-xs font-bold text-green-700 bg-green-50 px-3 py-1 rounded-full">Publié</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-50 pt-3">
                        <span class="text-sm text-gray-600">Dernière modif.</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $sousChapitre->updated_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-50 pt-3">
                        <span class="text-sm text-gray-600">Temps estimé</span>
                        <span class="text-sm font-semibold text-gray-800">
                            {{ max(1, ceil(str_word_count($sousChapitre->contenu ?? '') / 200)) }} min
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection