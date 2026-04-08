@extends('layouts.app')

@section('title', 'Nouveau quiz')

@section('content')

    <!-- Fil d'ariane -->
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('quiz.index') }}" class="hover:text-indigo-600">Gestion des Quiz</a>
        <span>›</span>
        <span class="text-indigo-600 font-medium">Nouveau Quiz</span>
    </div>

    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Création de Quiz</h1>
        <p class="text-gray-400 mt-1">Concevez une évaluation pédagogique engageante. Définissez vos questions, proposez des options et structurez l'apprentissage de vos apprenants.</p>
    </div>

    <form method="POST" action="{{ route('quiz.store') }}" id="quiz-form">
        @csrf

        <!-- Carte titre + cascade -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">
            <div class="flex flex-col gap-6">

                <!-- Titre -->
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Titre du quiz</label>
                    <input type="text" name="titre" value="{{ old('titre') }}"
                        placeholder="Ex: Initialisation au développement web"
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @error('titre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cascade formation → chapitre → sous-chapitre -->
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Formation</label>
                        <select id="formation-select" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 appearance-none bg-white">
                            <option value="">Sélectionner une formation</option>
                            @foreach(\App\Models\Formation::all() as $formation)
                                <option value="{{ $formation->id }}">{{ $formation->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Chapitre</label>
                        <select id="chapitre-select" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 appearance-none bg-white">
                            <option value="">Sélectionner d'abord une formation</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Sous-chapitre associé</label>
                        <select id="sous-chapitre-select" name="sous_chapitre_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 appearance-none bg-white">
                            <option value="">Sélectionner d'abord un chapitre</option>
                        </select>
                        @error('sous_chapitre_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Section questions -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Questions</h2>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="ajouterQuestion()"
                        class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center hover:bg-indigo-700 transition font-bold" style="line-height:1; padding:0;">
                        +
                    </button>
                    <span id="questions-count" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">0 QUESTION</span>
                </div>
            </div>

            <!-- Conteneur des questions -->
            <div id="questions-container" class="flex flex-col gap-4"></div>

            <!-- Message si pas de question -->
            <div id="no-questions" class="bg-white rounded-2xl border border-dashed border-gray-200 p-8 text-center text-gray-400 text-sm">
                Cliquez sur "+" pour ajouter une première question
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex items-center justify-between">
            <a href="{{ route('quiz.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm">
                Annuler
            </a>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 transition font-medium text-sm">
                Enregistrer le Quiz
            </button>
        </div>
    </form>

    <script>
        // Données formations → chapitres → sous-chapitres
        const data = {
            @foreach(\App\Models\Formation::with('chapitres.souschapitres')->get() as $formation)
                {{ $formation->id }}: {
                    @foreach($formation->chapitres as $chapitre)
                        {{ $chapitre->id }}: {
                            titre: "{{ addslashes($chapitre->titre) }}",
                            souschapitres: [
                                @foreach($chapitre->souschapitres as $sc)
                                    { id: {{ $sc->id }}, titre: "{{ addslashes($sc->titre) }}" },
                                @endforeach
                            ]
                        },
                    @endforeach
                },
            @endforeach
        };

        // Formation → Chapitre
        document.getElementById('formation-select').addEventListener('change', function() {
            const formationId = this.value;
            const chapitreSelect = document.getElementById('chapitre-select');
            const scSelect = document.getElementById('sous-chapitre-select');

            chapitreSelect.innerHTML = '<option value="">Sélectionner un chapitre</option>';
            scSelect.innerHTML = '<option value="">Sélectionner d\'abord un chapitre</option>';

            if (formationId && data[formationId]) {
                Object.entries(data[formationId]).forEach(([id, chapitre]) => {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = chapitre.titre;
                    chapitreSelect.appendChild(option);
                });
            }
        });

        // Chapitre → Sous-chapitre
        document.getElementById('chapitre-select').addEventListener('change', function() {
            const formationId = document.getElementById('formation-select').value;
            const chapitreId = this.value;
            const scSelect = document.getElementById('sous-chapitre-select');

            scSelect.innerHTML = '<option value="">Sélectionner un sous-chapitre</option>';

            if (formationId && chapitreId && data[formationId] && data[formationId][chapitreId]) {
                data[formationId][chapitreId].souschapitres.forEach(function(sc) {
                    const option = document.createElement('option');
                    option.value = sc.id;
                    option.textContent = sc.titre;
                    scSelect.appendChild(option);
                });
            }
        });

        let questionIndex = 0;

        function ajouterQuestion() {
            questionIndex++;
            document.getElementById('no-questions').style.display = 'none';

            const container = document.getElementById('questions-container');
            const numero = container.children.length + 1;
            const div = document.createElement('div');
            div.className = 'bg-white rounded-2xl border border-gray-100 shadow-sm p-6';
            div.id = `question-${questionIndex}`;
            div.innerHTML = `
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm flex-shrink-0">${numero}</div>
                        <span class="font-semibold text-gray-700">Question ${numero}</span>
                    </div>
                    <button type="button" onclick="supprimerQuestion(${questionIndex})" class="text-red-400 hover:text-red-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>

                <textarea name="questions[${questionIndex}][question]" rows="3"
                    placeholder="Saisissez l'intitulé de votre question ici..."
                    class="w-full border border-gray-100 bg-gray-50 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 mb-4 resize-none"></textarea>

                <div class="grid grid-cols-2 gap-3">
                    ${['A', 'B', 'C', 'D'].map((lettre, i) => `
                        <div class="flex items-center gap-2 border border-gray-200 rounded-xl px-3 py-2">
                            <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0"></div>
                            <input type="text" name="questions[${questionIndex}][reponses][${i}][texte]"
                                placeholder="Entrez la réponse ${lettre}"
                                class="flex-1 text-sm text-gray-700 focus:outline-none bg-transparent min-w-0">
                            <button type="button" onclick="setReponse(this, false)"
                                class="reponse-btn w-6 h-6 rounded-full flex items-center justify-center text-gray-300 hover:text-red-500 hover:bg-red-50 transition flex-shrink-0"
                                title="Mauvaise réponse">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <button type="button" onclick="setReponse(this, true)"
                                class="reponse-btn w-6 h-6 rounded-full flex items-center justify-center text-gray-300 hover:text-green-500 hover:bg-green-50 transition flex-shrink-0"
                                title="Bonne réponse">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                            <input type="hidden" name="questions[${questionIndex}][reponses][${i}][est_correcte]" value="0">
                        </div>
                    `).join('')}
                </div>
                <p class="text-xs text-gray-400 mt-2">⚠️ Au moins une bonne réponse et une mauvaise réponse sont requises.</p>
            `;

            container.appendChild(div);
            updateCount();
        }

        function supprimerQuestion(id) {
            document.getElementById(`question-${id}`).remove();
            updateCount();
            if (document.getElementById('questions-container').children.length === 0) {
                document.getElementById('no-questions').style.display = 'block';
            }
            Array.from(document.getElementById('questions-container').children).forEach((el, index) => {
                el.querySelector('.w-8.h-8').textContent = index + 1;
                el.querySelector('.font-semibold').textContent = `Question ${index + 1}`;
            });
        }

        function setReponse(btn, isCorrect) {
            const parent = btn.closest('.flex.items-center.gap-2');
            const btns = parent.querySelectorAll('.reponse-btn');
            const hidden = parent.querySelector('input[type="hidden"]');

            btns.forEach(b => {
                b.classList.remove('text-red-500', 'bg-red-50', 'text-green-500', 'bg-green-50');
                b.classList.add('text-gray-300');
            });

            if (isCorrect) {
                btn.classList.remove('text-gray-300');
                btn.classList.add('text-green-500', 'bg-green-50');
                hidden.value = '1';
            } else {
                btn.classList.remove('text-gray-300');
                btn.classList.add('text-red-500', 'bg-red-50');
                hidden.value = '0';
            }
        }

        function updateCount() {
            const total = document.getElementById('questions-container').children.length;
            document.getElementById('questions-count').textContent = total + ' QUESTION' + (total > 1 ? 'S' : '');
        }
    </script>

@endsection