<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    // Afficher toutes les activités
    public function index()
    {
        $activities = Activity::orderBy('activity_date', 'asc')
                             ->orderBy('activity_time', 'asc')
                             ->get();
        
        return view('activities.index', compact('activities'));
    }

    // S'inscrire à une activité
    public function register(Activity $activity)
    {
        $user = Auth::user();
        
        // Vérifier si pas déjà inscrit
        if ($activity->hasUser($user->id)) {
            return redirect()->back()->with('error', 'Vous êtes déjà inscrit à cette activité.');
        }
        
        // Vérifier si pas complet
        if ($activity->isFull()) {
            return redirect()->back()->with('error', 'Cette activité est complète.');
        }

        // Vérifier si assez de points ← NOUVEAU
        if ($user->points < $activity->points_cost) {
            return redirect()->back()->with('error', 'Vous n\'avez pas assez de points.');
        }
        
        // Inscrire l'utilisateur + déduire les points ← NOUVEAU
        DB::transaction(function () use ($activity, $user) {
            $activity->users()->attach($user->id);
            $user->decrement('points', $activity->points_cost);
        });
        
        return redirect()->back()->with('success', 'Inscription confirmée !');
    }

    // Se désinscrire d'une activité
    public function unregister(Activity $activity)
    {
        $user = Auth::user();

        // Désinscrire + rembourser les points ← NOUVEAU
        DB::transaction(function () use ($activity, $user) {
            $activity->users()->detach($user->id);
            $user->increment('points', $activity->points_cost);
        });
        
        return redirect()->back()->with('success', 'Désinscription confirmée. Points remboursés.');
    }
}