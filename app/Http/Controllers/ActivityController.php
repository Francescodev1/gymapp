<?php

// App\Http\Controllers\ActivityController.php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'schedule' => 'required|date_format:d/m/Y H:i', // Assicurati che il formato corrisponda al tuo input
        'max_participants' => 'required|integer|min:1'
    ]);

    $activity = new Activity();
    $activity->name = $validatedData['name'];
    $activity->description = $validatedData['description'];
    // Conversione della data
    $activity->schedule = Carbon::createFromFormat('d/m/Y H:i', $validatedData['schedule']);
    $activity->max_participants = $validatedData['max_participants'];
    $activity->save();

    return redirect()->route('somewhere')->with('success', 'Attività salvata con successo!');
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
    $activities = Activity::where('schedule', '>', now())
                            ->get()
                            ->filter(function($activity) {
                                return $activity->bookings->count() < $activity->max_participants;
                            });

    // dd($activities); // Rimuovi o commenta questa riga dopo il debugging

    return view('activities.list', compact('activities'));
}

    
}