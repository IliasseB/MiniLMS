<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    protected $fillable = ['texte', 'est_correcte', 'question_id'];

    public function question()
    {
        // Une réponse appartient à une question
        return $this->belongsTo(Question::class);
    }
}