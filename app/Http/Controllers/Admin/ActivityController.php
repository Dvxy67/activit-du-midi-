<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // Liste toutes les activités
    public function index()
    {
        $activities = Activity::orderBy('activity_date', 'asc')->get();
        return view('admin.activities.index', compact('activities'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.activities.create');
    }

    // Enregistre une nouvelle activité
    public function store(Request $request)
    {
        $validated = $request->validate([ 
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'activity_date'    => 'required|date',
            'activity_time'    => 'required',
            'max_participants' => 'required|integer|min:1',
            'points_cost'      => 'required|integer|min:0',
        ]);

        Activity::create($validated);

        return redirect()->route('admin.activities.index')
                         ->with('success', 'Activité créée avec succès.');
    }

    // Affiche le formulaire de modification
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    // Enregistre les modifications
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'activity_date'    => 'required|date',
            'activity_time'    => 'required',
            'max_participants' => 'required|integer|min:1',
            'points_cost'      => 'required|integer|min:0',
        ]);

        $activity->update($request->validated());

        return redirect()->route('admin.activities.index')
                         ->with('success', 'Activité mise à jour.');
    }

    // Supprime une activité
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route('admin.activities.index')
                         ->with('success', 'Activité supprimée.');
    }
}