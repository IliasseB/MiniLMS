@extends('layouts.app')

@section('title', $sousChapitre->titre)

@section('content')
    <div class="max-w-3xl mx-auto">

        <!-- Fil d'ariane -->
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
            <a href="{{ route('mes-formations') }}" class="hover:text-indigo-600">Mes formations</a>
            <span>›</span>
            <span class="text-gray-700 font-medium">{{ $sousChapitre->titre }}</span>
        </div>

        <!-- En-tête -->
        <div class="flex items-start justify-between mb-8">
            <div>
                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wide mb-1">{{ $sousChapitre->chapitre->formation->nom }}</p>
                <h1 class="text-3xl font-bold text-gray-900">{{ $sousChapitre->titre }}</h1>
                <p class="text-gray-400 mt-1">{{ $sousChapitre->chapitre->titre }}</p>
            </div>
            <a href="{{ route('mes-formations') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 transition text-sm font-medium">
                ← Retour
            </a>
        </div>

        <!-- Indicateur de progression -->
        @if($totalPages > 0)
            <div class="flex items-center gap-2 mb-6">
                <a href="{{ route('souschapitres.consulter', [$sousChapitre, 0]) }}"
                    class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition
                    {{ $page == 0 ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-400 hover:border-indigo-400' }}">
                    R
                </a>
                @for($i = 1; $i <= $totalPages; $i++)
                    <a href="{{ route('souschapitres.consulter', [$sousChapitre, $i]) }}"
                        class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition
                        {{ $page == $i ? 'bg-indigo-600 text-white' : 'bg-white border border-gray-200 text-gray-400 hover:border-indigo-400' }}">
                        {{ $i }}
                    </a>
                @endfor
                <span class="text-xs text-gray-400 ml-2">
                    {{ $page == 0 ? 'Résumé + contenu' : "Contenu $page / $totalPages" }}
                </span>
            </div>
        @endif

        <!-- Contenu affiché selon la page -->
        @if($page == 0)
            <!-- Résumé principal -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Résumé</h2>
                @if($sousChapitre->contenu)
                    <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $sousChapitre->contenu }}
                    </div>
                @else
                    <p class="text-gray-400 text-sm">Aucun résumé disponible pour ce sous-chapitre.</p>
                @endif
            </div>

            <!-- Premier contenu importé -->
            @if($sousChapitre->contenusIa->count() > 0)
                @php
                    $premierContenu = $sousChapitre->contenusIa->first();
                    $lignes = explode("\n", $premierContenu->contenu);
                    $estTableau = collect($lignes)->filter(fn($l) => str_contains($l, '|'))->count() > 2;
                    $estMarkdown = str_contains($premierContenu->contenu, '##') || str_contains($premierContenu->contenu, '**');
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        @if($premierContenu->source)
                            <span class="text-xs font-bold px-2 py-1 rounded-full
                                {{ str_contains(strtolower($premierContenu->source), 'ia') ? 'bg-indigo-100 text-indigo-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $premierContenu->source }}
                            </span>
                        @endif
                        <h2 class="text-lg font-bold text-gray-800">Contenu</h2>
                    </div>

                    @if($estMarkdown)
                        <div class="prose prose-indigo prose-sm max-w-none">
                            {!! (new \League\CommonMark\CommonMarkConverter(['html_input' => 'strip', 'allow_unsafe_links' => false]))->convert($premierContenu->contenu) !!}
                        </div>
                    @elseif($estTableau)
                        @php $dansTableau = false; @endphp
                        @foreach($lignes as $ligne)
                            @if(str_contains($ligne, '|'))
                                @if(!$dansTableau)
                                    <div class="overflow-x-auto mb-4">
                                    <table class="min-w-full text-sm border border-gray-100 rounded-xl overflow-hidden">
                                    <thead><tr class="bg-indigo-50">
                                    @foreach(array_map('trim', explode('|', $ligne)) as $cellule)
                                        <th class="px-4 py-2 text-left text-xs font-bold text-indigo-700 uppercase tracking-wide">{{ $cellule }}</th>
                                    @endforeach
                                    </tr></thead><tbody>
                                    @php $dansTableau = true; @endphp
                                @else
                                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                                    @foreach(array_map('trim', explode('|', $ligne)) as $cellule)
                                        <td class="px-4 py-2 text-gray-700 text-sm">{{ $cellule }}</td>
                                    @endforeach
                                    </tr>
                                @endif
                            @else
                                @if($dansTableau)
                                    </tbody></table></div>
                                    @php $dansTableau = false; @endphp
                                @endif
                                @if(trim($ligne) !== '')
                                    <p class="text-gray-700 text-sm leading-relaxed mb-2">{{ $ligne }}</p>
                                @endif
                            @endif
                        @endforeach
                        @if($dansTableau)
                            </tbody></table></div>
                        @endif
                    @else
                        <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $premierContenu->contenu }}</div>
                    @endif
                </div>
            @endif

        @else
            <!-- Pages suivantes : contenus importés -->
            @if($contenuActuel)
                @php
                    $lignes = explode("\n", $contenuActuel->contenu);
                    $estTableau = collect($lignes)->filter(fn($l) => str_contains($l, '|'))->count() > 2;
                    $estMarkdown = str_contains($contenuActuel->contenu, '##') || str_contains($contenuActuel->contenu, '**');
                @endphp
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-6">
                    <div class="flex items-center gap-2 mb-4">
                        @if($contenuActuel->source)
                            <span class="text-xs font-bold px-2 py-1 rounded-full
                                {{ str_contains(strtolower($contenuActuel->source), 'ia') ? 'bg-indigo-100 text-indigo-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $contenuActuel->source }}
                            </span>
                        @endif
                        <h2 class="text-lg font-bold text-gray-800">Contenu {{ $page }}</h2>
                    </div>

                    @if($estMarkdown)
                        <div class="prose prose-indigo prose-sm max-w-none">
                            {!! (new \League\CommonMark\CommonMarkConverter(['html_input' => 'strip', 'allow_unsafe_links' => false]))->convert($contenuActuel->contenu) !!}
                        </div>
                    @elseif($estTableau)
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full text-sm border border-gray-100 rounded-xl overflow-hidden">
                                @php $premiereRangeTableau = true; @endphp
                                @foreach($lignes as $ligne)
                                    @if(str_contains($ligne, '|'))
                                        @php $cellules = array_map('trim', explode('|', $ligne)); @endphp
                                        @if($premiereRangeTableau)
                                            <thead>
                                                <tr class="bg-indigo-50">
                                                    @foreach($cellules as $cellule)
                                                        <th class="px-4 py-2 text-left text-xs font-bold text-indigo-700 uppercase tracking-wide">{{ $cellule }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php $premiereRangeTableau = false; @endphp
                                        @else
                                            <tr class="border-b border-gray-50 hover:bg-gray-50">
                                                @foreach($cellules as $cellule)
                                                    <td class="px-4 py-2 text-gray-700 text-sm">{{ $cellule }}</td>
                                                @endforeach
                                            </tr>
                                        @endif
                                    @elseif(trim($ligne) !== '')
                                        @php $premiereRangeTableau = false; @endphp
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @foreach($lignes as $ligne)
                            @if(!str_contains($ligne, '|') && trim($ligne) !== '')
                                <p class="text-gray-700 text-sm leading-relaxed mb-1">{{ $ligne }}</p>
                            @endif
                        @endforeach
                    @else
                        <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $contenuActuel->contenu }}</div>
                    @endif
                </div>
            @endif
        @endif

        <!-- Navigation précédent / suivant -->
        <div class="flex items-center justify-between mb-6">
            @if($page > 0)
                <a href="{{ route('souschapitres.consulter', [$sousChapitre, $page - 1]) }}"
                    class="flex items-center gap-2 bg-white border border-gray-200 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                    ← Précédent
                </a>
            @else
                <div></div>
            @endif

            @if($page < $totalPages)
                <a href="{{ route('souschapitres.consulter', [$sousChapitre, $page + 1]) }}"
                    class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl hover:bg-indigo-700 transition text-sm font-medium">
                    Suivant →
                </a>
            @endif
        </div>

        <!-- Bouton passer le quiz -->
        @if($page == $totalPages && $sousChapitre->quiz)
            <div class="bg-indigo-600 rounded-2xl p-6 flex items-center justify-between">
                <div>
                    <h3 class="text-white font-bold text-lg">{{ $sousChapitre->quiz->titre }}</h3>
                    <p class="text-white text-sm mt-1" style="opacity:0.7">{{ $sousChapitre->quiz->questions->count() }} questions</p>
                </div>
                <a href="{{ route('quiz.passer', $sousChapitre->quiz) }}"
                    class="bg-white text-indigo-600 font-semibold px-5 py-2.5 rounded-xl hover:bg-indigo-50 transition text-sm">
                    Passer le quiz →
                </a>
            </div>
        @endif

    </div>
@endsection