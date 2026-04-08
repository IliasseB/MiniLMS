<?php

namespace Database\Seeders;

use App\Models\Apprenant;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApprenantSeeder extends Seeder
{
    public function run()
    {
        $anglais = Formation::where('nom', 'Anglais - Verbes irréguliers')->first();

        // Will Smith
        $userWill = User::create([
            'name' => 'Will Smith',
            'email' => 'will@lms.fr',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
        ]);
        $will = Apprenant::create([
            'nom' => 'Will Smith',
            'email' => 'will@lms.fr',
            'user_id' => $userWill->id,
        ]);
        $will->formations()->attach([$anglais->id]);

        // Iliasse Bellouch
        $userIliasse = User::create([
            'name' => 'Iliasse Bellouch',
            'email' => 'iliasse@lms.fr',
            'password' => Hash::make('password'),
            'role' => 'apprenant',
        ]);
        $iliasse = Apprenant::create([
            'nom' => 'Iliasse Bellouch',
            'email' => 'iliasse@lms.fr',
            'user_id' => $userIliasse->id,
        ]);
        $iliasse->formations()->attach([$anglais->id]);
    }
}