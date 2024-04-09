@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-semibold mb-6">Attività Disponibili per la Prenotazione</h1>
    <ul>
        @foreach ($activities as $activity)
            <li class="mb-8 border-b pb-4">
                <h2 class="text-2xl font-semibold mb-2">{{ $activity->name }}</h2>
                <p class="text-gray-700">{{ $activity->description }}</p>
                <p class="text-gray-600">Orario: {{ $activity->schedule }}</p>
                <p class="text-gray-600">Posti disponibili: {{ $activity->max_participants - $activity->bookings->count() }}</p>
                @auth
                    @if ($activity->bookings->where('user_id', auth()->id())->count() > 0)
                        <form action="{{ route('bookings.destroy', $activity->bookings->where('user_id', auth()->id())->first()) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Annulla Prenotazione</button>
                        </form>
                    @else
                        <form action="{{ route('bookings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Prenota</button>
                        </form>
                    @endif
                @else
                    <p class="mt-4 text-gray-600"><a href="{{ route('login') }}">Accedi per prenotare</a></p>
                @endauth
            </li>
        @endforeach
    </ul>
</div>
@endsection
