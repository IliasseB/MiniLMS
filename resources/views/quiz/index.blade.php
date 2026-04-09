@extends('layouts.app')

@section('title', 'Quiz')

@section('content')

    <!-- En-tête -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Quiz</h1>
            <p class="text-gray-400 mt-1">Créez et gérez les quiz associés aux formations.</p>
        </div>
        <a href="{{ route('quiz.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
            + Nouveau quiz
        </a>
    </div>

    @php
        $totalQuiz = \App\Models\Quiz::count();
        $totalQuestions = \App\Models\Question::count();
        $totalResultats = \App\Models\ResultatQuiz::count();
        $notesAuDessus12 = \App\Models\Note::where('note', '>=', 12)->count();
        $totalNotes = \App\Models\Note::count();
        $tauxReussite = $totalNotes > 0 ? round(($notesAuDessus12 / $totalNotes) * 100) : 0;
        $moyenneQuestions = $totalQuiz > 0 ? round($totalQuestions / $totalQuiz) : 0;
    @endphp

    <div class="grid grid-cols-3 gap-4 mb-8">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Total Quiz Actifs</p>
                <p class="text-6xl font-bold text-indigo-600">{{ $totalQuiz }}</p>
            </div>
            <div class="w-28 h-28 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-14 h-14 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Taux de réussite</p>
            <p class="text-6xl font-bold text-indigo-600">{{ $tauxReussite }}<span class="text-3xl text-gray-400 font-normal">%</span></p>
            <p class="text-xs text-gray-400 mt-3 flex items-center gap-1">
                <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                Notes ≥ 12/20
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-4">Questions</p>
            <p class="text-6xl font-bold text-gray-900">{{ $totalQuestions }}</p>
            <p class="text-xs text-gray-400 mt-3">{{ $moyenneQuestions }} moy./quiz</p>
        </div>
    </div>

    <!-- Filtre -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-gray-800">Liste des Quiz</h2>
        <div class="relative">
            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input id="search-quiz" type="text" placeholder="Rechercher un quiz..."
                autocomplete="off"
                class="pl-9 pr-4 py-2 bg-white border border-gray-100 rounded-xl text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 w-72">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Quiz</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Sous-chapitre</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Questions</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Passages</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody id="quiz-body">
                @forelse($quizzes as $quiz)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition quiz-row"
                        data-titre="{{ mb_strtolower($quiz->titre) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-800">{{ $quiz->titre }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md">
                                {{ $quiz->sousChapitre->titre }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $quiz->questions->count() }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \App\Models\ResultatQuiz::where('quiz_id', $quiz->id)->count() }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('quiz.show', $quiz) }}" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('quiz.edit', $quiz) }}" class="text-indigo-500 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('quiz.destroy', $quiz) }}" onsubmit="return confirm('Supprimer ce quiz ?')">
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun quiz trouvé.</td>
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
                `Affichage ${Math.min(debut + 1, rowsFiltrees.length)}-${Math.min(fin, rowsFiltrees.length)} sur ${rowsFiltrees.length} quiz`;

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
            const query = normaliser(document.getElementById('search-quiz').value.trim());
            const toutesLesRows = Array.from(document.querySelectorAll('.quiz-row'));
            toutesLesRows.forEach(row => row.style.display = 'none');
            rowsFiltrees = toutesLesRows.filter(row => {
                const titre = normaliser(row.getAttribute('data-titre') || '');
                return query === '' || titre.includes(query);
            });
            afficherPage(1);
        }

        document.getElementById('search-quiz').addEventListener('input', filtrer);
        filtrer();
    </script>

@endsection