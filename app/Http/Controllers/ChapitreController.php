<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Formation;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    // Récupère tous les chapitres avec leur formation associée
    public function index()
    {
        $chapitres = Chapitre::with('formation')->get();
        return view('chapitres.index', compact('chapitres'));
    }

    // Affiche le formulaire de création d'un chapitre
    public function create()
    {
        $formations = Formation::all();
        return view('chapitres.create', compact('formations'));
    }

    // Valide les données du formulaire et enregistre le nouveau chapitre en BDD
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formation_id' => 'required|exists:formations,id',
        ]);

        Chapitre::create($request->all());

        return redirect()->route('chapitres.index')
            ->with('success', 'Chapitre créé avec succès.');
    }

    // Affiche le détail d'un chapitre 
    public function show(Chapitre $chapitre)
    {
        return view('chapitres.show', compact('chapitre'));
    }

    // Affiche le formulaire de modification d'un chapitre existant
    public function edit(Chapitre $chapitre)
    {
        $formations = Formation::all();
        return view('chapitres.edit', compact('chapitre', 'formations'));
    }

    // Valide les nouvelles données et met à jour le chapitre en BDD
    public function update(Request $request, Chapitre $chapitre)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'formation_id' => 'required|exists:formations,id',
        ]);

        $chapitre->update($request->all());

        return redirect()->route('chapitres.index')
            ->with('success', 'Chapitre mis à jour avec succès.');
    }

    // Supprime le chapitre de la BDD
    public function destroy(Chapitre $chapitre)
    {
        $chapitre->delete();

        return redirect()->route('chapitres.index')
            ->with('success', 'Chapitre supprimé avec succès.');
    }
}