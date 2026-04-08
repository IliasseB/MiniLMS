<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\Apprenant;
use App\Models\ResultatQuiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function creerSousChapitre()
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

        return SousChapitre::create([
            'titre' => 'Sous-chapitre Test',
            'contenu' => 'Contenu test',
            'chapitre_id' => $chapitre->id,
        ]);
    }

    /** @test */
    public function admin_peut_voir_la_liste_des_quiz()
    {
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)->get(route('quiz.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_peut_creer_un_quiz()
    {
        $admin = $this->adminUser();
        $sousChapitre = $this->creerSousChapitre();

        $response = $this->actingAs($admin)->post(route('quiz.store'), [
            'titre' => 'Quiz Test',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $response->assertRedirect(route('quiz.index'));
        $this->assertDatabaseHas('quiz', [
            'titre' => 'Quiz Test',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);
    }

    /** @test */
    public function admin_peut_supprimer_un_quiz()
    {
        $admin = $this->adminUser();
        $sousChapitre = $this->creerSousChapitre();

        $quiz = Quiz::create([
            'titre' => 'Quiz à Supprimer',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $response = $this->actingAs($admin)->delete(route('quiz.destroy', $quiz));

        $response->assertRedirect(route('quiz.index'));
        $this->assertDatabaseMissing('quiz', [
            'titre' => 'Quiz à Supprimer',
        ]);
    }

    /** @test */
    public function un_apprenant_peut_passer_un_quiz()
    {
        $sousChapitre = $this->creerSousChapitre();

        $quiz = Quiz::create([
            'titre' => 'Quiz Test',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $user = User::factory()->create(['role' => 'apprenant']);
        Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('quiz.passer', $quiz));

        $response->assertStatus(200);
    }

    /** @test */
    public function un_apprenant_peut_soumettre_un_quiz()
    {
        $sousChapitre = $this->creerSousChapitre();

        $quiz = Quiz::create([
            'titre' => 'Quiz Test',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $user = User::factory()->create(['role' => 'apprenant']);
        Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route('quiz.soumettre', $quiz), [
            'reponses' => [1 => 1],
        ]);

        // Vérifie que la soumission a bien été enregistrée
        $this->assertDatabaseHas('resultats_quiz', [
            'quiz_id' => $quiz->id,
        ]);
    }
}