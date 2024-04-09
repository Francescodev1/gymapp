@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Attività Disponibili</h2>
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('activities.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">Aggiungi Nuova Attività</a>
            </div>
            <div class="flex flex-col">
                <div class="align-middle inline-block min-w-full">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider whitespace-normal">Nome</th>
                                    <th scope="col" class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider whitespace-normal">Descrizione</th>
                                    <th scope="col" class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider whitespace-normal">Orario</th>
                                    <th scope="col" class="px-3 py-3 text-left font-medium text-gray-500 uppercase tracking-wider whitespace-normal">Azione</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($activities as $activity)
                                <tr>
                                    <td class="px-3 py-4 whitespace-normal text-sm font-medium text-gray-900">{{ $activity->name }}</td>
                                    <td class="px-3 py-4 whitespace-normal text-sm text-gray-500">{{ $activity->description }}</td>
                                    <td class="px-3 py-4 whitespace-normal text-sm text-gray-500">{{ $activity->date }} {{ $activity->time }}</td>
                                    <td class="px-3 py-4 whitespace-normal text-sm font-medium">
                                        <a href="{{ route('activities.edit', $activity->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifica</a>
                                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Sei sicuro?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Elimina</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
