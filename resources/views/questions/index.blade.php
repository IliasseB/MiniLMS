@extends('layouts.app')

@section('title', 'Questions')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Questions</h1>
        <a href="{{ route('questions.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Nouvelle question
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Question</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Réponses</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($questions as $question)
                    <tr>
                        <td class="px-6 py-4 text-gray-800">{{ $question->question }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $question->quiz->titre }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $question->reponses->count() }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('questions.edit', $question) }}" class="text-yellow-600 hover:underline">Modifier</a>
                            <form method="POST" action="{{ route('questions.destroy', $question) }}" onsubmit="return confirm('Supprimer cette question ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucune question trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection