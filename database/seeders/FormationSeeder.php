<?php

namespace Database\Seeders;

use App\Models\Formation;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    public function run()
    {
        Formation::create([
            'nom' => 'Anglais - Verbes irréguliers',
            'description' => 'Formation complète sur les verbes irréguliers en anglais, avec exercices et quiz.',
            'niveau' => 'Débutant',
            'duree' => 10,
        ]);
    }
}