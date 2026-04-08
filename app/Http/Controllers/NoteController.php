<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Apprenant;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Récupère toutes les notes avec leur apprenant associé
    public function index()
    {
        $notes = Note::with('apprenant')->get();
        return view('notes.index', compact('notes'));
    }

    // Affiche le formulaire de création d'une note
    public function create()
    {
        $apprenants = Apprenant::all();
        return view('notes.create', compact('apprenants'));
    }

    // Valide les données du formulaire et enregistre la nouvelle note en BDD
    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'matiere' => 'required|string|max:255',
            'apprenant_id' => 'required|exists:apprenants,id',
        ]);

        Note::create($request->all());

        return redirect()->route('notes.index')
            ->with('success', 'Note créée avec succès.');
    }

    // Affiche le détail d'une note
    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    // Affiche le formulaire de modification d'une note existante
    public function edit(Note $note)
    {
        $apprenants = Apprenant::all();
        return view('notes.edit', compact('note', 'apprenants'));
    }

    // Valide les nouvelles données et met à jour la note en BDD
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'matiere' => 'required|string|max:255',
            'apprenant_id' => 'required|exists:apprenants,id',
        ]);

        $note->update($request->all());

        return redirect()->route('notes.index')
            ->with('success', 'Note mise à jour avec succès.');
    }

    // Supprime la note de la BDD
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Note supprimée avec succès.');
    }

    // Récupère les notes de l'apprenant connecté
    public function mesNotes()
    {
        // Récupère le profil apprenant lié à l'utilisateur connecté
        $apprenant = auth()->user()->apprenant;

        // Récupère toutes les notes de cet apprenant
        $notes = $apprenant->notes;

        return view('notes.mes-notes', compact('notes'));
    }
}