@extends('layouts.app')

@section('title', 'Détail du quiz')

@section('content')

    <!-- En-tête -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <p class="text-xs font-bold text-indigo-600 uppercase tracking-wide mb-1">
                {{ $quiz->sousChapitre->chapitre->formation->nom }} › {{ $quiz->sousChapitre->chapitre->titre }}
            </p>
            <h1 class="text-3xl font-bold text-gray-900">{{ $quiz->titre }}</h1>
            <p class="text-gray-400 mt-1">{{ $quiz->sousChapitre->titre }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('quiz.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                ← Retour
            </a>
            <a href="{{ route('quiz.edit', $quiz) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
                ✏️ Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <!-- Questions (2/3) -->
        <div class="col-span-2 flex flex-col gap-4">
            @forelse($quiz->questions as $index => $question)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm flex-shrink-0">
                            {{ $index + 1 }}
                        </div>
                        <p class="font-semibold text-gray-800">{{ $question->question }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($question->reponses as $reponse)
                            <div class="flex items-center gap-2 px-4 py-3 rounded-xl border
                                {{ $reponse->est_correcte ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-100' }}">
                                <div class="w-4 h-4 rounded-full flex-shrink-0
                                    {{ $reponse->est_correcte ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                                <span class="text-sm {{ $reponse->est_correcte ? 'text-green-700 font-semibold' : 'text-gray-600' }}">
                                    {{ $reponse->texte }}
                                </span>
                                @if($reponse->est_correcte)
                                    <svg class="w-4 h-4 text-green-500 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-8 text-center text-gray-400">
                    Aucune question pour ce quiz.
                </div>
            @endforelse
        </div>

        <!-- Sidebar (1/3) -->
        <div class="flex flex-col gap-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Aperçu rapide</p>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Questions</span>
                        <span class="text-sm font-bold text-gray-800">{{ $quiz->questions->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-50 pt-3">
                        <span class="text-sm text-gray-600">Passages</span>
                        <span class="text-sm font-bold text-gray-800">{{ \App\Models\ResultatQuiz::where('quiz_id', $quiz->id)->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-50 pt-3">
                        <span class="text-sm text-gray-600">Sous-chapitre</span>
                        <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md">{{ Str::limit($quiz->sousChapitre->titre, 15) }}</span>
                    </div>
                </div>
            </div>

            <!-- Supprimer -->
            <form method="POST" action="{{ route('quiz.destroy', $quiz) }}" onsubmit="return confirm('Supprimer ce quiz ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-50 text-red-500 px-4 py-3 rounded-xl hover:bg-red-100 transition text-sm font-medium">
                    Supprimer le quiz
                </button>
            </form>
        </div>
    </div>

@endsection