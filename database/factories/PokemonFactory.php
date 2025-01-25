<?php

namespace Database\Factories;

use App\Models\Pokemon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pokemon>
 */
class PokemonFactory extends Factory
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
            'type' => $this->faker->randomElement(['electric', 'fire', 'grass', 'water']),
            'height' => $this->faker->randomFloat(2, 0.1, 10),
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'url' => $this->faker->word
        ];
    }
}
