@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold mb-4">Modifica Attività</h2>
            <form action="{{ route('activities.update', $activity->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo Nome -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                    <input type="text" name="name" id="name" value="{{ $activity->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <!-- Campo Descrizione -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descrizione:</label>
                    <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $activity->description }}</textarea>
                </div>

                <!-- Campo Orario -->
                <div class="mb-4">
                    <label for="schedule" class="block text-gray-700 text-sm font-bold mb-2">Orario:</label>
                    <input type="text" name="schedule" id="schedule" value="{{ $activity->schedule }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <!-- Campo Numero Massimo Partecipanti -->
                <div class="mb-4">
                    <label for="max_participants" class="block text-gray-700 text-sm font-bold mb-2">Numero Massimo Partecipanti:</label>
                    <input type="number" name="max_participants" id="max_participants" value="{{ $activity->max_participants }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Aggiorna</button>
            </form>
        </div>
    </div>
</div>
@endsection
