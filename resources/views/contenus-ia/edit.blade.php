@extends('layouts.app')

@section('title', 'Modifier le contenu')

@section('content')

    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Modifier le contenu</h1>
        <p class="text-gray-400 mt-1">Modifiez les informations du contenu importé.</p>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <!-- Formulaire (2/3) -->
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <form method="POST" action="{{ route('contenus-ia.update', $contenuIa) }}">
                    @csrf
                    @method('PUT')

                    <!-- Titre -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Titre du contenu</label>
                        <input type="text" name="titre" value="{{ old('titre', $contenuIa->titre) }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('titre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Source -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Source du contenu</label>
                        <div class="relative">
                            <input type="text" name="source" value="{{ old('source', $contenuIa->source) }}"
                                placeholder="Ex: ChatGPT, Claude, Wikipédia..."
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 pr-10">
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </div>
                        </div>
                        @error('source')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sous-chapitre -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Sous-chapitre</label>
                        <select name="sous_chapitre_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 appearance-none bg-white">
                            <option value="">-- Choisir un sous-chapitre --</option>
                            @foreach($souschapitres as $sousChapitre)
                                <option value="{{ $sousChapitre->id }}" {{ old('sous_chapitre_id', $contenuIa->sous_chapitre_id) == $sousChapitre->id ? 'selected' : '' }}>
                                    {{ $sousChapitre->titre }}
                                </option>
                            @endforeach
                        </select>
                        @error('sous_chapitre_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contenu -->
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Contenu</label>
                        <textarea name="contenu" rows="12"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-indigo-50 resize-y">{{ old('contenu', $contenuIa->contenu) }}</textarea>
                        @error('contenu')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center justify-center gap-4">
                        <a href="{{ route('contenus-ia.show', $contenuIa) }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                            Annuler
                        </a>
                        <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar droite (1/3) -->
        <div class="flex flex-col gap-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Informations</p>
                <div class="flex flex-col gap-3">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Sous-chapitre actuel</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $contenuIa->sousChapitre->titre }}</p>
                    </div>
                    <div class="border-t border-gray-50 pt-3">
                        <p class="text-xs text-gray-400 mb-1">Créé le</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $contenuIa->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="border-t border-gray-50 pt-3">
                        <p class="text-xs text-gray-400 mb-1">Dernière modification</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $contenuIa->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Supprimer -->
            <form method="POST" action="{{ route('contenus-ia.destroy', $contenuIa) }}" onsubmit="return confirm('Supprimer ce contenu ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-50 text-red-500 px-4 py-3 rounded-xl hover:bg-red-100 transition text-sm font-medium">
                    Supprimer ce contenu
                </button>
            </form>
        </div>
    </div>

@endsection