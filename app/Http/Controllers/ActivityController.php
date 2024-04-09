<?php

// App\Http\Controllers\ActivityController.php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
{
    $activities = Activity::all();
    return view('activities.index', compact('activities'));
}

// Mostra il form di creazione
public function create()
{
    return view('activities.create');
}

// Salva la nuova attività nel database
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'schedule' => 'required|string',
        'max_participants' => 'required|integer|min:1'
    ]);

    Activity::create($request->all());
    
    return redirect()->route('activities.index')
                     ->with('success', 'Attività aggiunta con successo.');
}


// Mostra il form di modifica
public function edit(Activity $activity)
{
    return view('activities.edit', compact('activity'));
}

// Aggiorna l'attività nel database
public function update(Request $request, Activity $activity)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'schedule' => 'required|string',
        'max_participants' => 'required|integer|min:1'
    ]);

    $activity->update($request->all());
    
    return redirect()->route('activities.index')->with('success', 'Attività aggiornata con successo.');
}


public function destroy(Activity $activity)
{
    $activity->delete();
    
    return redirect()->route('activities.index')
                     ->with('success', 'Attività eliminata con successo.');
}




public function list()
{
    // Supponiamo di voler mostrare solo le attività future con posti disponibili
    $activities = Activity::where('schedule', '>', now())
                            ->get()
                            ->filter(function($activity) {
                                return $activity->bookings->count() < $activity->max_participants;
                            });

    return view('activities.list', compact('activities'));
}

    
}