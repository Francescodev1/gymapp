@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow-md rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 font-bold uppercase">
            <h1>Prenotazioni</h1>
        </div>
        <div class="p-6">
            <p>Qui sotto trovi tutte le tue prenotazioni.</p>
            @if($bookings->isEmpty())
                <p class="text-gray-600">Non hai ancora effettuato nessuna prenotazione.</p>
            @else
                <div class="overflow-x-auto mt-6">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    ID Prenotazione
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Utente
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">
                                    <a href="{{ route('bookings.index', ['sort' => 'activities.name', 'order' => 'asc']) }}" class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                     Attività
                                    </a>
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Data e Ora
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Stato
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ $booking->id }}
                                    </td>

                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        {{ $booking->user->name }} (ID: {{ $booking->user->id }})
                                    </td>

                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $booking->activity->name }}</p>
                                    </td>

                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                                {{ \Carbon\Carbon::parse($booking->activity->schedule)->format('d/m/Y H:i') }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{ $booking->status }}</span>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('bookings.changeStatus', ['booking' => $booking->id]) }}" method="POST">
                                            @csrf
                                            <select name="status">
                                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confermato</option>
                                                <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Annullato</option>
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>In attesa</option>
                                            </select>
                                            <button type="submit" class="text-red-500">Cambia Stato</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
