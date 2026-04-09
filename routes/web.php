<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ChapitreController;
use App\Http\Controllers\SousChapitreController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\ApprenantController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ResultatQuizController;
use App\Http\Controllers\ContenuIaController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\GenerationIaController;

Route::get('/', function () {
    return view('welcome');
});

// Routes authentification (générées par Breeze)
require __DIR__.'/auth.php';

// Routes protégées
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route génération IA
    Route::get('generation-ia', [GenerationIaController::class, 'index'])->name('generation-ia.index');
    Route::post('generation-ia', [GenerationIaController::class, 'generer'])->name('generation-ia.generer');

    // Routes Admin uniquement
    Route::middleware(['admin'])->group(function () {
        Route::resource('formations', FormationController::class);
        Route::resource('chapitres', ChapitreController::class);
        Route::resource('sous-chapitres', SousChapitreController::class);
        Route::resource('contenus', ContenuController::class);
        Route::resource('apprenants', ApprenantController::class);
        Route::resource('quiz', QuizController::class);
        Route::resource('questions', QuestionController::class);
        Route::resource('reponses', ReponseController::class);
        Route::resource('notes', NoteController::class);
        Route::resource('contenus-ia', ContenuIaController::class)->parameters([
            'contenus-ia' => 'contenuIa'
        ])->except(['index']);

        // Routes Todo
        Route::post('todos', [TodoController::class, 'store'])->name('todos.store');
        Route::patch('todos/{todo}', [TodoController::class, 'toggle'])->name('todos.toggle');
        Route::delete('todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    });

    // Routes Apprenant
    Route::get('mes-formations', [FormationController::class, 'mesFormations'])->name('mes-formations');
    Route::get('mes-notes', [NoteController::class, 'mesNotes'])->name('mes-notes');
    Route::get('quiz/{quiz}/passer', [QuizController::class, 'passer'])->name('quiz.passer');
    Route::post('quiz/{quiz}/soumettre', [ResultatQuizController::class, 'soumettre'])->name('quiz.soumettre');
    Route::get('resultats/{resultatQuiz}', [ResultatQuizController::class, 'show'])->name('resultats.show');
    Route::get('souschapitres/{sousChapitre}/consulter/{page?}', [SousChapitreController::class, 'consulter'])->name('souschapitres.consulter');
});