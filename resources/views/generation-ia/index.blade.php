@extends('layouts.app')

@section('title', 'Génération IA')

@section('content')
    <div class="max-w-3xl mx-auto">

        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Génération par IA</h1>
            <p class="text-gray-400 mt-1">Décrivez le cours que vous souhaitez générer et l'IA créera automatiquement la formation, les chapitres, les sous-chapitres et le quiz associé.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3 mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">

            <form method="POST" action="{{ route('generation-ia.generer') }}" id="form-generation">
                @csrf

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">
                        Votre demande
                    </label>
                    <textarea name="prompt" rows="6"
                        placeholder="Ex: Génère un cours destiné à un niveau Bac+3 sur l'histoire du marketing, structuré en quatre chapitres d'environ 300 mots chacun, suivi d'un quiz de dix questions permettant de vérifier la bonne compréhension du contenu."
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-y">{{ old('prompt') }}</textarea>
                    @error('prompt')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Exemples de prompts -->
                <div class="mb-6 p-4 bg-indigo-50 rounded-xl">
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wide mb-3">Exemples de prompts</p>
                    <div class="flex flex-col gap-2">
                        <button type="button" onclick="setPrompt(this)" class="text-left text-xs text-indigo-700 hover:text-indigo-900 hover:underline"
                            data-prompt="Génère un cours destiné à un niveau Bac+3 sur l'histoire du marketing, structuré en 4 chapitres avec 2 sous-chapitres chacun, suivi d'un quiz de 10 questions permettant de vérifier la bonne compréhension du contenu.">
                            → Histoire du marketing (Bac+3, 4 chapitres, 10 questions)
                        </button>
                        <button type="button" onclick="setPrompt(this)" class="text-left text-xs text-indigo-700 hover:text-indigo-900 hover:underline"
                            data-prompt="Je souhaite apprendre Python à des étudiants de niveau Bac+2. Crée un cours structuré en 3 chapitres avec 2 sous-chapitres chacun, avec un quiz de 5 questions à la fin pour tester leurs connaissances.">
                            → Bases de Python (Bac+2, 3 chapitres, 5 questions)
                        </button>
                        <button type="button" onclick="setPrompt(this)" class="text-left text-xs text-indigo-700 hover:text-indigo-900 hover:underline"
                            data-prompt="Crée un module de formation sur la méthode Agile Scrum destiné à des professionnels de niveau Bac+4, avec 2 chapitres et 2 sous-chapitres chacun, et un quiz de 8 questions pour valider les acquis.">
                            → Gestion de projet Agile/Scrum (Bac+4, 2 chapitres, 8 questions)
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-200 transition">
                        Annuler
                    </a>
                    <button type="submit" id="btn-generer" class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span id="btn-texte">Générer avec l'IA</span>
                    </button>
                </div>
            </form>

            <!-- Overlay de chargement -->
            <div id="loading-overlay" class="hidden fixed inset-0 bg-white bg-opacity-95 z-50 flex flex-col items-center justify-center">
                <div class="animate-spin rounded-full h-16 w-16 border-4 border-indigo-600 border-t-transparent mb-6"></div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Génération en cours...</h2>
                <p class="text-gray-500 text-sm text-center max-w-sm mb-4">
                    L'IA génère votre formation complète avec les contenus et les quiz.<br>
                    Cela peut prendre <strong class="text-indigo-600">2 à 5 minutes</strong>, merci de ne pas fermer la page.
                </p>
                <div class="flex gap-1 mt-2">
                    <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                    <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
            </div>

            <script>
            document.getElementById('form-generation').addEventListener('submit', function() {
                document.getElementById('loading-overlay').classList.remove('hidden');
                document.getElementById('btn-generer').disabled = true;
                document.getElementById('btn-texte').textContent = 'Génération en cours...';
            });

            function setPrompt(btn) {
                document.querySelector('textarea[name="prompt"]').value = btn.getAttribute('data-prompt');
            }
            </script>
        </div>

        <!-- Info -->
        <div class="mt-6 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Comment ça fonctionne ?</p>
            <div class="flex flex-col gap-3">
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-indigo-600 flex-shrink-0">01.</span>
                    <p class="text-sm text-gray-500">Décrivez le cours souhaité : niveau, sujet, nombre de chapitres et de questions.</p>
                </div>
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-indigo-600 flex-shrink-0">02.</span>
                    <p class="text-sm text-gray-500">L'IA Claude génère automatiquement le contenu pédagogique structuré.</p>
                </div>
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-indigo-600 flex-shrink-0">03.</span>
                    <p class="text-sm text-gray-500">La formation, les chapitres, les sous-chapitres et le quiz sont créés automatiquement dans la plateforme.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setPrompt(btn) {
            document.querySelector('textarea[name="prompt"]').value = btn.dataset.prompt;
        }

        document.getElementById('form-generation').addEventListener('submit', function() {
            const btn = document.getElementById('btn-generer');
            const texte = document.getElementById('btn-texte');
            btn.disabled = true;
            btn.classList.add('opacity-75');
            texte.textContent = 'Génération en cours...';
        });
    </script>
@endsection