<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Formation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormationTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_peut_voir_la_liste_des_formations()
    {
        $admin = $this->adminUser();

        Formation::create([
            'nom' => 'Anglais - Verbes irréguliers',
            'description' => 'Formation test',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);

        $response = $this->actingAs($admin)->get(route('formations.index'));

        $response->assertStatus(200);
        $response->assertSee('Anglais - Verbes irréguliers');
    }

    /** @test */
    public function admin_peut_creer_une_formation()
    {
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)->post(route('formations.store'), [
            'nom' => 'Nouvelle Formation Test',
            'description' => 'Description test',
            'niveau' => 'Débutant',
            'duree' => 15,
        ]);

        $response->assertRedirect(route('formations.index'));
        $this->assertDatabaseHas('formations', [
            'nom' => 'Nouvelle Formation Test',
        ]);
    }

    /** @test */
    public function admin_peut_modifier_une_formation()
    {
        $admin = $this->adminUser();

        $formation = Formation::create([
            'nom' => 'Formation Originale',
            'description' => 'Description',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);

        $response = $this->actingAs($admin)->put(route('formations.update', $formation), [
            'nom' => 'Formation Modifiée',
            'description' => 'Nouvelle description',
            'niveau' => 'Intermédiaire',
            'duree' => 20,
        ]);

        $response->assertRedirect(route('formations.index'));
        $this->assertDatabaseHas('formations', [
            'nom' => 'Formation Modifiée',
        ]);
    }

    /** @test */
    public function admin_peut_supprimer_une_formation()
    {
        $admin = $this->adminUser();

        $formation = Formation::create([
            'nom' => 'Formation à Supprimer',
            'description' => 'Description',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);

        $response = $this->actingAs($admin)->delete(route('formations.destroy', $formation));

        $response->assertRedirect(route('formations.index'));
        $this->assertDatabaseMissing('formations', [
            'nom' => 'Formation à Supprimer',
        ]);
    }

    /** @test */
    public function un_invité_ne_peut_pas_accéder_aux_formations()
    {
        $response = $this->get(route('formations.index'));
        $response->assertRedirect(route('login'));
    }
}