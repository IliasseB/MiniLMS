<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            FormationSeeder::class,
            ChapitreSeeder::class,
            SousChapitreSeeder::class,
            ContenuIaSeeder::class,
            ApprenantSeeder::class,
            NoteSeeder::class,
            QuizSeeder::class,
        ]);
    }
}