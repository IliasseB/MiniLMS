<?php

namespace Database\Seeders;

use App\Models\Chapitre;
use App\Models\Formation;
use Illuminate\Database\Seeder;

class ChapitreSeeder extends Seeder
{
    public function run()
    {
        $anglais = Formation::where('nom', 'Anglais - Verbes irréguliers')->first();

        Chapitre::create([
            'titre' => 'Les verbes irréguliers',
            'description' => 'Comprendre et maîtriser les verbes irréguliers anglais.',
            'formation_id' => $anglais->id,
        ]);
    }
}