@extends('layouts.app')

@section('title', 'Sous-chapitres')

@section('content')

    <!-- En-tête -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Sous-chapitres</h1>
            <p class="text-gray-400 mt-1">Gérez le contenu détaillé de vos modules d'apprentissage.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('contenus-ia.create') }}" class="flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition text-sm font-medium">
                ↑ Importer du contenu
            </a>
            <a href="{{ route('sous-chapitres.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-3 rounded-xl hover:bg-indigo-700 transition font-medium text-sm">
                + Nouveau sous-chapitre
            </a>
        </div>
    </div>

    <!-- Tableau -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Titre</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Formation</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Chapitre</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($souschapitres as $index => $sousChapitre)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <!-- Titre avec ID -->
                        <td class="px-6 py-5">
                            <p class="font-semibold text-gray-800">{{ $sousChapitre->titre }}</p>
                        </td>
                        <!-- Formation -->
                        <td class="px-6 py-5 text-gray-600 text-sm">
                            {{ $sousChapitre->chapitre->formation->nom }}
                        </td>
                        <!-- Chapitre avec badge -->
                        <td class="px-6 py-5">
                            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-lg">
                                {{ $sousChapitre->chapitre->titre }}
                            </span>
                        </td>
                        <!-- Actions -->
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('sous-chapitres.show', $sousChapitre) }}" class="text-indigo-400 hover:text-indigo-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('sous-chapitres.edit', $sousChapitre) }}" class="text-yellow-400 hover:text-yellow-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('sous-chapitres.destroy', $sousChapitre) }}" onsubmit="return confirm('Supprimer ce sous-chapitre ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Aucun sous-chapitre trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pied de tableau -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400">
                Affichage de 1 à {{ $souschapitres->count() }} sur {{ $souschapitres->count() }} sous-chapitres
            </p>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 text-gray-400 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

@endsection