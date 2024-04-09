<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Activity;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('now', '+2 years');

        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $date->format('Y-m-d'), // Ora puoi usare $date qui
            'time' => $this->faker->time('H:i'), // Genera un orario casuale
            'max_participants' => $this->faker->numberBetween(5, 20),
        ];
    }
}
