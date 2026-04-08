<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Apprenant;
use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\Quiz;
use App\Models\ResultatQuiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResultatQuizTest extends TestCase
{
    use RefreshDatabase;

    private function creerQuizEtApprenant()
    {
        $formation = Formation::create([
            'nom' => 'Formation Test',
            'description' => 'Test',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);
        $chapitre = Chapitre::create([
            'titre' => 'Chapitre Test',
            'formation_id' => $formation->id,
        ]);
        $sousChapitre = SousChapitre::create([
            'titre' => 'Sous-chapitre Test',
            'contenu' => 'Contenu test',
            'chapitre_id' => $chapitre->id,
        ]);
        $quiz = Quiz::create([
            'titre' => 'Quiz Test',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);
        $user = User::factory()->create(['role' => 'apprenant']);
        $apprenant = Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);

        return [$quiz, $apprenant, $user];
    }

    /** @test */
    public function un_apprenant_peut_consulter_son_resultat()
    {
        [$quiz, $apprenant, $user] = $this->creerQuizEtApprenant();

        $resultat = ResultatQuiz::create([
            'score' => 5,
            'quiz_id' => $quiz->id,
            'apprenant_id' => $apprenant->id,
            'reponses_donnees' => json_encode([]),
        ]);

        $response = $this->actingAs($user)->get(route('resultats.show', $resultat));

        $response->assertStatus(200);
        $response->assertSee('Quiz Test');
    }

    /** @test */
    public function le_score_est_bien_enregistre_apres_soumission()
    {
        [$quiz, $apprenant, $user] = $this->creerQuizEtApprenant();

        $this->actingAs($user)->post(route('quiz.soumettre', $quiz), [
            'reponses' => [1 => 1],
        ]);

        $this->assertDatabaseHas('resultats_quiz', [
            'quiz_id' => $quiz->id,
            'apprenant_id' => $apprenant->id,
        ]);
    }

    /** @test */
    public function admin_peut_consulter_le_resultat_dun_apprenant()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        [$quiz, $apprenant, $user] = $this->creerQuizEtApprenant();

        $resultat = ResultatQuiz::create([
            'score' => 3,
            'quiz_id' => $quiz->id,
            'apprenant_id' => $apprenant->id,
            'reponses_donnees' => json_encode([]),
        ]);

        $response = $this->actingAs($admin)->get(route('resultats.show', $resultat));

        $response->assertStatus(200);
        $response->assertSee('Will Smith');
    }
}