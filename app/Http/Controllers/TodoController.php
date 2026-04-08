<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // Ajoute une nouvelle tâche
    public function store(Request $request)
    {
        $request->validate(['texte' => 'required|string|max:255']);
        Todo::create(['texte' => $request->texte, 'fait' => false]);
        return redirect()->route('dashboard')->with('success', 'Tâche ajoutée.');
    }

    // Bascule l'état fait/pas fait
    public function toggle(Todo $todo)
    {
        $todo->update(['fait' => !$todo->fait]);
        return redirect()->route('dashboard');
    }

    // Supprime la tâche
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('dashboard');
    }
}