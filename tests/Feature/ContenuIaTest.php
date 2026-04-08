<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\ContenuIa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContenuIaTest extends TestCase
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
    public function admin_peut_importer_un_contenu()
    {
        $admin = $this->adminUser();
        $sousChapitre = $this->creerSousChapitre();

        $this->actingAs($admin)->post(route('contenus-ia.store'), [
            'titre' => 'Contenu Importé Test',
            'contenu' => 'Contenu pédagogique test',
            'source' => 'Claude (Anthropic)',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $this->assertDatabaseHas('contenus_ia', [
            'titre' => 'Contenu Importé Test',
            'source' => 'Claude (Anthropic)',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);
    }

    /** @test */
    public function admin_peut_modifier_un_contenu()
    {
        $admin = $this->adminUser();
        $sousChapitre = $this->creerSousChapitre();

        $contenu = ContenuIa::create([
            'titre' => 'Contenu Original',
            'contenu' => 'Contenu original',
            'source' => 'Claude',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $this->actingAs($admin)->put(route('contenus-ia.update', $contenu), [
            'titre' => 'Contenu Modifié',
            'contenu' => 'Contenu modifié',
            'source' => 'Wikipédia',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $this->assertDatabaseHas('contenus_ia', [
            'titre' => 'Contenu Modifié',
            'source' => 'Wikipédia',
        ]);
    }

    /** @test */
    public function admin_peut_supprimer_un_contenu()
    {
        $admin = $this->adminUser();
        $sousChapitre = $this->creerSousChapitre();

        $contenu = ContenuIa::create([
            'titre' => 'Contenu à Supprimer',
            'contenu' => 'Contenu',
            'source' => 'Claude',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $this->actingAs($admin)->delete(route('contenus-ia.destroy', $contenu));

        $this->assertDatabaseMissing('contenus_ia', [
            'titre' => 'Contenu à Supprimer',
        ]);
    }

    /** @test */
    public function admin_peut_consulter_un_contenu()
    {
        $admin = $this->adminUser();
        $sousChapitre = $this->creerSousChapitre();

        $contenu = ContenuIa::create([
            'titre' => 'Contenu Test',
            'contenu' => 'Contenu pédagogique',
            'source' => 'Claude',
            'sous_chapitre_id' => $sousChapitre->id,
        ]);

        $response = $this->actingAs($admin)->get(route('contenus-ia.show', $contenu));

        $response->assertStatus(200);
        $response->assertSee('Contenu Test');
    }
}