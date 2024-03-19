<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'start_time' => $this->faker->time,
            'end_time' => $this->faker->time,
            'status' => 'pending',
        ];
        
    }
}
