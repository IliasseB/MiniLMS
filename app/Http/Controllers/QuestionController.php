<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Récupère toutes les questions avec leur quiz associé
    public function index()
    {
        $questions = Question::with('quiz')->get();
        return view('questions.index', compact('questions'));
    }

    // Affiche le formulaire de création d'une question
    public function create()
    {
        $quizzes = Quiz::all();
        return view('questions.create', compact('quizzes'));
    }

    // Valide les données du formulaire et enregistre la nouvelle question en BDD
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'quiz_id' => 'required|exists:quiz,id',
        ]);

        Question::create($request->all());

        return redirect()->route('questions.index')
            ->with('success', 'Question créée avec succès.');
    }

    // Affiche le détail d'une question avec ses réponses
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    // Affiche le formulaire de modification d'une question existante
    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('questions.edit', compact('question', 'quizzes'));
    }

    // Valide les nouvelles données et met à jour la question en BDD
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
            'quiz_id' => 'required|exists:quiz,id',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.index')
            ->with('success', 'Question mise à jour avec succès.');
    }

    // Supprime la question de la BDD
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')
            ->with('success', 'Question supprimée avec succès.');
    }
}