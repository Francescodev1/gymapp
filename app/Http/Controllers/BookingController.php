<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $bookings = Booking::where('user_id', $userId)->get();
        return view('bookings.index', ['bookings' => $bookings]);
    }

    public function store(Request $request)
    {
        // Valida l'input (ad esempio, assicurati che l'id dell'attività sia presente)
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
        ]);

        // Recupera l'attività e verifica la disponibilità
        $activity = Activity::findOrFail($request->activity_id);
        $availableSeats = $activity->max_participants - $activity->bookings()->count();

        if ($availableSeats > 0) {
            // Se ci sono posti disponibili, crea la prenotazione
            $booking = new Booking();
            $booking->user_id = Auth::id(); // Assicurati che l'utente sia autenticato
            $booking->activity_id = $activity->id;
            $booking->save();

            // Reindirizza con un messaggio di successo
            return redirect()->route('activities.list')->with('success', 'Prenotazione effettuata con successo!');
        } else {
            // Se non ci sono posti disponibili, reindirizza con un messaggio di errore
            return redirect()->back()->with('error', 'Non ci sono posti disponibili per questa attività.');
        }
    }
}
