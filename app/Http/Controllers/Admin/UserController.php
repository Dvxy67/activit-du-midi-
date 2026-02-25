<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Liste tous les utilisateurs
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    // Met à jour le solde de points d'un utilisateur
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'points' => 'required|integer|min:0',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'Solde de points mis à jour.');
    }
}