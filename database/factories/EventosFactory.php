<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'paciente_id' => fake()->randomDigit(),
            'profissional' => fake()->name(),
            'codproc' => fake()->randomDigit(),
            'observacoes' => '',
            'retorno' => fake()->boolean(),            
        ];
    }
}
