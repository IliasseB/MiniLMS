<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContenuIa extends Model
{
    protected $table = 'contenus_ia';
    protected $fillable = ['titre', 'contenu', 'source', 'sous_chapitre_id'];

    public function sousChapitre()
    {
        // Un contenu généré par l'IA appartient à un sous-chapitre
        return $this->belongsTo(SousChapitre::class);
    }
}