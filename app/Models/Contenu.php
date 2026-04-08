<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    protected $fillable = ['titre', 'texte', 'lien_ressource', 'sous_chapitre_id'];

    public function sousChapitre()
    {
        // Un contenu appartient à un sous-chapitre
        return $this->belongsTo(SousChapitre::class);
    }
}