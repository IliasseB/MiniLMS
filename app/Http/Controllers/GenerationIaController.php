<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\ContenuIa;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GenerationIaController extends Controller
{
    public function index()
    {
        return view('generation-ia.index');
    }

    private function appelerIA(Client $client, string $prompt, int $tentative = 0): ?array
    {
        sleep($tentative === 0 ? 2 : 5 * $tentative);

        try {
            $response = $client->post('https://api.mistral.ai/v1/chat/completions', [
                'verify' => false,
                'timeout' => 180,
                'connect_timeout' => 10,
                'headers' => [
                    'Authorization' => 'Bearer ' . env('MISTRAL_API_KEY'),
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'mistral-small-latest',
                    'max_tokens' => 8000,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ]
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $texte = $body['choices'][0]['message']['content'] ?? '';

            // Nettoie le JSON
            $texte = preg_replace('/```json\s*/i', '', $texte);
            $texte = preg_replace('/```\s*/i', '', $texte);
            $texte = trim($texte);

            $data = json_decode($texte, true);

            if (is_array($data) && isset($data[0])) {
                $data = $data[0];
            }

            if (isset($data['contenu']) && is_array($data['contenu'])) {
                $data['contenu'] = $this->convertirContenuEnTexte($data['contenu']);
            }

            return $data;

        } catch (\Exception $e) {
            if ($tentative < 3) {
                if (str_contains($e->getMessage(), '429')) {
                    sleep(30);
                }
                return $this->appelerIA($client, $prompt, $tentative + 1);
            }
            throw $e;
        }
    }

    private function convertirContenuEnTexte(array $contenu): string
    {
        $texte = '';
        array_walk_recursive($contenu, function($valeur, $cle) use (&$texte) {
            if (is_string($valeur) && strlen($valeur) > 10) {
                $texte .= $valeur . "\n\n";
            }
        });
        return trim($texte);
    }

    public function generer(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        $request->validate([
            'prompt' => 'required|string|min:10',
        ]);

        $client = new Client();

        try {
            // ÉTAPE 1 : Générer la structure
            $promptStructure = "Tu es un assistant pédagogique expert. Génère UNIQUEMENT la structure d'un cours en JSON (titres seulement, sans contenu). Respecte STRICTEMENT le nombre de chapitres et sous-chapitres demandés. Réponds UNIQUEMENT en JSON valide sans texte avant ou après.

Structure :
{
  \"formation\": {
    \"nom\": \"Titre de la formation\",
    \"description\": \"Description courte\",
    \"niveau\": \"Débutant|Intermédiaire|Avancé\",
    \"duree\": 10
  },
  \"chapitres\": [
    {
      \"titre\": \"Titre du chapitre\",
      \"sous_chapitres\": [
        { \"titre\": \"Titre du sous-chapitre\" }
      ]
    }
  ]
}

Demande : " . $request->prompt;

            $structure = $this->appelerIA($client, $promptStructure);

            if (!$structure) {
                return back()->with('error', 'La génération de la structure a échoué. Réessayez.');
            }

            $formation = Formation::create([
                'nom' => $structure['formation']['nom'],
                'description' => $structure['formation']['description'],
                'niveau' => $structure['formation']['niveau'],
                'duree' => $structure['formation']['duree'],
            ]);

            foreach ($structure['chapitres'] as $chapitreData) {

                $chapitre = Chapitre::create([
                    'titre' => $chapitreData['titre'],
                    'formation_id' => $formation->id,
                ]);

                $souschapitresCrees = [];

                foreach ($chapitreData['sous_chapitres'] as $scData) {

                    $promptContenu = "Tu es un assistant pédagogique expert. Génère le contenu pour le sous-chapitre indiqué. IMPORTANT : Ne génère PAS de quiz dans le contenu, le quiz sera créé séparément. Le champ 'contenu' doit être UNE SEULE CHAÎNE DE TEXTE (string), pas un objet JSON. Structure le texte avec des titres (##), des listes à puces (-) et des exemples concrets. Réponds UNIQUEMENT en JSON valide sans texte avant ou après.

Structure OBLIGATOIRE :
{
  \"resume\": \"Résumé clair de 3 phrases maximum en texte simple\",
  \"contenu\": \"Texte long formaté avec des sections ## Titre, des listes - item et des exemples. Tout en une seule string. PAS de quiz dedans.\"
}

Contexte :
- Formation : " . $structure['formation']['nom'] . "
- Niveau : " . $structure['formation']['niveau'] . "
- Chapitre : " . $chapitreData['titre'] . "
- Sous-chapitre : " . $scData['titre'] . "
- Instruction : " . $request->prompt;

                    $contenu = $this->appelerIA($client, $promptContenu);

                    \Log::info('Sous-chapitre : ' . $scData['titre'] . ' | Contenu : ' . json_encode($contenu));

                    $sousChapitre = SousChapitre::create([
                        'titre' => $scData['titre'],
                        'contenu' => isset($contenu['resume']) && is_string($contenu['resume'])
                            ? $contenu['resume']
                            : $scData['titre'],
                        'chapitre_id' => $chapitre->id,
                    ]);

                    // Fallback contenu IA
                    $texteContenu = null;

                    if (!empty($contenu['contenu']) && is_string($contenu['contenu'])) {
                        $texteContenu = $contenu['contenu'];
                    } elseif (!empty($contenu['resume']) && is_string($contenu['resume'])) {
                        $texteContenu = $contenu['resume'];
                    } else {
                        $texteContenu = "L'IA a rencontré quelques problèmes dans la réalisation du contenu, complétez-le manuellement.";
                    }

                    ContenuIa::create([
                        'titre' => $scData['titre'],
                        'contenu' => $texteContenu,
                        'source' => 'IA — Généré automatiquement',
                        'sous_chapitre_id' => $sousChapitre->id,
                    ]);

                    $souschapitresCrees[] = $sousChapitre;
                }

                // Quiz sur le DERNIER sous-chapitre
                $dernierSousChapitre = end($souschapitresCrees);

                if ($dernierSousChapitre) {
                    $promptQuiz = "Tu es un assistant pédagogique expert. Génère un quiz pour évaluer la compréhension de TOUS les sous-chapitres du chapitre '" . $chapitreData['titre'] . "'. Respecte STRICTEMENT le nombre de questions demandé par l'utilisateur dans son instruction. Les questions doivent couvrir l'ensemble des thèmes abordés. Réponds UNIQUEMENT en JSON valide sans texte avant ou après.

Structure :
{
  \"titre\": \"Quiz - " . $chapitreData['titre'] . "\",
  \"questions\": [
    {
      \"question\": \"Question précise ?\",
      \"reponses\": [
        {\"texte\": \"Bonne réponse\", \"est_correcte\": true},
        {\"texte\": \"Mauvaise réponse\", \"est_correcte\": false},
        {\"texte\": \"Mauvaise réponse\", \"est_correcte\": false},
        {\"texte\": \"Mauvaise réponse\", \"est_correcte\": false}
      ]
    }
  ]
}

Contexte :
- Formation : " . $structure['formation']['nom'] . "
- Chapitre : " . $chapitreData['titre'] . "
- Sous-chapitres couverts : " . implode(', ', array_column($chapitreData['sous_chapitres'], 'titre')) . "
- Instruction originale : " . $request->prompt;

                    $quizData = $this->appelerIA($client, $promptQuiz);

                    if ($quizData && isset($quizData['questions']) && is_array($quizData['questions'])) {
                        $quiz = Quiz::create([
                            'titre' => isset($quizData['titre']) && is_string($quizData['titre'])
                                ? $quizData['titre']
                                : 'Quiz - ' . $chapitreData['titre'],
                            'sous_chapitre_id' => $dernierSousChapitre->id,
                        ]);

                        foreach ($quizData['questions'] as $questionData) {
                            if (!isset($questionData['question']) || !is_string($questionData['question'])) {
                                continue;
                            }

                            $question = Question::create([
                                'question' => $questionData['question'],
                                'quiz_id' => $quiz->id,
                            ]);

                            if (!isset($questionData['reponses']) || !is_array($questionData['reponses'])) {
                                continue;
                            }

                            foreach ($questionData['reponses'] as $reponseData) {
                                if (!isset($reponseData['texte']) || !is_string($reponseData['texte'])) {
                                    continue;
                                }

                                Reponse::create([
                                    'texte' => $reponseData['texte'],
                                    'est_correcte' => $reponseData['est_correcte'] ?? false,
                                    'question_id' => $question->id,
                                ]);
                            }
                        }
                    }
                }
            }

            return redirect()->route('formations.show', $formation)
                ->with('success', 'Formation générée avec succès par l\'IA !');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur API : ' . $e->getMessage());
        }
    }
}