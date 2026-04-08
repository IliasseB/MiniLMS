<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\SousChapitre;
use App\Models\ResultatQuiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Récupère tous les quiz avec leur sous-chapitre associé
    public function index()
    {
        $quizzes = Quiz::with('sousChapitre')->get();
        return view('quiz.index', compact('quizzes'));
    }

    // Affiche le formulaire de création d'un quiz
    public function create()
    {
        $souschapitres = SousChapitre::all();
        return view('quiz.create', compact('souschapitres'));
    }

    // Valide les données du formulaire et enregistre le nouveau quiz en BDD
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        // Crée le quiz
        $quiz = Quiz::create([
            'titre' => $request->titre,
            'sous_chapitre_id' => $request->sous_chapitre_id,
        ]);

        // Crée les questions et réponses si présentes
        if ($request->questions) {
            foreach ($request->questions as $q) {
                if (empty($q['question'])) continue;

                $question = \App\Models\Question::create([
                    'question' => $q['question'],
                    'quiz_id' => $quiz->id,
                ]);

                if (!empty($q['reponses'])) {
                    foreach ($q['reponses'] as $r) {
                        if (empty($r['texte'])) continue;
                        \App\Models\Reponse::create([
                            'texte' => $r['texte'],
                            'est_correcte' => isset($r['est_correcte']) && $r['est_correcte'] == '1',
                            'question_id' => $question->id,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('quiz.index')
            ->with('success', 'Quiz créé avec succès.');
    }

    // Affiche le détail d'un quiz 
    public function show(Quiz $quiz)
    {
        $quiz->load('questions.reponses', 'sousChapitre.chapitre.formation');
        return view('quiz.show', compact('quiz'));
    }

    // Affiche le formulaire de modification d'un quiz existant
    public function edit(Quiz $quiz)
    {
        $souschapitres = \App\Models\SousChapitre::all();
        return view('quiz.edit', compact('quiz', 'souschapitres'));
    }

    // Valide les nouvelles données et met à jour le quiz en BDD
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'sous_chapitre_id' => 'required|exists:sous_chapitres,id',
        ]);

        $quiz->update($request->all());

        return redirect()->route('quiz.index')
            ->with('success', 'Quiz mis à jour avec succès.');
    }

    // Supprime le quiz de la BDD
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quiz.index')
            ->with('success', 'Quiz supprimé avec succès.');
    }

    // Affiche la page pour passer le quiz côté apprenant
    public function passer(Quiz $quiz)
    {
        // Charge le quiz avec toutes ses questions et leurs réponses
        $quiz->load('questions.reponses');
        return view('quiz.passer', compact('quiz'));
    }
}