<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Formation;
use App\Models\Chapitre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChapitreTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function creerFormation()
    {
        return Formation::create([
            'nom' => 'Formation Test',
            'description' => 'Test',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);
    }

    /** @test */
    public function admin_peut_voir_la_liste_des_chapitres()
    {
        $admin = $this->adminUser();
        $formation = $this->creerFormation();

        Chapitre::create([
            'titre' => 'Chapitre Test',
            'formation_id' => $formation->id,
        ]);

        $response = $this->actingAs($admin)->get(route('chapitres.index'));

        $response->assertStatus(200);
        $response->assertSee('Chapitre Test');
    }

    /** @test */
    public function admin_peut_creer_un_chapitre()
    {
        $admin = $this->adminUser();
        $formation = $this->creerFormation();

        $this->actingAs($admin)->post(route('chapitres.store'), [
            'titre' => 'Nouveau Chapitre',
            'formation_id' => $formation->id,
        ]);

        $this->assertDatabaseHas('chapitres', [
            'titre' => 'Nouveau Chapitre',
            'formation_id' => $formation->id,
        ]);
    }

    /** @test */
    public function admin_peut_modifier_un_chapitre()
    {
        $admin = $this->adminUser();
        $formation = $this->creerFormation();

        $chapitre = Chapitre::create([
            'titre' => 'Chapitre Original',
            'formation_id' => $formation->id,
        ]);

        $this->actingAs($admin)->put(route('chapitres.update', $chapitre), [
            'titre' => 'Chapitre Modifié',
            'formation_id' => $formation->id,
        ]);

        $this->assertDatabaseHas('chapitres', [
            'titre' => 'Chapitre Modifié',
        ]);
    }

    /** @test */
    public function admin_peut_supprimer_un_chapitre()
    {
        $admin = $this->adminUser();
        $formation = $this->creerFormation();

        $chapitre = Chapitre::create([
            'titre' => 'Chapitre à Supprimer',
            'formation_id' => $formation->id,
        ]);

        $this->actingAs($admin)->delete(route('chapitres.destroy', $chapitre));

        $this->assertDatabaseMissing('chapitres', [
            'titre' => 'Chapitre à Supprimer',
        ]);
    }
}