@extends('layouts.app')

@section('title', 'Consultation du quiz')

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- En-tête -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $resultatQuiz->quiz->titre }}</h1>
                <p class="text-gray-400 mt-1">Consultation du résultat</p>
            </div>
            <a href="{{ auth()->user()->role === 'admin' ? route('apprenants.show', $resultatQuiz->apprenant) : route('mes-notes') }}"
                class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                ← Retour
            </a>
        </div>

        <!-- Score global -->
        @php
            $total = $resultatQuiz->quiz->questions->count();
            $pourcentage = $total > 0 ? round(($resultatQuiz->score / $total) * 100) : 0;
            $couleur = $pourcentage >= 70 ? 'bg-green-100 text-green-700' : ($pourcentage >= 50 ? 'bg-indigo-100 text-indigo-700' : 'bg-red-100 text-red-700');
            $reponsesDonnees = json_decode($resultatQuiz->reponses_donnees, true) ?? [];
            $aDesReponses = !empty($reponsesDonnees);
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-6 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Score</p>
                <p class="text-6xl font-bold text-indigo-600">{{ $resultatQuiz->score }}<span class="text-3xl text-gray-400 font-normal">/{{ $total }}</span></p>
                @if(auth()->user()->role === 'admin')
                    <p class="text-sm text-gray-500 mt-2">Apprenant : <span class="font-semibold text-gray-700">{{ $resultatQuiz->apprenant->nom }}</span></p>
                @endif
            </div>
            <span class="text-2xl font-bold px-6 py-3 rounded-2xl {{ $couleur }}">
                {{ $pourcentage }}%
            </span>
        </div>

        <!-- Questions et réponses -->
        <div class="flex flex-col gap-4">
            @foreach($resultatQuiz->quiz->questions as $index => $question)
                @php
                    $reponseChoisieId = ($aDesReponses && isset($reponsesDonnees[$question->id]))
                        ? (int)$reponsesDonnees[$question->id]
                        : null;
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="font-bold text-gray-800 mb-4">{{ $index + 1 }}. {{ $question->question }}</p>
                    <div class="flex flex-col gap-2">
                        @foreach($question->reponses as $reponse)
                            @php
                                $estChoisie = $reponseChoisieId === $reponse->id;
                                $estCorrecte = $reponse->est_correcte;

                                if ($estChoisie && $estCorrecte) {
                                    $style = 'bg-green-50 border border-green-200';
                                    $texte = 'text-green-700 font-semibold';
                                    $cercle = 'bg-green-500';
                                } elseif ($estChoisie && !$estCorrecte) {
                                    $style = 'bg-red-50 border border-red-200';
                                    $texte = 'text-red-600 font-semibold';
                                    $cercle = 'bg-red-500';
                                } elseif (!$estChoisie && $estCorrecte && $aDesReponses) {
                                    $style = 'bg-green-50 border border-green-200';
                                    $texte = 'text-green-700 font-semibold';
                                    $cercle = 'bg-green-500';
                                } elseif (!$aDesReponses && $estCorrecte) {
                                    $style = 'bg-green-50 border border-green-200';
                                    $texte = 'text-green-700 font-semibold';
                                    $cercle = 'bg-green-500';
                                } else {
                                    $style = 'bg-gray-50 border border-gray-100';
                                    $texte = 'text-gray-600';
                                    $cercle = 'bg-gray-300';
                                }
                            @endphp
                            <div class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $style }}">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 {{ $cercle }}">
                                    @if($estCorrecte)
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @elseif($estChoisie && !$estCorrecte)
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="{{ $texte }} text-sm">{{ $reponse->texte }}</span>
                                @if($estChoisie && !$estCorrecte)
                                    <span class="ml-auto text-xs text-red-500 font-medium">Réponse choisie</span>
                                @elseif($estChoisie && $estCorrecte)
                                    <span class="ml-auto text-xs text-green-600 font-medium">Bonne réponse ✓</span>
                                @elseif(!$estChoisie && $estCorrecte && $aDesReponses)
                                    <span class="ml-auto text-xs text-green-600 font-medium">Bonne réponse</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection