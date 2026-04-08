@extends('layouts.app')

@section('title', 'Importer du contenu')

@section('content')

    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Importation de contenu</h1>
        <p class="text-gray-400 mt-1">Utilisez l'intelligence artificielle pour structurer et générer vos modules de formation à partir de sources brutes.</p>
    </div>

    <div class="grid grid-cols-3 gap-6">

        <!-- Formulaire (2/3) -->
        <div class="col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <form method="POST" action="{{ route('contenus-ia.store') }}">
                    @csrf

                    <!-- Titre -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Titre du contenu</label>
                        <input type="text" name="titre" value="{{ old('titre') }}"
                            placeholder="Ex: Les verbes irréguliers en anglais — Définition"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>

                    <!-- Source -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Source du contenu</label>
                        <div class="relative">
                            <input type="text" name="source" value="{{ old('source') }}"
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

                    <!-- Chapitre + Sous-chapitre en cascade -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Chapitre</label>
                            <select id="chapitre-select" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 appearance-none bg-white">
                                <option value="">Sélectionner un chapitre</option>
                                @foreach(\App\Models\Chapitre::with('souschapitres')->get() as $chapitre)
                                    <option value="{{ $chapitre->id }}">{{ $chapitre->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Sous-chapitre</label>
                            <select id="sous-chapitre-select" name="sous_chapitre_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 appearance-none bg-white">
                                <option value="">Sélectionner d'abord un chapitre</option>
                            </select>
                            @error('sous_chapitre_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Contenu à insérer</label>
                        <textarea name="contenu" rows="12"
                            placeholder="Le contenu apparaîtra ici après l'analyse de la source..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-indigo-50 resize-y">{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="flex items-center justify-center gap-4">
                        <a href="{{ route('sous-chapitres.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                            Annuler
                        </a>
                        <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Importer le contenu
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar droite (1/3) -->
        <div class="flex flex-col gap-6">

            <!-- Astuces d'importation -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Astuces d'importation</h3>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex gap-3">
                        <span class="text-xs font-bold text-indigo-600 flex-shrink-0">01.</span>
                        <p class="text-sm text-gray-500">Assurez-vous que la source est accessible publiquement et que les informations soient véridiques avant de confirmer l'importation.</p>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-xs font-bold text-indigo-600 flex-shrink-0">02.</span>
                        <p class="text-sm text-gray-500">Structurez votre texte avec des titres et des listes pour rendre la lecture plus agréable et faciliter la mémorisation.</p>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-xs font-bold text-indigo-600 flex-shrink-0">03.</span>
                        <p class="text-sm text-gray-500">Vérifiez que le texte inséré correspond bien au sous-chapitre sélectionné.</p>
                    </div>
                </div>
            </div>

            <!-- Importations récentes -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Importations récentes</p>
                <div class="flex flex-col gap-4">
                    @forelse(\App\Models\ContenuIa::latest()->take(3)->get() as $recent)
                        <a href="{{ route('contenus-ia.show', $recent) }}" class="flex items-center gap-3 hover:bg-gray-50 rounded-xl p-2 -mx-2 transition">
                            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">{{ Str::limit($recent->titre, 25) }}</p>
                                <p class="text-xs text-gray-400">{{ $recent->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg flex-shrink-0">Complété</span>
                        </a>
                    @empty
                        <p class="text-sm text-gray-400">Aucune importation récente.</p>
                    @endforelse
                </div>
                <a href="{{ route('sous-chapitres.index') }}" class="block text-center text-xs font-bold text-indigo-600 uppercase tracking-wide mt-4 hover:underline">
                    Voir tout l'historique
                </a>
            </div>
        </div>
    </div>

    <!-- Script cascade chapitre → sous-chapitre -->
    <script>
        const souschapitres = {
            @foreach(\App\Models\Chapitre::with('souschapitres')->get() as $chapitre)
                {{ $chapitre->id }}: [
                    @foreach($chapitre->souschapitres as $sc)
                        { id: {{ $sc->id }}, titre: "{{ addslashes($sc->titre) }}" },
                    @endforeach
                ],
            @endforeach
        };

        document.getElementById('chapitre-select').addEventListener('change', function() {
            const chapitreId = this.value;
            const select = document.getElementById('sous-chapitre-select');
            select.innerHTML = '<option value="">Sélectionner un sous-chapitre</option>';
            if (chapitreId && souschapitres[chapitreId]) {
                souschapitres[chapitreId].forEach(function(sc) {
                    const option = document.createElement('option');
                    option.value = sc.id;
                    option.textContent = sc.titre;
                    select.appendChild(option);
                });
            } else {
                select.innerHTML = '<option value="">Sélectionner d\'abord un chapitre</option>';
            }
        });
    </script>

@endsection