<?php

namespace App\Http\Controllers;

use App\Models\SousChapitre;
use App\Models\Chapitre;
use Illuminate\Http\Request;

class SousChapitreController extends Controller
{
    // Récupère tous les sous-chapitres avec leur chapitre associé
    public function index()
    {
        $souschapitres = SousChapitre::with('chapitre.formation')->get();
        return view('souschapitres.index', compact('souschapitres'));
    }

    // Affiche le formulaire de création d'un sous-chapitre
    public function create()
    {
        $chapitres = Chapitre::all();
        return view('souschapitres.create', compact('chapitres'));
    }

    // Valide les données du formulaire et enregistre le nouveau sous-chapitre en BDD
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
            'chapitre_id' => 'required|exists:chapitres,id',
        ]);

        SousChapitre::create($request->all());

        return redirect()->route('sous-chapitres.index')
            ->with('success', 'Sous-chapitre créé avec succès.');
    }

    // Affiche le détail d'un sous-chapitre
    public function show(SousChapitre $sousChapitre)
    {
        $sousChapitre->load('chapitre.formation', 'quiz.questions', 'contenusIa');
        return view('souschapitres.show', compact('sousChapitre'));
    }

    // Affiche le formulaire de modification d'un sous-chapitre existant
    public function edit(SousChapitre $sousChapitre)
    {
        $chapitres = Chapitre::all();
        return view('souschapitres.edit', compact('sousChapitre', 'chapitres'));
    }

    // Valide les nouvelles données et met à jour le sous-chapitre en BDD
    public function update(Request $request, SousChapitre $sousChapitre)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string',
            'chapitre_id' => 'required|exists:chapitres,id',
        ]);

        $sousChapitre->update($request->all());

        return redirect()->route('sous-chapitres.index')
            ->with('success', 'Sous-chapitre mis à jour avec succès.');
    }

    public function consulter(SousChapitre $sousChapitre, $page = 0)
    {
        $sousChapitre->load('chapitre.formation', 'quiz.questions', 'contenusIa');
        $contenus = $sousChapitre->contenusIa;

        // Page 0 = résumé + 1er contenu
        // Pages suivantes = contenus à partir du 2ème (index $page)
        $totalPages = max(0, $contenus->count() - 1);
        $contenuActuel = $page > 0 ? $contenus->get($page) : null;

        return view('souschapitres.consulter', compact('sousChapitre', 'page', 'totalPages', 'contenuActuel'));
    }

    // Supprime le sous-chapitre de la BDD
    public function destroy(SousChapitre $sousChapitre)
    {
        $sousChapitre->delete();

        return redirect()->route('sous-chapitres.index')
            ->with('success', 'Sous-chapitre supprimé avec succès.');
    }
}