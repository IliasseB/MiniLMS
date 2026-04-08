@extends('layouts.app')

@section('title', 'Résultats quiz')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Résultats quiz</h1>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apprenant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($resultats as $resultat)
                    <tr>
                        <td class="px-6 py-4 text-gray-800">{{ $resultat->apprenant->nom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $resultat->quiz->titre }}</td>
                        <td class="px-6 py-4 font-medium text-indigo-600">
                            {{ $resultat->score }}/{{ $resultat->quiz->questions->count() }}
                        </td>
                        <td class="px-6 py-4">
                            <form method="POST" action="{{ route('resultats.destroy', $resultat) }}" onsubmit="return confirm('Supprimer ce résultat ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucun résultat trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection