<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapitre extends Model
{
    protected $fillable = ['titre', 'description', 'formation_id'];

    public function formation()
    {
        // Un chapitre appartient à une formation
        return $this->belongsTo(Formation::class);
    }

    public function souschapitres()
    {
        // Un chapitre peut avoir plusieurs sous-chapitres
        return $this->hasMany(SousChapitre::class);
    }
}