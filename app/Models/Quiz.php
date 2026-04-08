<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    // Force Laravel à utiliser "quiz" comme nom de table au lieu de "quizzes"
    protected $table = 'quiz';
    
    protected $fillable = ['titre', 'sous_chapitre_id'];

    public function sousChapitre()
    {
        // Un quiz appartient à un sous-chapitre
        return $this->belongsTo(SousChapitre::class);
    }

    public function questions()
    {
        // Un quiz peut avoir plusieurs questions
        return $this->hasMany(Question::class);
    }

    public function resultatsQuiz()
    {
        // Un quiz peut avoir plusieurs résultats de quiz
        return $this->hasMany(ResultatQuiz::class);
    }
}