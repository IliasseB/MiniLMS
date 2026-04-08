<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Apprenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApprenantTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /** @test */
    public function admin_peut_voir_la_liste_des_apprenants()
    {
        $admin = $this->adminUser();

        $user = User::factory()->create(['role' => 'apprenant']);
        Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->get(route('apprenants.index'));

        $response->assertStatus(200);
        $response->assertSee('Will Smith');
    }

    /** @test */
    public function admin_peut_creer_un_apprenant()
    {
        $admin = $this->adminUser();

        $formation = \App\Models\Formation::create([
            'nom' => 'Formation Test',
            'description' => 'Test',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);

        $this->actingAs($admin)->post(route('apprenants.store'), [
            'nom' => 'Test Apprenant',
            'email' => 'test@lms.fr',
            'password' => 'password',
            'password_confirmation' => 'password',
            'formations' => [$formation->id],
        ]);

        $this->assertDatabaseHas('apprenants', [
            'nom' => 'Test Apprenant',
            'email' => 'test@lms.fr',
        ]);
    }
    /** @test */
    public function admin_peut_supprimer_un_apprenant()
    {
        $admin = $this->adminUser();

        $user = User::factory()->create(['role' => 'apprenant']);
        $apprenant = Apprenant::create([
            'nom' => 'Apprenant à Supprimer',
            'email' => 'delete@lms.fr',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($admin)->delete(route('apprenants.destroy', $apprenant));

        $response->assertRedirect(route('apprenants.index'));
        $this->assertDatabaseMissing('apprenants', [
            'nom' => 'Apprenant à Supprimer',
        ]);
    }

    /** @test */
    public function un_apprenant_peut_voir_ses_formations()
    {
        $user = User::factory()->create(['role' => 'apprenant']);
        Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('mes-formations'));

        $response->assertStatus(200);
    }

    /** @test */
    public function un_apprenant_ne_peut_pas_acceder_aux_pages_admin()
    {
        $user = User::factory()->create(['role' => 'apprenant']);

        $response = $this->actingAs($user)->get(route('formations.index'));

        // Le middleware admin redirige l'apprenant
        $response->assertRedirect();
    }
}