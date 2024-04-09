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
        'date' => 'required|date_format:Y-m-d',

        'time' => 'required|string', // Aggiunto per l'orario
        'max_participants' => 'required|integer|min:1'
    ]);

    $activity = new Activity();
    $activity->name = $validatedData['name'];
    $activity->description = $validatedData['description'];
    $activity->date = $validatedData['date']; // Assegnato direttamente
    $activity->time = $validatedData['time']; // Assegnato direttamente
    $activity->max_participants = $validatedData['max_participants'];
    $activity->save();

    return redirect()->route('activities.index')->with('success', 'Attività salvata con successo!');
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
        'date' => 'required|date_format:Y-m-d',
        'time' => 'required|string',
        'max_participants' => 'required|integer|min:1'
    ]);

    // Aggiorna direttamente l'attività con i dati validati
    $activity->update([
        'name' => $request->name,
        'description' => $request->description,
        'date' => $request->date,
        'time' => $request->time,
        'max_participants' => $request->max_participants,
    ]);

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
    // Ottieni la data corrente in formato Y-m-d per confrontarla con la colonna `date`
    $today = Carbon::now()->format('Y-m-d');

    // Filtra le attività future basate sulla nuova struttura
    $activities = Activity::where('date', '>=', $today)
        ->get()
        ->filter(function($activity) {
            // Qui puoi aggiungere ulteriori filtri, ad esempio, controllare l'orario se necessario
            return $activity->bookings->count() < $activity->max_participants;
        });

    return view('activities.list', compact('activities'));
}


    
}