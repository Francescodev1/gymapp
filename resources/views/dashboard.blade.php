<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <nav class="flex space-x-4">
            <a href="{{ route('dashboard') }}" class="text-gray-800 underline">Dashboard</a>
            <a href="{{ route('activities.index') }}" class="text-gray-800 underline">Attività</a>
            <a href="{{ route('bookings.index') }}" class="text-gray-800 underline">Prenotazioni</a>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
