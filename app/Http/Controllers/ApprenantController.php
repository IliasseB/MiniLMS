<?php

namespace App\Http\Controllers;

use App\Models\Apprenant;
use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApprenantController extends Controller
{
    // Récupère tous les apprenants avec leurs formations associées
    public function index()
    {
        $apprenants = Apprenant::with('formations')->get();
        return view('apprenants.index', compact('apprenants'));
    }

    // Affiche le formulaire de création d'un apprenant
    public function create()
    {
        $formations = Formation::all();
        return view('apprenants.create', compact('formations'));
    }

    // Valide les données, crée le compte user et le profil apprenant en BDD
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'formations' => 'required|array',
            'formations.*' => 'exists:formations,id',
        ]);

        // Crée le compte de connexion
        $user = User::create([
            'name' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'apprenant',
        ]);

        // Crée le profil pédagogique
        $apprenant = Apprenant::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'user_id' => $user->id,
        ]);

        // Attache les formations sélectionnées via la table pivot
        $apprenant->formations()->attach($request->formations);

        return redirect()->route('apprenants.index')
            ->with('success', 'Apprenant créé avec succès.');
    }

    // Affiche le détail d'un apprenant
    public function show(Apprenant $apprenant)
    {
        return view('apprenants.show', compact('apprenant'));
    }

    // Affiche le formulaire de modification d'un apprenant existant
    public function edit(Apprenant $apprenant)
    {
        $formations = Formation::all();
        return view('apprenants.edit', compact('apprenant', 'formations'));
    }

    // Valide les nouvelles données et met à jour l'apprenant en BDD
    public function update(Request $request, Apprenant $apprenant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $apprenant->user_id,
            'formations' => 'required|array',
            'formations.*' => 'exists:formations,id',
        ]);

        // Met à jour le profil pédagogique
        $apprenant->update([
            'nom' => $request->nom,
            'email' => $request->email,
        ]);

        // Met à jour le compte de connexion
        $apprenant->user->update([
            'name' => $request->nom,
            'email' => $request->email,
        ]);

        // Synchronise les formations (supprime les anciennes et ajoute les nouvelles)
        $apprenant->formations()->sync($request->formations);

        return redirect()->route('apprenants.index')
            ->with('success', 'Apprenant mis à jour avec succès.');
    }

    // Supprime l'apprenant et son compte utilisateur de la BDD
    public function destroy(Apprenant $apprenant)
    {
        $apprenant->user->delete();

        return redirect()->route('apprenants.index')
            ->with('success', 'Apprenant supprimé avec succès.');
    }
}