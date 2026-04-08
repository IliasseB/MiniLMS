<?php

namespace App\Http\Controllers;

use App\Models\ContenuIa;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class ContenuIaController extends Controller
{
    public function index()
    {
        $contenusIa = ContenuIa::with('sousChapitre')->get();
        return view('contenus-ia.index', compact('contenusIa'));
    }

    public function create()
    {
        $souschapitres = SousChapitre::all();
        return view('contenus-ia.create', compact('souschapitres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string',
            'source' => 'nullable|string|max:255',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        $sousChapitre = SousChapitre::find($request->sous_chapitre_id);

        ContenuIa::create([
            'titre' => $request->titre ?? $sousChapitre->titre,
            'contenu' => $request->contenu,
            'source' => $request->source,
            'sous_chapitre_id' => $request->sous_chapitre_id,
        ]);

        return redirect()->route('sous-chapitres.index')
            ->with('success', 'Contenu importé avec succès.');
    }

    public function show(ContenuIa $contenuIa)
    {
        return view('contenus-ia.show', compact('contenuIa'));
    }

    public function edit(ContenuIa $contenuIa)
    {
        $souschapitres = SousChapitre::all();
        return view('contenus-ia.edit', compact('contenuIa', 'souschapitres'));
    }

    public function update(Request $request, ContenuIa $contenuIa)
    {
        $request->validate([
            'contenu' => 'required|string',
            'source' => 'nullable|string|max:255',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        $sousChapitre = SousChapitre::find($request->sous_chapitre_id);

        $contenuIa->update([
            'titre' => $request->titre ?? $sousChapitre->titre,
            'contenu' => $request->contenu,
            'source' => $request->source,
            'sous_chapitre_id' => $request->sous_chapitre_id,
        ]);

        return redirect()->route('sous-chapitres.index')
            ->with('success', 'Contenu mis à jour avec succès.');
    }

    public function destroy(ContenuIa $contenuIa)
    {
        $contenuIa->delete();

        return redirect()->route('sous-chapitres.index')
            ->with('success', 'Contenu supprimé avec succès.');
    }
}