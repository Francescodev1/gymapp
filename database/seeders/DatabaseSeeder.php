<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Activity;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        // Creazione dell'utente amministratore
        User::factory()->create([
        'name' => 'Frank',
        'email' => 'frank@example.com',
        'password' => Hash::make('ciaociao'),
        'role' => 'admin',
    ]);

    // Creazione di 5 utenti fake
    User::factory(5)->create();

    // Creazione di 5 attività fake
    Activity::factory(5)->create();

    }
}
