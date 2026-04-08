@extends('layouts.app')

@section('title', 'Passer le quiz')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $quiz->titre }}</h1>

        <form method="POST" action="{{ route('quiz.soumettre', $quiz) }}">
            @csrf

            @forelse($quiz->questions as $question)
                <div class="bg-white shadow rounded-lg p-6 mb-4">
                    <p class="font-medium text-gray-800 mb-4">{{ $loop->iteration }}. {{ $question->question }}</p>

                    @foreach($question->reponses as $reponse)
                        <label class="flex items-center gap-3 mb-2 cursor-pointer">
                            <input type="radio" name="reponses[{{ $question->id }}]" value="{{ $reponse->id }}" required>
                            <span class="text-gray-700">{{ $reponse->texte }}</span>
                        </label>
                    @endforeach
                </div>
            @empty
                <p class="text-gray-500">Aucune question pour ce quiz.</p>
            @endforelse

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                    Soumettre le quiz
                </button>
                <a href="{{ route('mes-formations') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                    Annuler
                </a>
            </div>
        </form>
    </div>
@endsection