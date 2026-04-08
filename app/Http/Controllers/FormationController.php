<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    // Récupère toutes les formations et les envoie à la vue index
    public function index()
    {
        $formations = Formation::all();
        return view('formations.index', compact('formations'));
    }

    // Affiche le formulaire de création d'une formation
    public function create()
    {
        return view('formations.create');
    }

    // Valide les données du formulaire et enregistre la nouvelle formation dans la BDD
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau' => 'required|string|max:255',
            'duree' => 'nullable|integer',
        ]);

        Formation::create($request->all());

        return redirect()->route('formations.index')
            ->with('success', 'Formation créée avec succès.');
    }

    // Affiche le détail d'une formation
    public function show(Formation $formation)
    {
        return view('formations.show', compact('formation'));
    }

    // Affiche le formulaire de modification d'une formation existante
    public function edit(Formation $formation)
    {
        return view('formations.edit', compact('formation'));
    }

    // Valide les nouvelles données et met à jour la formation en BDD
    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau' => 'required|string|max:255',
            'duree' => 'nullable|integer',
        ]);

        // Met à jour uniquement les champs modifiés
        $formation->update($request->all());

        return redirect()->route('formations.index')
            ->with('success', 'Formation mise à jour avec succès.');
    }

    // Supprime la formation de la BDD
    public function destroy(Formation $formation)
    {
        $formation->delete();

        return redirect()->route('formations.index')
            ->with('success', 'Formation supprimée avec succès.');
    }

    // Récupère toutes les formations de l'apprenant connecté
    public function mesFormations()
    {
        $apprenant = auth()->user()->apprenant;
        $formations = $apprenant->formations;
        return view('formations.mes-formations', compact('formations'));
    }
}