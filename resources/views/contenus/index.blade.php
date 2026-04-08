@extends('layouts.app')

@section('title', 'Contenus')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Contenus</h1>
        <a href="{{ route('contenus.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Nouveau contenu
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sous-chapitre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contenus as $contenu)
                    <tr>
                        <td class="px-6 py-4 text-gray-800">{{ $contenu->titre }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $contenu->sousChapitre->titre }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('contenus.show', $contenu) }}" class="text-blue-600 hover:underline">Voir</a>
                            <a href="{{ route('contenus.edit', $contenu) }}" class="text-yellow-600 hover:underline">Modifier</a>
                            <form method="POST" action="{{ route('contenus.destroy', $contenu) }}" onsubmit="return confirm('Supprimer ce contenu ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun contenu trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection