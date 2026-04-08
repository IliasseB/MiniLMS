<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\SousChapitre;
use Illuminate\Http\Request;

class ContenuController extends Controller
{
    // Récupère tous les contenus avec leur sous-chapitre associé
    public function index()
    {
        $contenus = Contenu::with('sousChapitre')->get();
        return view('contenus.index', compact('contenus'));
    }

    // Affiche le formulaire de création d'un contenu
    public function create()
    {
        $souschapitres = SousChapitre::all();
        return view('contenus.create', compact('souschapitres'));
    }

    // Valide les données du formulaire et enregistre le nouveau contenu en BDD
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'nullable|string',
            'lien_ressource' => 'nullable|url',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        Contenu::create($request->all());

        return redirect()->route('contenus.index')
            ->with('success', 'Contenu créé avec succès.');
    }

    // Affiche le détail d'un contenu
    public function show(Contenu $contenu)
    {
        return view('contenus.show', compact('contenu'));
    }

    // Affiche le formulaire de modification d'un contenu existant
    public function edit(Contenu $contenu)
    {
        $souschapitres = SousChapitre::all();
        return view('contenus.edit', compact('contenu', 'souschapitres'));
    }

    // Valide les nouvelles données et met à jour le contenu en BDD
    public function update(Request $request, Contenu $contenu)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'nullable|string',
            'lien_ressource' => 'nullable|url',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        $contenu->update($request->all());

        return redirect()->route('contenus.index')
            ->with('success', 'Contenu mis à jour avec succès.');
    }

    // Supprime le contenu de la BDD
    public function destroy(Contenu $contenu)
    {
        $contenu->delete();

        return redirect()->route('contenus.index')
            ->with('success', 'Contenu supprimé avec succès.');
    }
}