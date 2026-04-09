@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if(auth()->user()->role === 'admin')

        <!-- En-tête Admin -->
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ auth()->user()->name }} !</h1>
                <p class="text-gray-400 mt-1">Bienvenue dans votre espace d'administration.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('generation-ia.index') }}" class="flex items-center gap-2 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl hover:bg-indigo-200 transition text-sm font-medium">
                    ✨ Générer avec l'IA
                </a>
                <a href="{{ route('contenus-ia.create') }}" class="flex items-center gap-2 border border-gray-200 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                    ↑ Importer du contenu
                </a>
                <a href="{{ route('formations.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
                    + Nouveau cours
                </a>
            </div>
        </div>

        <!-- Cartes stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('formations.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Total Formations</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Formation::count() }}</p>
            </a>

            <a href="{{ route('apprenants.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Apprenants</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Apprenant::count() }}</p>
            </a>

            <a href="{{ route('quiz.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Quiz Actifs</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Quiz::count() }}</p>
            </a>

            <a href="{{ route('notes.index') }}" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Notes totales</p>
                <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Note::count() }}</p>
            </a>
        </div>

        <!-- Contenu principal + Actions rapides -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Formations et apprenants récents -->
            <div class="md:col-span-2 flex flex-col gap-6">

                <!-- Formations récentes -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-800">Formations récentes</h2>
                        <a href="{{ route('formations.index') }}" class="text-indigo-600 text-sm hover:underline">Voir tout</a>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Formation</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Niveau</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Durée</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Formation::latest()->take(4)->get() as $formation)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                                <span class="font-semibold text-gray-800 text-sm">{{ $formation->nom }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md">{{ $formation->niveau }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $formation->duree ?? '-' }}h</td>
                                        <td class="px-6 py-4">
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
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Apprenants récents -->
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-800">Apprenants récents</h2>
                        <a href="{{ route('apprenants.index') }}" class="text-indigo-600 text-sm hover:underline">Liste complète</a>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Apprenant</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Formations</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Apprenant::with('formations')->latest()->take(4)->get() as $apprenant)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                    {{ strtoupper(substr($apprenant->nom, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800 text-sm">{{ $apprenant->nom }}</p>
                                                    <p class="text-gray-400 text-xs">{{ $apprenant->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($apprenant->formations->take(2) as $formation)
                                                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md uppercase tracking-wide">{{ Str::limit($formation->nom, 15) }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('apprenants.show', $apprenant) }}" class="text-indigo-600 hover:underline text-sm">Voir</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Actions rapides + Todo -->
            <div class="flex flex-col gap-6">

                <!-- Actions rapides -->
                <div>
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Actions Rapides</h2>
                    <div class="bg-indigo-600 rounded-2xl p-4">
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('generation-ia.index') }}" style="background:rgba(255,255,255,0.15)" class="text-white px-4 py-2.5 rounded-xl hover:opacity-90 transition text-sm font-medium">
                                ✨ Générer avec l'IA
                            </a>
                            <a href="{{ route('chapitres.create') }}" style="background:rgba(255,255,255,0.15)" class="text-white px-4 py-2.5 rounded-xl hover:opacity-90 transition text-sm font-medium">
                                + Nouveau chapitre
                            </a>
                            <a href="{{ route('apprenants.create') }}" style="background:rgba(255,255,255,0.15)" class="text-white px-4 py-2.5 rounded-xl hover:opacity-90 transition text-sm font-medium">
                                + Nouvel apprenant
                            </a>
                            <a href="{{ route('quiz.create') }}" style="background:rgba(255,255,255,0.15)" class="text-white px-4 py-2.5 rounded-xl hover:opacity-90 transition text-sm font-medium">
                                + Nouveau quiz
                            </a>
                            <a href="{{ route('notes.create') }}" style="background:rgba(255,255,255,0.15)" class="text-white px-4 py-2.5 rounded-xl hover:opacity-90 transition text-sm font-medium">
                                + Ajouter une note
                            </a>
                            <a href="{{ route('contenus-ia.create') }}" style="background:rgba(255,255,255,0.15)" class="text-white px-4 py-2.5 rounded-xl hover:opacity-90 transition text-sm font-medium">
                                ↑ Importer un contenu
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Todo list -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-700">Actions à effectuer</h3>
                        <button onclick="document.getElementById('todo-form').classList.toggle('hidden')"
                            class="text-xs text-indigo-600 font-medium hover:underline">
                            + Ajouter
                        </button>
                    </div>

                    <div id="todo-form" class="hidden mb-4">
                        <form method="POST" action="{{ route('todos.store') }}" class="flex gap-2">
                            @csrf
                            <input type="text" name="texte" placeholder="Nouvelle tâche..."
                                class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <button type="submit" class="bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                                ✓
                            </button>
                        </form>
                    </div>

                    <div class="flex flex-col gap-2">
                        @forelse(\App\Models\Todo::latest()->get() as $todo)
                            <div class="flex items-center gap-3 py-2 border-b border-gray-50">
                                <form method="POST" action="{{ route('todos.toggle', $todo) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-5 h-5 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition
                                        {{ $todo->fait ? 'bg-indigo-600 border-indigo-600' : 'border-gray-300 hover:border-indigo-400' }}">
                                        @if($todo->fait)
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                                <span class="text-sm {{ $todo->fait ? 'line-through text-gray-400' : 'text-gray-700' }} flex-1">
                                    {{ $todo->texte }}
                                </span>
                                <form method="POST" action="{{ route('todos.destroy', $todo) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-400 text-sm text-center py-4">Aucune tâche pour le moment.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- Dashboard Apprenant -->
        @php
            $apprenant = auth()->user()->apprenant;
            $notes = $apprenant ? $apprenant->notes : collect();
            $moyenne = $notes->count() > 0 ? round($notes->avg('note'), 2) : null;
        @endphp

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Bonjour, {{ auth()->user()->name }} ! 👋
            </h1>
            <p class="text-gray-500 mt-1">Ravi de vous revoir. Prêt à poursuivre votre apprentissage aujourd'hui ?</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            <a href="{{ route('mes-formations') }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-1">Mes formations</h2>
                    <p class="text-gray-500 text-sm">Consulter mes cours et passer les quiz.</p>
                </div>
                <div class="mt-6">
                    <span class="text-indigo-600 font-medium flex items-center gap-1">
                        Accéder
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </a>

            <a href="{{ route('mes-notes') }}" class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-md transition border border-gray-100 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-1">Mes notes</h2>
                    <p class="text-gray-500 text-sm">Consulter mes résultats et mes notes.</p>
                </div>

                @if($moyenne !== null)
                    <div class="mt-4">
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($moyenne / 20) * 100 }}%"></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Moyenne Générale</span>
                            <span class="text-sm font-bold text-indigo-600">{{ $moyenne }} / 20</span>
                        </div>
                    </div>
                @else
                    <div class="mt-4">
                        <span class="text-indigo-600 font-medium flex items-center gap-1">
                            Accéder
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                @endif
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-800">Continuer l'apprentissage</h2>
                <a href="{{ route('mes-formations') }}" class="text-indigo-600 text-sm hover:underline">Voir tout</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($apprenant->formations as $formation)
                    <a href="{{ route('mes-formations') }}" class="border border-gray-100 rounded-xl p-4 hover:border-indigo-300 hover:shadow-sm transition flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md uppercase tracking-wide">
                                    {{ $formation->niveau }}
                                </span>
                                @if($formation->duree)
                                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                        {{ $formation->duree }}H
                                    </span>
                                @endif
                            </div>
                            <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>
                        <p class="font-bold text-gray-800 text-base">{{ $formation->nom }}</p>
                        @if($formation->description)
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $formation->description }}</p>
                        @endif
                    </a>
                @empty
                    <p class="text-gray-500 text-sm">Aucune formation assignée.</p>
                @endforelse
            </div>
        </div>
    @endif
@endsection