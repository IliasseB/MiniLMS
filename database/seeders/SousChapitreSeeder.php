<?php

namespace Database\Seeders;

use App\Models\Chapitre;
use App\Models\SousChapitre;
use Illuminate\Database\Seeder;

class SousChapitreSeeder extends Seeder
{
    public function run()
    {
        $chapitre = Chapitre::where('titre', 'Les verbes irréguliers')->first();

        SousChapitre::create([
            'titre' => 'Définition et présentation',
            'contenu' => "Un verbe irrégulier est un verbe qui ne forme pas son prétérit et son participe passé selon la règle standard qui consiste à ajouter \"-ed\" à la base verbale.\n\nEn anglais, la majorité des verbes sont réguliers :\n- Work → worked → worked\n- Play → played → played\n\nLes verbes irréguliers ont des formes uniques à mémoriser :\n- Go → went → gone\n- Be → was/were → been\n- Have → had → had\n\nIl existe environ 200 verbes irréguliers fréquemment utilisés en anglais. Ils sont incontournables car ce sont souvent les verbes les plus courants de la langue (être, avoir, faire, aller, venir, prendre...).\n\nAstuce : Les verbes irréguliers se regroupent souvent par familles de sons similaires :\n- Ring → rang → rung\n- Sing → sang → sung\n- Drink → drank → drunk",
            'chapitre_id' => $chapitre->id,
        ]);

        SousChapitre::create([
            'titre' => '10 verbes indispensables à connaître',
            'contenu' => "Voici les 10 verbes irréguliers les plus utilisés en anglais. Maîtriser ces verbes vous permettra de communiquer dans la grande majorité des situations courantes.\n\n1. BE (être)      → was/were → been\n2. HAVE (avoir)   → had      → had\n3. DO (faire)     → did      → done\n4. GO (aller)     → went     → gone\n5. GET (obtenir)  → got      → got/gotten\n6. MAKE (créer)   → made     → made\n7. KNOW (savoir)  → knew     → known\n8. THINK (penser) → thought  → thought\n9. TAKE (prendre) → took     → taken\n10. COME (venir)  → came     → come",
            'chapitre_id' => $chapitre->id,
        ]);

        SousChapitre::create([
            'titre' => 'Méthode de mémorisation',
            'contenu' => "Mémoriser les verbes irréguliers peut sembler difficile, mais avec les bonnes techniques, c'est tout à fait accessible !\n\nLes 5 méthodes clés :\n1. La méthode des groupes (familles de sons)\n2. La répétition espacée\n3. Les flashcards\n4. La contextualisation (phrases complètes)\n5. Les chansons et vidéos",
            'chapitre_id' => $chapitre->id,
        ]);
    }
}