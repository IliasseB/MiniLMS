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
            <a href="{{ route('generation-ia.index') }}" class="flex items-center gap-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl hover:bg-indigo-200 transition text-sm font-medium">
                ✨ Générer avec l'IA
            </a>
            <a href="{{ route('contenus-ia.create') }}" class="flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition text-sm font-medium">
                ↑ Importer du contenu
            </a>
            <a href="{{ route('sous-chapitres.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-3 rounded-xl hover:bg-indigo-700 transition font-medium text-sm">
                + Nouveau sous-chapitre
            </a>
        </div>
    </div>

    <!-- Filtre -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-gray-800">Liste des Sous-chapitres</h2>

        <div class="relative">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input id="search-sc" type="text" placeholder="Filtrer par titre, formation ou chapitre..."
                autocomplete="off"
                class="pl-9 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 w-96">
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
            <tbody id="sc-body">
                @forelse($souschapitres as $index => $sousChapitre)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition sc-row"
                        data-titre="{{ mb_strtolower($sousChapitre->titre) }}"
                        data-formation="{{ mb_strtolower($sousChapitre->chapitre->formation->nom) }}"
                        data-chapitre="{{ mb_strtolower($sousChapitre->chapitre->titre) }}">
                        <td class="px-6 py-5">
                            <p class="font-semibold text-gray-800">{{ $sousChapitre->titre }}</p>
                        </td>
                        <td class="px-6 py-5 text-gray-600 text-sm">
                            {{ $sousChapitre->chapitre->formation->nom }}
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-lg">
                                {{ $sousChapitre->chapitre->titre }}
                            </span>
                        </td>
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
            <p class="text-xs text-gray-400" id="compteur"></p>
            <div class="flex items-center gap-2" id="pagination"></div>
        </div>
    </div>

    <script>
        const ITEMS_PAR_PAGE = 8;
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
                `Affichage ${Math.min(debut + 1, rowsFiltrees.length)}-${Math.min(fin, rowsFiltrees.length)} sur ${rowsFiltrees.length} sous-chapitre(s)`;

            const paginationEl = document.getElementById('pagination');
            paginationEl.innerHTML = '';

            paginationEl.appendChild(creerBtn('‹', pageCourante - 1, false, pageCourante === 1));

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

            paginationEl.appendChild(creerBtn('›', pageCourante + 1, false, pageCourante === totalPages));
        }

        function filtrer() {
            const query = normaliser(document.getElementById('search-sc').value.trim());
            const toutesLesRows = Array.from(document.querySelectorAll('.sc-row'));

            toutesLesRows.forEach(row => row.style.display = 'none');

            rowsFiltrees = toutesLesRows.filter(row => {
                const titre = normaliser(row.getAttribute('data-titre') || '');
                const formation = normaliser(row.getAttribute('data-formation') || '');
                const chapitre = normaliser(row.getAttribute('data-chapitre') || '');
                return query === '' || titre.includes(query) || formation.includes(query) || chapitre.includes(query);
            });

            afficherPage(1);
        }

        document.getElementById('search-sc').addEventListener('input', filtrer);
        filtrer();
    </script>

@endsection