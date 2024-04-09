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
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            // Genera una data e ora futura nel formato corretto
            'schedule' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d H:i:s'),
            'max_participants' => $this->faker->numberBetween(5, 10),
        ];
    }
}
