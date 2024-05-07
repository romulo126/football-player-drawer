<?php

namespace Database\Factories;

use App\Models\SoccerPlayer; // Certifique-se de que o modelo está correto
use Illuminate\Database\Eloquent\Factories\Factory;

class SoccerPlayerFactory extends Factory
{
    protected $model = SoccerPlayer::class; // O modelo que a fábrica representa

    public function definition()
    {
        return [
            // Definição dos atributos do modelo
            'name' => $this->faker->name,
            'skill_level' => $this->faker->numberBetween(1, 10),
            'goalkeeper' => $this->faker->boolean,
            'confirmed' => $this->faker->boolean
        ];
    }
}