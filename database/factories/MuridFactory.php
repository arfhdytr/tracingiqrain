<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Murid>
 */
class MuridFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Kita ganti 'User::factory()' menjadi fungsi
            // yang membuat User secara manual (bypass factory)
            'user_id' => function () {
                return User::create([
                    'username' => $this->faker->unique()->userName(),
                    'password' => Hash::make('password'),
                    'avatar_path' => null
                ])->user_id; 
            },

            'sekolah' => $this->faker->company() . ' School',
            'preferensi_terisi' => false,
        ];
    }
}