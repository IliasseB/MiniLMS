@extends('layouts.app')

@section('title', 'Formations')

@section('content')

    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Catalogue de Formations</h1>
            <p class="text-gray-400 mt-1">Gérez vos programmes éducatifs et suivez leur performance globale.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('generation-ia.index') }}" class="flex items-center gap-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl hover:bg-indigo-200 transition text-sm font-medium">
                ✨ Générer avec l'IA
            </a>
            <a href="{{ route('formations.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
                + Nouvelle formation
            </a>
        </div>
    </div>

    <!-- Cartes stats -->
    @php
        $totalHeures = \App\Models\Formation::sum('duree');
        $totalApprenants = \App\Models\Apprenant::count();
        $moyenneApprenants = \App\Models\Formation::count() > 0
            ? round(\App\Models\Apprenant::count() / \App\Models\Formation::count(), 1)
            : 0;
    @endphp
    <div class="grid grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Formations</p>
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900">{{ \App\Models\Formation::count() }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Heures de contenu</p>
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900">{{ $totalHeures }}<span class="text-lg text-gray-400 font-normal"> h</span></p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Apprenants actifs</p>
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900">{{ $totalApprenants }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-start justify-between mb-4">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Apprenants par Formation</p>
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-900">{{ $moyenneApprenants }}<span class="text-lg text-gray-400 font-normal"> moy.</span></p>
        </div>
    </div>

    <!-- Liste des formations -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-base font-bold text-gray-800">Liste des formations</h2>
            <div class="relative">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input id="search-formation" type="text" placeholder="Rechercher..."
                    autocomplete="off"
                    class="pl-9 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
        </div>

        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Formation</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Niveau</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Durée</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Apprenants</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody id="formations-body">
                @forelse($formations as $formation)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition formation-row"
                        data-nom="{{ mb_strtolower($formation->nom) }}">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $formation->nom }}</p>
                                    @if($formation->description)
                                        <p class="text-gray-400 text-xs">{{ Str::limit($formation->description, 40) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md">{{ $formation->niveau }}</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-500">{{ $formation->duree ?? '-' }}h</td>
                        <td class="px-6 py-5 text-sm text-gray-500">{{ $formation->apprenants->count() }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('formations.show', $formation) }}" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('formations.edit', $formation) }}" class="text-indigo-500 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('formations.destroy', $formation) }}" onsubmit="return confirm('Supprimer cette formation ?')">
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucune formation trouvée.</td>
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
                `Affichage ${Math.min(debut + 1, rowsFiltrees.length)}-${Math.min(fin, rowsFiltrees.length)} sur ${rowsFiltrees.length} formation(s)`;

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
            const query = normaliser(document.getElementById('search-formation').value.trim());
            const toutesLesRows = Array.from(document.querySelectorAll('.formation-row'));

            toutesLesRows.forEach(row => row.style.display = 'none');

            rowsFiltrees = toutesLesRows.filter(row => {
                const nom = normaliser(row.getAttribute('data-nom') || '');
                return query === '' || nom.includes(query);
            });

            afficherPage(1);
        }

        document.getElementById('search-formation').addEventListener('input', filtrer);
        filtrer();
    </script>

@endsection