<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SousChapitreTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function creerChapitre()
    {
        $formation = Formation::create([
            'nom' => 'Formation Test',
            'description' => 'Test',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);

        return Chapitre::create([
            'titre' => 'Chapitre Test',
            'formation_id' => $formation->id,
        ]);
    }

    /** @test */
    public function admin_peut_voir_la_liste_des_sous_chapitres()
    {
        $admin = $this->adminUser();
        $chapitre = $this->creerChapitre();

        SousChapitre::create([
            'titre' => 'Sous-chapitre Test',
            'contenu' => 'Contenu test',
            'chapitre_id' => $chapitre->id,
        ]);

        $response = $this->actingAs($admin)->get(route('sous-chapitres.index'));

        $response->assertStatus(200);
        $response->assertSee('Sous-chapitre Test');
    }

    /** @test */
    public function admin_peut_creer_un_sous_chapitre()
    {
        $admin = $this->adminUser();
        $chapitre = $this->creerChapitre();

        $this->actingAs($admin)->post(route('sous-chapitres.store'), [
            'titre' => 'Nouveau Sous-chapitre',
            'contenu' => 'Contenu du sous-chapitre',
            'chapitre_id' => $chapitre->id,
        ]);

        $this->assertDatabaseHas('sous_chapitres', [
            'titre' => 'Nouveau Sous-chapitre',
            'chapitre_id' => $chapitre->id,
        ]);
    }

    /** @test */
    public function admin_peut_modifier_un_sous_chapitre()
    {
        $admin = $this->adminUser();
        $chapitre = $this->creerChapitre();

        $sousChapitre = SousChapitre::create([
            'titre' => 'Sous-chapitre Original',
            'contenu' => 'Contenu original',
            'chapitre_id' => $chapitre->id,
        ]);

        $this->actingAs($admin)->put(route('sous-chapitres.update', $sousChapitre), [
            'titre' => 'Sous-chapitre Modifié',
            'contenu' => 'Contenu modifié',
            'chapitre_id' => $chapitre->id,
        ]);

        $this->assertDatabaseHas('sous_chapitres', [
            'titre' => 'Sous-chapitre Modifié',
        ]);
    }

    /** @test */
    public function admin_peut_supprimer_un_sous_chapitre()
    {
        $admin = $this->adminUser();
        $chapitre = $this->creerChapitre();

        $sousChapitre = SousChapitre::create([
            'titre' => 'Sous-chapitre à Supprimer',
            'contenu' => 'Contenu',
            'chapitre_id' => $chapitre->id,
        ]);

        $this->actingAs($admin)->delete(route('sous-chapitres.destroy', $sousChapitre));

        $this->assertDatabaseMissing('sous_chapitres', [
            'titre' => 'Sous-chapitre à Supprimer',
        ]);
    }

    /** @test */
    public function un_apprenant_peut_consulter_un_sous_chapitre()
    {
        $chapitre = $this->creerChapitre();

        $sousChapitre = SousChapitre::create([
            'titre' => 'Sous-chapitre Test',
            'contenu' => 'Contenu test',
            'chapitre_id' => $chapitre->id,
        ]);

        $user = User::factory()->create(['role' => 'apprenant']);

        $response = $this->actingAs($user)->get(route('souschapitres.consulter', $sousChapitre));

        $response->assertStatus(200);
        $response->assertSee('Sous-chapitre Test');
    }
}