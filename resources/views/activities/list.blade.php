@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center mb-12 text-gray-800">Attività Disponibili per la Prenotazione</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($activities as $activity)
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-2 text-blue-500">{{ $activity->name }}</h2>
                    <p class="text-gray-700 mb-4">{{ $activity->description }}</p>
                    <p class="text-gray-600 mb-2">Orario: {{ \Carbon\Carbon::parse($activity->schedule)->format('d/m/Y H:i') }}</p>
                    <p class="text-gray-600 mb-4">Posti disponibili: {{ $activity->max_participants - $activity->bookings->count() }}</p>
                    @auth
                        @if ($activity->bookings->where('user_id', auth()->id())->count() > 0)
                            <form action="{{ route('bookings.destroy', $activity->bookings->where('user_id', auth()->id())->first()->id) }}" method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition-colors duration-200">Annulla Prenotazione</button>
                            </form>
                        @else
                            <form action="{{ route('bookings.store') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                                <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition-colors duration-200">Prenota</button>
                            </form>
                        @endif
                    @else
                        <p class="mt-4 text-gray-600"><a href="{{ route('login') }}" class="text-green-500 hover:text-green-600 transition-colors duration-200">Accedi per prenotare</a></p>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
