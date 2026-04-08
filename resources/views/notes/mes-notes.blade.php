@extends('layouts.app')

@section('title', 'Mes notes')

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes notes</h1>
            <p class="text-gray-400 mt-1">Suivez vos performances académiques et visualisez vos résultats par matière.</p>
        </div>

        @php
            $moyenne = $notes->count() > 0 ? round($notes->avg('note'), 2) : null;
            $apprenant = auth()->user()->apprenant;
            $resultats = $apprenant->resultatsQuiz()->with('quiz.questions')->latest()->get();
            $moyenneQuiz = $resultats->count() > 0
                ? round($resultats->avg(fn($r) => $r->quiz->questions->count() > 0 ? ($r->score / $r->quiz->questions->count()) * 20 : 0), 2)
                : null;
        @endphp

        <!-- Cartes du haut -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <!-- Moyenne générale notes -->
            @if($moyenne !== null)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Moyenne Générale</p>
                    <p class="text-6xl font-bold text-indigo-600">{{ $moyenne }}<span class="text-3xl text-gray-400 font-normal ml-1">/20</span></p>
                </div>
            @endif

            <!-- Moyenne Quiz -->
            <div class="bg-indigo-600 rounded-2xl shadow-sm p-8">
                <p class="text-xs font-bold text-white uppercase tracking-wide mb-3" style="opacity:0.7">Moyenne Quiz</p>
                @if($moyenneQuiz !== null)
                    <p class="text-6xl font-bold text-white">{{ $moyenneQuiz }}<span class="text-3xl text-white font-normal ml-1" style="opacity:0.7">/20</span></p>
                @else
                    <p class="text-xl font-bold text-white mt-4" style="opacity:0.7">Aucun quiz passé</p>
                @endif
            </div>
        </div>

        <!-- Tableau des notes -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Matière</span>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Note</span>
            </div>

            @forelse($notes as $note)
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-50 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800">{{ $note->matiere }}</p>
                    </div>
                    @php
                        $couleur = $note->note >= 16 ? 'bg-green-100 text-green-700' : ($note->note >= 10 ? 'bg-indigo-100 text-indigo-700' : 'bg-red-100 text-red-700');
                    @endphp
                    <span class="px-3 py-1 rounded-lg font-bold text-sm {{ $couleur }}">
                        {{ $note->note }}/20
                    </span>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-400">Aucune note disponible.</p>
                </div>
            @endforelse
        </div>

        <!-- Résultats de quiz -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Quiz</span>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Score</span>
            </div>

            @forelse($resultats as $resultat)
                <div class="flex items-center justify-between px-6 py-5 border-b border-gray-50 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-800">{{ $resultat->quiz->titre }}</p>
                    </div>
                    @php
                        $total = $resultat->quiz->questions->count();
                        $pourcentage = $total > 0 ? round(($resultat->score / $total) * 100) : 0;
                        $couleur = $pourcentage >= 70 ? 'bg-green-100 text-green-700' : ($pourcentage >= 50 ? 'bg-indigo-100 text-indigo-700' : 'bg-red-100 text-red-700');
                    @endphp
                    <div class="flex items-center gap-3">
                        <a href="{{ route('resultats.show', $resultat) }}" class="text-xs font-medium text-indigo-600 hover:underline">
                            Consulter →
                        </a>
                        <span class="px-3 py-1 rounded-lg font-bold text-sm {{ $couleur }}">
                            {{ $resultat->score }}/{{ $total }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-400">Aucun quiz passé pour le moment.</p>
                </div>
            @endforelse
        </div>

    </div>
@endsection