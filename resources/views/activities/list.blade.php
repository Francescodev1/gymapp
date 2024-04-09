@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Attività Disponibili per la Prenotazione</h1>
    <ul>
        @foreach ($activities as $activity)
            <li>
                <h2>{{ $activity->name }}</h2>
                <p>{{ $activity->description }}</p>
                <p>Orario: {{ $activity->schedule }}</p>
                <p>Posti disponibili: {{ $activity->max_participants - $activity->bookings->count() }}</p>
                @auth
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                        <button type="submit" class="btn btn-primary">Prenota</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Accedi per prenotare</a>
                @endauth
            </li>
        @endforeach
    </ul>
</div>
@endsection
