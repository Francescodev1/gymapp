<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
{
    if (auth()->user()->is_admin) {
        $sortBy = $request->query('sort', 'created_at');
        $order = $request->query('order', 'asc');

        // Modifica qui per gestire l'ordinamento basato sul nome dell'attività
        if ($sortBy === 'activities.name') {
            $bookings = Booking::with(['user', 'activity'])
                            ->join('activities', 'activities.id', '=', 'bookings.activity_id')
                            ->orderBy('activities.name', $order) // Usa il nome qualificato della colonna
                            ->select('bookings.*', 'activities.name as activity_name') // Evita conflitti di colonne selezionando quelle necessarie
                            ->get();
        } else {
            $bookings = Booking::with(['user', 'activity'])
                            ->orderBy($sortBy, $order)
                            ->get();
        }

        return view('bookings.admin_index', compact('bookings'));
    } else {
        // Logica per utente standard
        $userId = auth()->id();
        $bookings = Booking::where('user_id', $userId)->with('activity')->get();

        return view('bookings.user_index', compact('bookings'));
    }
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
            $booking->status = 'pending'; // Imposta lo stato iniziale
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



    public function destroy(Booking $booking)
    {
        // Verifica che l'utente autenticato sia l'utente che ha effettuato la prenotazione
        if ($booking->user_id == auth()->id()) {
            // Elimina la prenotazione
            $booking->delete();

            // Reindirizza l'utente a una pagina di conferma o alla pagina delle attività
            return back()->with('success', 'Stato della prenotazione aggiornato con successo.');
        } else {
            // Se l'utente non è autorizzato, puoi restituire un messaggio di errore o reindirizzarlo altrove
            return redirect()->route('bookings.index')->with('error', 'Non sei autorizzato ad annullare questa prenotazione.');
        }
    }
}
