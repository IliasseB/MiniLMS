<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultatQuiz extends Model
{
    protected $table = 'resultats_quiz';
    protected $fillable = ['score', 'apprenant_id', 'quiz_id', 'reponses_donnees'];

    public function apprenant()
    {
        // Un résultat de quiz appartient à un apprenant
        return $this->belongsTo(Apprenant::class);
    }

    public function quiz()
    {
        // Un résultat de quiz appartient à un quiz
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}