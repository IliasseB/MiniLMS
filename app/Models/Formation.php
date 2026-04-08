<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = ['nom', 'description', 'niveau', 'duree'];

    public function chapitres()
    {
        // Une formation peut avoir plusieurs chapitres
        return $this->hasMany(Chapitre::class);
    }

    public function apprenants()
    {
        // Many-to-many : une formation peut avoir plusieurs apprenants
        return $this->belongsToMany(Apprenant::class, 'apprenant_formation');
    }
}