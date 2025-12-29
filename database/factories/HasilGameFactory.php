<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HasilGameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        
        return [
            
            'jenis_game_id' => 1, 
            'skor' => $this->faker->numberBetween(50, 100),
            'total_poin' => $this->faker->numberBetween(100, 1000),
            'dimainkan_at' => now()->subDays($this->faker->numberBetween(0, 30)),
        ];
    }
}