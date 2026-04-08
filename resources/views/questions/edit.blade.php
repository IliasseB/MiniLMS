@extends('layouts.app')

@section('title', 'Modifier la question')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier la question</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('questions.update', $question) }}">
                @csrf
                @method('PUT')

                <!-- Question -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Question</label>
                    <textarea name="question" rows="3"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('question', $question->question) }}</textarea>
                    @error('question')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quiz -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Quiz</label>
                    <select name="quiz_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">-- Choisir un quiz --</option>
                        @foreach($quizzes as $quiz)
                            <option value="{{ $quiz->id }}" {{ old('quiz_id', $question->quiz_id) == $quiz->id ? 'selected' : '' }}>
                                {{ $quiz->titre }}
                            </option>
                        @endforeach
                    </select>
                    @error('quiz_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                    <a href="{{ route('questions.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection