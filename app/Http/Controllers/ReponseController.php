<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use App\Models\Question;
use Illuminate\Http\Request;

class ReponseController extends Controller
{
    // Récupère toutes les réponses avec leur question associée
    public function index()
    {
        $reponses = Reponse::with('question')->get();
        return view('reponses.index', compact('reponses'));
    }

    // Affiche le formulaire de création d'une réponse
    public function create()
    {
        $questions = Question::all();
        return view('reponses.create', compact('questions'));
    }

    // Valide les données du formulaire et enregistre la nouvelle réponse en BDD
    public function store(Request $request)
    {
        $request->validate([
            'texte' => 'required|string|max:255',
            'est_correcte' => 'boolean',
            'question_id' => 'required|exists:questions,id',
        ]);

        Reponse::create($request->all());

        return redirect()->route('reponses.index')
            ->with('success', 'Réponse créée avec succès.');
    }

    // Affiche le détail d'une réponse
    public function show(Reponse $reponse)
    {
        return view('reponses.show', compact('reponse'));
    }

    // Affiche le formulaire de modification d'une réponse existante
    public function edit(Reponse $reponse)
    {
        $questions = Question::all();
        return view('reponses.edit', compact('reponse', 'questions'));
    }

    // Valide les nouvelles données et met à jour la réponse en BDD
    public function update(Request $request, Reponse $reponse)
    {
        $request->validate([
            'texte' => 'required|string|max:255',
            'est_correcte' => 'boolean',
            'question_id' => 'required|exists:questions,id',
        ]);

        $reponse->update($request->all());

        return redirect()->route('reponses.index')
            ->with('success', 'Réponse mise à jour avec succès.');
    }

    // Supprime la réponse de la BDD
    public function destroy(Reponse $reponse)
    {
        $reponse->delete();

        return redirect()->route('reponses.index')
            ->with('success', 'Réponse supprimée avec succès.');
    }
}