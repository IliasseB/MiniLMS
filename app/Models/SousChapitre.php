<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousChapitre extends Model
{
    protected $fillable = ['titre', 'contenu', 'chapitre_id'];

    public function chapitre()
    {
        // Un sous-chapitre appartient à un chapitre
        return $this->belongsTo(Chapitre::class);
    }

    public function contenus()
    {
        // Un sous-chapitre peut avoir plusieurs contenus
        return $this->hasMany(Contenu::class);
    }

    public function quiz()
    {
        // Un sous-chapitre peut avoir un quiz
        return $this->hasOne(Quiz::class);
    }

    public function contenusIa()
    {
        // Un sous-chapitre peut avoir plusieurs contenus générés par l'IA
        return $this->hasMany(ContenuIa::class);
    }
}