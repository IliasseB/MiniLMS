<?php

namespace Database\Seeders;

use App\Models\Apprenant;
use App\Models\Note;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run()
    {
        $will = Apprenant::where('email', 'will@lms.fr')->first();
        $iliasse = Apprenant::where('email', 'iliasse@lms.fr')->first();

        Note::create(['matiere' => 'Anglais - Verbes irréguliers', 'note' => 15.5, 'apprenant_id' => $will->id]);
        Note::create(['matiere' => 'Compréhension écrite', 'note' => 12, 'apprenant_id' => $will->id]);

        Note::create(['matiere' => 'Anglais - Verbes irréguliers', 'note' => 18, 'apprenant_id' => $iliasse->id]);
        Note::create(['matiere' => 'Compréhension écrite', 'note' => 16.5, 'apprenant_id' => $iliasse->id]);
    }
}