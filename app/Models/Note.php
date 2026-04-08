<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['note', 'matiere', 'apprenant_id'];

    public function apprenant()
    {
        // Une note appartient à un apprenant
        return $this->belongsTo(Apprenant::class);
    }
}