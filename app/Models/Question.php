<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question', 'quiz_id'];

    public function quiz()
    {
        // Une question appartient à un quiz
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function reponses()
    {
        // Une question peut avoir plusieurs réponses
        return $this->hasMany(Reponse::class);
    }
}