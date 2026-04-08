@extends('layouts.app')

@section('title', 'Modifier la réponse')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier la réponse</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('reponses.update', $reponse) }}">
                @csrf
                @method('PUT')

                <!-- Texte -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Texte de la réponse</label>
                    <input type="text" name="texte" value="{{ old('texte', $reponse->texte) }}"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('texte')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Est correcte -->
                <div class="mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="est_correcte" value="1" {{ old('est_correcte', $reponse->est_correcte) ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600">
                        <span class="text-gray-700 font-medium">C'est la bonne réponse</span>
                    </label>
                </div>

                <!-- Question -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Question</label>
                    <select name="question_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">-- Choisir une question --</option>
                        @foreach($questions as $question)
                            <option value="{{ $question->id }}" {{ old('question_id', $reponse->question_id) == $question->id ? 'selected' : '' }}>
                                {{ $question->question }}
                            </option>
                        @endforeach
                    </select>
                    @error('question_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Mettre à jour
                    </button>
                    <a href="{{ route('reponses.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection