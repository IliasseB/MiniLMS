<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apprenant extends Model
{
    protected $fillable = ['nom', 'email', 'user_id'];

    public function formations()
    {
        // Many-to-many : un apprenant peut avoir plusieurs formations
        return $this->belongsToMany(Formation::class, 'apprenant_formation');
    }

    public function user()
    {
        // Un apprenant est lié à un utilisateur
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        // Un apprenant peut avoir plusieurs notes
        return $this->hasMany(Note::class);
    }

    public function resultatsQuiz()
    {
        // Un apprenant peut avoir plusieurs résultats de quiz
        return $this->hasMany(ResultatQuiz::class);
    }
}