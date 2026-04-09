@extends('layouts.app')

@section('title', 'Chapitres')

@section('content')

    <!-- En-tête -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Chapitres</h1>
            <p class="text-gray-400 mt-1">Organisez et structurez le contenu pédagogique de vos cursus.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('generation-ia.index') }}" class="flex items-center gap-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl hover:bg-indigo-200 transition text-sm font-medium">
                ✨ Générer avec l'IA
            </a>
            <a href="{{ route('chapitres.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-3 rounded-xl hover:bg-indigo-700 transition font-medium text-sm">
                + Nouveau chapitre
            </a>
        </div>
    </div>

    <!-- Cartes stats -->
    @php
        $totalChapitres = \App\Models\Chapitre::count();
        $totalFormations = \App\Models\Formation::count();
        $totalSousChapitres = \App\Models\SousChapitre::count();
    @endphp
    <div class="grid grid-cols-3 gap-4 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Total Chapitres</p>
                <p class="text-5xl font-bold text-gray-900">{{ $totalChapitres }}</p>
            </div>
            <div class="w-24 h-24 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Total Formations</p>
                <p class="text-5xl font-bold text-gray-900">{{ $totalFormations }}</p>
            </div>
            <div class="w-24 h-24 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Total Sous-chapitres</p>
                <p class="text-5xl font-bold text-gray-900">{{ $totalSousChapitres }}</p>
            </div>
            <div class="w-24 h-24 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Liste des chapitres -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-gray-800">Liste des Chapitres</h2>

        <div class="relative">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input id="search-chapitre" type="text" placeholder="Filtrer par titre ou formation..."
                autocomplete="off"
                class="pl-9 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 w-80">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Titre du chapitre</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Formation associée</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Sous-chapitres</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody id="chapitres-body">
                @forelse($chapitres as $index => $chapitre)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition chapitre-row"
                        data-titre="{{ mb_strtolower($chapitre->titre) }}"
                        data-formation="{{ mb_strtolower($chapitre->formation->nom) }}"
                        data-souschapitres="{{ $chapitre->souschapitres->count() }}"
                        data-numero="{{ $index + 1 }}">
                        <td class="px-6 py-5">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}. {{ $chapitre->titre }}
                                </p>
                                @if($chapitre->description)
                                    <p class="text-xs text-gray-400 mt-1">{{ Str::limit($chapitre->description, 50) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <a href="{{ route('formations.show', $chapitre->formation) }}" class="text-indigo-600 hover:underline text-sm font-medium">
                                {{ $chapitre->formation->nom }}
                            </a>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-500">
                            {{ $chapitre->souschapitres->count() }} sous-chapitre(s)
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('chapitres.show', $chapitre) }}" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('chapitres.edit', $chapitre) }}" class="text-indigo-500 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('chapitres.destroy', $chapitre) }}" onsubmit="return confirm('Supprimer ce chapitre ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Aucun chapitre trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pied de tableau -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400 uppercase tracking-wide" id="compteur"></p>
            <div class="flex items-center gap-2" id="pagination"></div>
        </div>
    </div>

    <script>
        const ITEMS_PAR_PAGE = 4;
        let pageCourante = 1;
        let rowsFiltrees = [];

        function normaliser(str) {
            return str.toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "");
        }

        function creerBtn(texte, cible, actif = false, disabled = false) {
            const btn = document.createElement('button');
            btn.textContent = texte;
            btn.disabled = disabled;
            btn.className = `w-8 h-8 flex items-center justify-center rounded-lg border text-xs font-bold transition ${
                actif ? 'bg-indigo-600 text-white border-indigo-600'
                : disabled ? 'border-gray-100 text-gray-300 cursor-not-allowed'
                : 'border-gray-200 text-gray-500 hover:bg-gray-50'
            }`;
            if (!disabled) btn.addEventListener('click', () => afficherPage(cible));
            return btn;
        }

        function afficherPage(page) {
            pageCourante = page;
            const debut = (page - 1) * ITEMS_PAR_PAGE;
            const fin = debut + ITEMS_PAR_PAGE;

            rowsFiltrees.forEach((row, index) => {
                row.style.display = (index >= debut && index < fin) ? '' : 'none';
            });

            const totalPages = Math.ceil(rowsFiltrees.length / ITEMS_PAR_PAGE);
            document.getElementById('compteur').textContent =
                `Affichage ${Math.min(debut + 1, rowsFiltrees.length)}-${Math.min(fin, rowsFiltrees.length)} sur ${rowsFiltrees.length} chapitre(s)`;

            const paginationEl = document.getElementById('pagination');
            paginationEl.innerHTML = '';

            // Bouton précédent
            paginationEl.appendChild(creerBtn('‹', pageCourante - 1, false, pageCourante === 1));

            // Pages avec ellipsis
            let pages = [];
            if (totalPages <= 5) {
                for (let i = 1; i <= totalPages; i++) pages.push(i);
            } else {
                pages.push(1);
                if (pageCourante > 3) pages.push('...');
                for (let i = Math.max(2, pageCourante - 1); i <= Math.min(totalPages - 1, pageCourante + 1); i++) {
                    pages.push(i);
                }
                if (pageCourante < totalPages - 2) pages.push('...');
                pages.push(totalPages);
            }

            pages.forEach(p => {
                if (p === '...') {
                    const span = document.createElement('span');
                    span.textContent = '...';
                    span.className = 'w-8 h-8 flex items-center justify-center text-xs text-gray-400';
                    paginationEl.appendChild(span);
                } else {
                    paginationEl.appendChild(creerBtn(p, p, p === pageCourante));
                }
            });

            // Bouton suivant
            paginationEl.appendChild(creerBtn('›', pageCourante + 1, false, pageCourante === totalPages));
        }

        function filtrer() {
            const query = normaliser(document.getElementById('search-chapitre').value.trim());
            const toutesLesRows = Array.from(document.querySelectorAll('.chapitre-row'));

            toutesLesRows.forEach(row => row.style.display = 'none');

            rowsFiltrees = toutesLesRows.filter(row => {
                const titre = normaliser(row.getAttribute('data-titre') || '');
                const formation = normaliser(row.getAttribute('data-formation') || '');
                return query === '' || titre.includes(query) || formation.includes(query);
            });

            afficherPage(1);
        }

        document.getElementById('search-chapitre').addEventListener('input', filtrer);
        filtrer();
    </script>

@endsection