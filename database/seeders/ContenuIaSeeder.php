<?php

namespace Database\Seeders;

use App\Models\ContenuIa;
use App\Models\SousChapitre;
use Illuminate\Database\Seeder;

class ContenuIaSeeder extends Seeder
{
    public function run()
    {
        $def = SousChapitre::where('titre', 'Définition et présentation')->first();
        $dixVerbes = SousChapitre::where('titre', '10 verbes indispensables à connaître')->first();
        $memo = SousChapitre::where('titre', 'Méthode de mémorisation')->first();

        // Contenus Définition et présentation
        ContenuIa::create([
            'titre' => 'Les verbes irréguliers en anglais — Définition',
            'contenu' => "Un verbe irrégulier est un verbe qui ne forme pas son prétérit et son participe passé selon la règle standard qui consiste à ajouter \"-ed\" à la base verbale.\n\nEn anglais, la majorité des verbes sont réguliers :\n- Work → worked → worked\n- Play → played → played\n\nLes verbes irréguliers ont des formes uniques à mémoriser :\n- Go → went → gone\n- Be → was/were → been\n- Have → had → had\n\nIl existe environ 200 verbes irréguliers fréquemment utilisés en anglais.\n\nAstuce : Les verbes irréguliers se regroupent souvent par familles de sons similaires :\n- Ring → rang → rung\n- Sing → sang → sung\n- Drink → drank → drunk",
            'source' => 'Claude (Anthropic)',
            'sous_chapitre_id' => $def->id,
        ]);

        ContenuIa::create([
            'titre' => 'Tableau des premiers verbes irréguliers anglais',
            'contenu' => "Tableau des premiers verbes irréguliers anglais :\n\nBase verbale | Prétérit | Participe passé | Traduction\nabide | abode | abode | respecter\narise | arose | arisen | survenir\nawake | awoke | awoken | se réveiller\nbe | was/were | been | être\nbear | bore | borne/born | porter/naître\nbeat | beat | beaten | battre\nbecome | became | become | devenir\nbegin | began | begun | commencer\nbite | bit | bitten | mordre\nblow | blew | blown | souffler\nbreak | broke | broken | casser\nbring | brought | brought | apporter\nbuild | built | built | construire\nbuy | bought | bought | acheter\ncatch | caught | caught | attraper",
            'source' => 'Wikipédia',
            'sous_chapitre_id' => $def->id,
        ]);

        // Contenu 10 verbes
        ContenuIa::create([
            'titre' => 'Détail des 10 verbes irréguliers indispensables',
            'contenu' => "Base | Prétérit | Participe passé | Traduction\nbe | was/were | been | être\nhave | had | had | avoir\ndo | did | done | faire\ngo | went | gone | aller\nget | got | got/gotten | obtenir\nmake | made | made | faire/créer\nknow | knew | known | savoir\nthink | thought | thought | penser\ntake | took | taken | prendre\ncome | came | come | venir\n\nExemples d'utilisation :\n\n1. BE : She was happy. / They have been friends for years.\n2. HAVE : He had a car. / I have had enough.\n3. DO : She did her homework. / It is done.\n4. GO : They went to Paris. / She has gone home.\n5. GET : He got the job. / I have got your message.\n6. MAKE : She made a cake. / It was made in France.\n7. KNOW : He knew the answer. / She has known him for years.\n8. THINK : I thought it was easy. / Have you thought about it?\n9. TAKE : She took the bus. / It was taken by mistake.\n10. COME : He came late. / She has come a long way.",
            'source' => 'Claude (Anthropic)',
            'sous_chapitre_id' => $dixVerbes->id,
        ]);

        // Contenu Mémorisation
        ContenuIa::create([
            'titre' => 'Guide complet des méthodes de mémorisation',
            'contenu' => "Guide complet des méthodes de mémorisation des verbes irréguliers :\n\n1. LA MÉTHODE DES GROUPES\nClassez les verbes par familles de sons similaires :\n- Groupe \"i-a-u\" : sing/sang/sung, ring/rang/rung, drink/drank/drunk, swim/swam/swum\n- Groupe \"identiques\" : put/put/put, cut/cut/cut, hit/hit/hit\n- Groupe \"base = participe\" : come/came/come, run/ran/run\n\n2. LA RÉPÉTITION ESPACÉE\nRévisez les verbes à intervalles croissants :\n- Jour 1 : apprenez 10 verbes\n- Jour 2 : révisez les 10 verbes + apprenez 10 nouveaux\n- Jour 4 : révisez les 20 verbes\n- Jour 7 : révision complète\n\n3. LES FLASHCARDS\nCréez des cartes avec :\n- Recto : la base verbale (ex: \"go\")\n- Verso : prétérit + participe passé (ex: \"went / gone\")\n\n4. LA CONTEXTUALISATION\nApprenez les verbes dans des phrases complètes :\n- \"Yesterday I went to school\" plutôt que juste \"go/went/gone\"\n\n5. LES CHANSONS ET VIDÉOS\nDe nombreuses ressources en ligne proposent des chansons et vidéos pour mémoriser les verbes irréguliers de façon ludique.",
            'source' => 'Claude (Anthropic)',
            'sous_chapitre_id' => $memo->id,
        ]);
    }
}