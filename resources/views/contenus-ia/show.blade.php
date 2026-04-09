@extends('layouts.app')

@section('title', 'Contenu IA')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $contenuIa->titre }}</h1>
            <div class="flex gap-3">
                <a href="{{ route('contenus-ia.edit', $contenuIa) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-xl hover:bg-yellow-600 text-sm font-medium">
                    Modifier
                </a>
                <a href="{{ route('sous-chapitres.show', $contenuIa->sousChapitre) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 text-sm font-medium">
                    Retour
                </a>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-8">
            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-100">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Sous-chapitre</p>
                    <p class="font-semibold text-gray-700">{{ $contenuIa->sousChapitre->titre }}</p>
                </div>
                @if($contenuIa->source)
                    <div class="ml-8">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Source</p>
                        <span class="text-xs font-bold px-2 py-1 rounded-full
                            {{ str_contains(strtolower($contenuIa->source), 'claude') ? 'bg-indigo-100 text-indigo-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ $contenuIa->source }}
                        </span>
                    </div>
                @endif
            </div>

            @php
                $lignes = explode("\n", $contenuIa->contenu);
                $estTableau = collect($lignes)->filter(fn($l) => str_contains($l, '|'))->count() > 2;
                $estMarkdown = str_contains($contenuIa->contenu, '##') || str_contains($contenuIa->contenu, '**');
            @endphp

            @if($estMarkdown || $estTableau)
                <div class="prose prose-indigo prose-sm max-w-none">
                    {!! (new \League\CommonMark\GithubFlavoredMarkdownConverter(['html_input' => 'strip', 'allow_unsafe_links' => false]))->convert($contenuIa->contenu) !!}
                </div>
            @else
                <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $contenuIa->contenu }}</div>
            @endif
        </div>
    </div>
@endsection