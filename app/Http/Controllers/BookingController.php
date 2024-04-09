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
        $validated = $request->validate([
            'activity_id' => 'required|exists:activities,id',
        ]);

        $activity = Activity::findOrFail($request->activity_id);
        $availableSeats = $activity->max_participants - $activity->bookings()->count();

        if ($availableSeats > 0) {
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->activity_id = $activity->id;
            $booking->status = 'confirmed'; // Imposta lo stato iniziale
            $booking->save();

            return redirect()->route('activities.list')->with('success', 'Prenotazione effettuata con successo!');
        } else {
            return redirect()->back()->with('error', 'Non ci sono posti disponibili per questa attività.');
        }
    }

    public function changeStatus(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if (Auth::id() !== $booking->user_id && !Auth::user()->isAdmin) {
            // Assumi che isAdmin sia un attributo o un metodo sul tuo modello User che indica se l'utente è amministratore.
            return back()->with('error', 'Non sei autorizzato a modificare questa prenotazione.');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,canceled,pending',
        ]);

        $booking->status = $validated['status'];
        $booking->save();

        return back()->with('success', 'Stato della prenotazione aggiornato con successo.');
    }
}
