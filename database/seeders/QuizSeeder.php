<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Reponse;
use App\Models\SousChapitre;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $dixVerbes = SousChapitre::where('titre', '10 verbes indispensables à connaître')->first();

        $quiz = Quiz::create([
            'titre' => 'Quiz - Les verbes irréguliers',
            'sous_chapitre_id' => $dixVerbes->id,
        ]);

        $questions = [
            ['Quel est le prétérit de "go" ?', ['goed', 'went', 'gone', 'goes'], 1],
            ['Quel est le participe passé de "be" ?', ['was', 'being', 'been', 'be'], 2],
            ['Quel est le prétérit de "have" ?', ['haved', 'has', 'had', 'have'], 2],
            ['Quel est le participe passé de "do" ?', ['did', 'does', 'done', 'doing'], 2],
            ['Quel est le prétérit de "make" ?', ['maked', 'made', 'makes', 'making'], 1],
            ['Quel est le participe passé de "take" ?', ['took', 'taked', 'taken', 'taking'], 2],
            ['Quel est le prétérit de "come" ?', ['comed', 'came', 'come', 'coming'], 1],
        ];

        foreach ($questions as [$question, $reponses, $correcte]) {
            $q = Question::create(['question' => $question, 'quiz_id' => $quiz->id]);
            foreach ($reponses as $i => $texte) {
                Reponse::create([
                    'texte' => $texte,
                    'est_correcte' => $i === $correcte,
                    'question_id' => $q->id,
                ]);
            }
        }
    }
}