<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Apprenant;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser()
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function creerApprenant()
    {
        $user = User::factory()->create(['role' => 'apprenant']);
        return Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function admin_peut_voir_la_liste_des_notes()
    {
        $admin = $this->adminUser();
        $apprenant = $this->creerApprenant();

        Note::create([
            'matiere' => 'Anglais',
            'note' => 15.5,
            'apprenant_id' => $apprenant->id,
        ]);

        $response = $this->actingAs($admin)->get(route('notes.index'));

        $response->assertStatus(200);
        $response->assertSee('Anglais');
    }

    /** @test */
    public function admin_peut_creer_une_note()
    {
        $admin = $this->adminUser();
        $apprenant = $this->creerApprenant();

        $this->actingAs($admin)->post(route('notes.store'), [
            'matiere' => 'Mathématiques',
            'note' => 14.25,
            'apprenant_id' => $apprenant->id,
        ]);

        $this->assertDatabaseHas('notes', [
            'matiere' => 'Mathématiques',
            'note' => 14.25,
            'apprenant_id' => $apprenant->id,
        ]);
    }

    /** @test */
    public function admin_peut_modifier_une_note()
    {
        $admin = $this->adminUser();
        $apprenant = $this->creerApprenant();

        $note = Note::create([
            'matiere' => 'Anglais',
            'note' => 12.0,
            'apprenant_id' => $apprenant->id,
        ]);

        $this->actingAs($admin)->put(route('notes.update', $note), [
            'matiere' => 'Anglais',
            'note' => 16.75,
            'apprenant_id' => $apprenant->id,
        ]);

        $this->assertDatabaseHas('notes', [
            'note' => 16.75,
        ]);
    }

    /** @test */
    public function admin_peut_supprimer_une_note()
    {
        $admin = $this->adminUser();
        $apprenant = $this->creerApprenant();

        $note = Note::create([
            'matiere' => 'Note à Supprimer',
            'note' => 10.0,
            'apprenant_id' => $apprenant->id,
        ]);

        $this->actingAs($admin)->delete(route('notes.destroy', $note));

        $this->assertDatabaseMissing('notes', [
            'matiere' => 'Note à Supprimer',
        ]);
    }

    /** @test */
    public function un_apprenant_peut_voir_ses_notes()
    {
        $user = User::factory()->create(['role' => 'apprenant']);
        $apprenant = Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $user->id,
        ]);

        Note::create([
            'matiere' => 'Anglais',
            'note' => 15.5,
            'apprenant_id' => $apprenant->id,
        ]);

        $response = $this->actingAs($user)->get(route('mes-notes'));

        $response->assertStatus(200);
        $response->assertSee('15.5');
    }
}