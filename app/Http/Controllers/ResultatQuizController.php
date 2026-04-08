<?php

namespace App\Http\Controllers;

use App\Models\ResultatQuiz;
use App\Models\Quiz;
use App\Models\Apprenant;
use Illuminate\Http\Request;

class ResultatQuizController extends Controller
{
    // Récupère tous les résultats avec leur apprenant et quiz associés
    public function index()
    {
        $resultats = ResultatQuiz::with('apprenant', 'quiz')->get();
        return view('resultats.index', compact('resultats'));
    }

    // Soumet les réponses du quiz et calcule le score automatiquement
    public function soumettre(Request $request, Quiz $quiz)
    {
        $request->validate([
            'reponses' => 'required|array',
        ]);

        $apprenant = auth()->user()->apprenant;
        $score = 0;
        $total = $quiz->questions->count();

        foreach ($request->reponses as $question_id => $reponse_id) {
            $reponse = \App\Models\Reponse::find($reponse_id);
            if ($reponse && $reponse->est_correcte) {
                $score++;
            }
        }

        // Enregistre le résultat avec les réponses choisies
        ResultatQuiz::create([
            'score' => $score,
            'apprenant_id' => $apprenant->id,
            'quiz_id' => $quiz->id,
            'reponses_donnees' => json_encode($request->reponses),
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Quiz terminé ! Vous avez obtenu $score / $total.");
    }

    public function show(ResultatQuiz $resultatQuiz)
    {
        // Charge le quiz avec ses questions et réponses
        $resultatQuiz->load('quiz.questions.reponses');
        return view('resultats.show', compact('resultatQuiz'));
    }

    public function destroy(ResultatQuiz $resultatQuiz)
    {
        $resultatQuiz->delete();

        return redirect()->route('resultats.index')
            ->with('success', 'Résultat supprimé avec succès.');
    }

    // Crée les méthodes vides pour satisfaire le contrat resource
    public function create() {}
    public function store(Request $request) {}
    public function edit(ResultatQuiz $resultatQuiz) {}
    public function update(Request $request, ResultatQuiz $resultatQuiz) {}
}