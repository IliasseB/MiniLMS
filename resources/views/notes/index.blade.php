@extends('layouts.app')

@section('title', 'Notes')

@section('content')

    <!-- En-tête -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Notes</h1>
            <p class="text-gray-400 mt-1">Visualisez et gérez les performances académiques de tous les étudiants.</p>
        </div>
        <a href="{{ route('notes.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
            + Ajouter une note
        </a>
    </div>

    @php
        $moyenneGenerale = \App\Models\Note::avg('note');
        $totalNotes = \App\Models\Note::count();
        $insuffisant = \App\Models\Note::where('note', '<', 10)->count();
        $moyen = \App\Models\Note::whereBetween('note', [10, 13.99])->count();
        $bien = \App\Models\Note::whereBetween('note', [14, 16.99])->count();
        $excellent = \App\Models\Note::where('note', '>=', 17)->count();
        $maxCount = max($insuffisant, $moyen, $bien, $excellent, 1);
    @endphp

    <div class="grid grid-cols-3 gap-4 mb-8">

        <div class="bg-indigo-600 rounded-2xl shadow-sm p-8">
            <p class="text-xs font-bold text-white uppercase tracking-wide mb-3" style="opacity:0.7">Moyenne Générale</p>
            <p class="text-6xl font-bold text-white">{{ $moyenneGenerale ? round($moyenneGenerale, 1) : '-' }}<span class="text-2xl text-white font-normal" style="opacity:0.7">/20</span></p>
            <p class="text-xs text-white mt-3 flex items-center gap-1" style="opacity:0.7">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                {{ $totalNotes }} notes saisies
            </p>
        </div>

        <div class="col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-6">Répartition des notes</p>
            <div class="flex items-end gap-6">
                <div class="flex flex-col items-center gap-1 flex-1">
                    <div class="w-full bg-gray-100 rounded-lg" style="height: {{ $maxCount > 0 ? round(($insuffisant / $maxCount) * 80) : 0 }}px; min-height: 4px;"></div>
                    <span class="text-xs font-bold text-gray-400 uppercase mt-2">Insuffisant</span>
                    <span class="text-sm font-bold text-gray-600">{{ $insuffisant }}</span>
                    <span class="text-xs text-gray-300">0 - 9.99</span>
                </div>
                <div class="flex flex-col items-center gap-1 flex-1">
                    <div class="w-full bg-indigo-200 rounded-lg" style="height: {{ $maxCount > 0 ? round(($moyen / $maxCount) * 80) : 0 }}px; min-height: 4px;"></div>
                    <span class="text-xs font-bold text-gray-400 uppercase mt-2">Moyen</span>
                    <span class="text-sm font-bold text-gray-600">{{ $moyen }}</span>
                    <span class="text-xs text-gray-300">10 - 13.99</span>
                </div>
                <div class="flex flex-col items-center gap-1 flex-1">
                    <div class="w-full bg-indigo-500 rounded-lg" style="height: {{ $maxCount > 0 ? round(($bien / $maxCount) * 80) : 0 }}px; min-height: 4px;"></div>
                    <span class="text-xs font-bold text-gray-400 uppercase mt-2">Bien</span>
                    <span class="text-sm font-bold text-gray-600">{{ $bien }}</span>
                    <span class="text-xs text-gray-300">14 - 16.99</span>
                </div>
                <div class="flex flex-col items-center gap-1 flex-1">
                    <div class="w-full bg-indigo-600 rounded-lg" style="height: {{ $maxCount > 0 ? round(($excellent / $maxCount) * 80) : 0 }}px; min-height: 4px;"></div>
                    <span class="text-xs font-bold text-gray-400 uppercase mt-2">Excellent</span>
                    <span class="text-sm font-bold text-gray-600">{{ $excellent }}</span>
                    <span class="text-xs text-gray-300">17 - 20</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtre -->
    <div class="flex items-center justify-between mb-4">
        <div class="relative">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input id="search-note" type="text" placeholder="Rechercher un apprenant..."
                autocomplete="off"
                class="pl-9 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <p class="text-xs text-gray-400">{{ $totalNotes }} notes au total</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Étudiant</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Module / Matière</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Note</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody id="notes-body">
                @forelse($notes as $note)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition note-row"
                        data-nom="{{ mb_strtolower($note->apprenant->nom) }}">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($note->apprenant->nom, 0, 2)) }}
                                </div>
                                <span class="font-semibold text-gray-800">{{ $note->apprenant->nom }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-gray-600 text-sm">{{ $note->matiere }}</td>
                        <td class="px-6 py-5">
                            @php
                                $couleurNote = $note->note >= 16 ? 'text-green-600' : ($note->note >= 10 ? 'text-indigo-600' : 'text-orange-500');
                            @endphp
                            <span class="font-bold text-lg {{ $couleurNote }}">{{ $note->note }}/20</span>
                        </td>
                        <td class="px-6 py-5">
                            @if($note->note >= 16)
                                <span class="text-xs font-bold text-green-700 bg-green-50 px-3 py-1 rounded-full">Excellent</span>
                            @elseif($note->note >= 14)
                                <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full">Bien</span>
                            @elseif($note->note >= 10)
                                <span class="text-xs font-bold text-blue-700 bg-blue-50 px-3 py-1 rounded-full">Validé</span>
                            @else
                                <span class="text-xs font-bold text-orange-700 bg-orange-50 px-3 py-1 rounded-full">Rattrapage</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('notes.edit', $note) }}" class="text-indigo-500 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Supprimer cette note ?')">
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucune note trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

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
            return str.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
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
                `Affichage ${Math.min(debut + 1, rowsFiltrees.length)}-${Math.min(fin, rowsFiltrees.length)} sur ${rowsFiltrees.length} note(s)`;

            const paginationEl = document.getElementById('pagination');
            paginationEl.innerHTML = '';

            paginationEl.appendChild(creerBtn('‹', pageCourante - 1, false, pageCourante === 1));

            let pages = [];
            if (totalPages <= 5) {
                for (let i = 1; i <= totalPages; i++) pages.push(i);
            } else {
                pages.push(1);
                if (pageCourante > 3) pages.push('...');
                for (let i = Math.max(2, pageCourante - 1); i <= Math.min(totalPages - 1, pageCourante + 1); i++) pages.push(i);
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
            const query = normaliser(document.getElementById('search-note').value.trim());
            const toutesLesRows = Array.from(document.querySelectorAll('.note-row'));
            toutesLesRows.forEach(row => row.style.display = 'none');
            rowsFiltrees = toutesLesRows.filter(row => {
                const nom = normaliser(row.getAttribute('data-nom') || '');
                return query === '' || nom.includes(query);
            });
            afficherPage(1);
        }

        document.getElementById('search-note').addEventListener('input', filtrer);
        filtrer();
    </script>

@endsection