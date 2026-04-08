@extends('layouts.app')

@section('title', 'Nouvelle note')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nouvelle note</h1>

        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
            <form method="POST" action="{{ route('notes.store') }}">
                @csrf

                <!-- Matière -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Matière</label>
                    <input type="text" name="matiere" value="{{ old('matiere') }}"
                        placeholder="Ex: Anglais - Verbes irréguliers"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('matiere')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Note -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Note (sur 20)</label>
                    <input type="number" name="note" value="{{ old('note') }}"
                        min="0" max="20" step="0.25"
                        placeholder="Ex: 12.25, 14.75, 16.50"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <p class="text-xs text-gray-400 mt-1">Valeurs acceptées : 0 à 20 avec décimales (ex: 12.25, 14.75)</p>
                    @error('note')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Apprenant avec recherche intégrée -->
                <div class="mb-8">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Apprenant</label>
                    
                    <div class="relative" id="combobox-container">
                        <!-- Input visible -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input id="search-apprenant" type="text"
                                placeholder="Rechercher ou sélectionner un apprenant..."
                                autocomplete="off"
                                class="w-full pl-9 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white">
                        </div>

                        <!-- Liste déroulante -->
                        <div id="dropdown-list" class="absolute z-10 w-full bg-white border border-gray-200 rounded-xl shadow-lg mt-1 hidden overflow-hidden">
                            @foreach($apprenants as $apprenant)
                                <div class="apprenant-option px-4 py-3 hover:bg-indigo-50 cursor-pointer text-sm text-gray-700 transition border-b border-gray-50"
                                    data-id="{{ $apprenant->id }}"
                                    data-nom="{{ $apprenant->nom }}">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($apprenant->nom, 0, 2)) }}
                                        </div>
                                        {{ $apprenant->nom }}
                                    </div>
                                </div>
                            @endforeach
                            <div id="no-result" class="px-4 py-3 text-sm text-gray-400 hidden">Aucun apprenant trouvé.</div>
                        </div>

                        <!-- Input caché pour le formulaire -->
                        <input type="hidden" name="apprenant_id" id="apprenant-id" value="{{ old('apprenant_id') }}">
                    </div>

                    @error('apprenant_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    const searchInput = document.getElementById('search-apprenant');
                    const dropdown = document.getElementById('dropdown-list');
                    const hiddenInput = document.getElementById('apprenant-id');
                    const options = document.querySelectorAll('.apprenant-option');
                    const noResult = document.getElementById('no-result');

                    // Ouvre le dropdown au focus
                    searchInput.addEventListener('focus', function() {
                        dropdown.classList.remove('hidden');
                    });

                    // Ferme si clic en dehors
                    document.addEventListener('click', function(e) {
                        if (!document.getElementById('combobox-container').contains(e.target)) {
                            dropdown.classList.add('hidden');
                        }
                    });

                    // Filtre les options
                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase();
                        let count = 0;

                        options.forEach(function(option) {
                            const nom = option.dataset.nom.toLowerCase();
                            if (nom.includes(query)) {
                                option.style.display = '';
                                count++;
                            } else {
                                option.style.display = 'none';
                            }
                        });

                        noResult.style.display = count === 0 ? '' : 'none';
                        dropdown.classList.remove('hidden');

                        // Reset la sélection si l'utilisateur retape
                        hiddenInput.value = '';
                    });

                    // Sélectionne un apprenant
                    options.forEach(function(option) {
                        option.addEventListener('click', function() {
                            searchInput.value = this.dataset.nom;
                            hiddenInput.value = this.dataset.id;
                            dropdown.classList.add('hidden');
                        });
                    });
                </script>
                <!-- Boutons -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                        Ajouter
                    </button>
                    <a href="{{ route('notes.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                        Annuler
                    </a>
                </div>

@endsection