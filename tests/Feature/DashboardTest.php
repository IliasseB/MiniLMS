<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Apprenant;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_peut_acceder_au_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function apprenant_peut_acceder_au_dashboard()
    {
        $user = User::factory()->create(['role' => 'apprenant']);
        Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function un_invite_ne_peut_pas_acceder_au_dashboard()
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_peut_ajouter_une_todo()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post(route('todos.store'), [
            'texte' => 'Tâche de test',
        ]);

        $this->assertDatabaseHas('todos', [
            'texte' => 'Tâche de test',
            'fait' => false,
        ]);
    }

    /** @test */
    public function admin_peut_cocher_une_todo()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $todo = Todo::create([
            'texte' => 'Tâche à cocher',
            'fait' => false,
        ]);

        $this->actingAs($admin)->patch(route('todos.toggle', $todo));

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'fait' => true,
        ]);
    }

    /** @test */
    public function admin_peut_supprimer_une_todo()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $todo = Todo::create([
            'texte' => 'Tâche à supprimer',
            'fait' => false,
        ]);

        $this->actingAs($admin)->delete(route('todos.destroy', $todo));

        $this->assertDatabaseMissing('todos', [
            'texte' => 'Tâche à supprimer',
        ]);
    }
}