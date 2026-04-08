@extends('layouts.app')

@section('title', 'Apprenants')

@section('content')

    <!-- En-tête -->
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Apprenants</h1>
            <p class="text-gray-400 mt-1">Gérez votre communauté d'apprentissage et administrez les inscriptions.</p>
        </div>
        <a href="{{ route('apprenants.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
            + Nouvel apprenant
        </a>
    </div>

    <!-- Cartes stats -->
    <div class="grid grid-cols-4 gap-4 mb-8">

        <!-- Total apprenants -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Total Apprenants</p>
            <p class="text-5xl font-bold text-gray-900">{{ \App\Models\Apprenant::count() }}</p>
        </div>

        <!-- Formations actives -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-3">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Formations actives</p>
            <p class="text-5xl font-bold text-gray-900">{{ \App\Models\Formation::count() }}</p>
        </div>

        <!-- Derniers résultats quiz -->
        <div class="col-span-2 bg-indigo-600 rounded-2xl shadow-sm p-6">
            <p class="text-xs font-bold text-white uppercase tracking-wide mb-4" style="opacity:0.7">Derniers résultats quiz</p>
            @php
                $resultats = \App\Models\ResultatQuiz::with('quiz', 'apprenant')->latest()->take(3)->get();
            @endphp
            @forelse($resultats as $resultat)
                <div class="flex items-center justify-between py-3 border-b" style="border-color:rgba(255,255,255,0.2)">
                    <div>
                        <p class="text-white text-sm font-semibold">{{ $resultat->apprenant->nom }}</p>
                        <p class="text-white text-xs" style="opacity:0.7">{{ Str::limit($resultat->quiz->titre, 25) }}</p>
                    </div>
                    <span class="text-white font-bold text-sm px-3 py-1 rounded-lg" style="background:rgba(255,255,255,0.2)">
                        {{ $resultat->score }}/{{ $resultat->quiz->questions->count() }}
                    </span>
                </div>
            @empty
                <p class="text-white text-sm" style="opacity:0.7">Aucun résultat pour le moment.</p>
            @endforelse
        </div>
    </div>

    <!-- Barre de recherche -->
    <div class="relative mb-4">
        <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input id="search" type="text" placeholder="Rechercher un apprenant..."
            class="w-full pl-11 pr-4 py-3 bg-white border border-gray-100 rounded-2xl text-sm text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
    </div>

    <!-- Tableau des apprenants -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Apprenant</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Cours inscrits</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody id="apprenants-table">
                @forelse($apprenants as $apprenant)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition apprenant-row">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($apprenant->nom, 0, 2)) }}
                                </div>
                                <span class="font-semibold text-gray-800 apprenant-nom">{{ $apprenant->nom }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-gray-500 text-sm">{{ $apprenant->email }}</td>
                        <td class="px-6 py-5">
                            <div class="flex flex-wrap gap-1">
                                @foreach($apprenant->formations->take(2) as $formation)
                                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md uppercase tracking-wide">
                                        {{ Str::limit($formation->nom, 15) }}
                                    </span>
                                @endforeach
                                @if($apprenant->formations->count() > 2)
                                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md">
                                        +{{ $apprenant->formations->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('apprenants.show', $apprenant) }}" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('apprenants.edit', $apprenant) }}" class="text-indigo-500 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('apprenants.destroy', $apprenant) }}" onsubmit="return confirm('Supprimer cet apprenant ?')">
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
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Aucun apprenant trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Script recherche en temps réel -->
    <script>
        document.getElementById('search').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.apprenant-row').forEach(function(row) {
                const nom = row.querySelector('.apprenant-nom').textContent.toLowerCase();
                row.style.display = nom.includes(query) ? '' : 'none';
            });
        });
    </script>

@endsection